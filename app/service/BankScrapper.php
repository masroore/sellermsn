<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 28/07/17
 * Time: 10:56 PM
 */

namespace app\service {

    use app\model\BasicModel;
    use app\model\Contact;
    use app\model\geo\City;
    use app\model\ScrapURL;
    use app\model\bank\Bank;
    use app\model\bank\Branch;
    use app\model\geo\District;
    use app\model\geo\State;
    use Goutte\Client;
    use GuzzleHttp\Client as GuzzleClient;
    use Doctrine\Common\Cache\FilesystemCache;
    use GuzzleHttp\HandlerStack;
    use Kevinrob\GuzzleCache\CacheMiddleware;
    use Kevinrob\GuzzleCache\KeyValueHttpHeader;
    use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
    use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;


    class BankScrapper
    {
        /**
         * @var Client
         */
        public static $client = null;

        public static function configure()
        {
            $goutteClient = new Client();

            $stack = HandlerStack::create();
            $stack->push(new CacheMiddleware(
                new GreedyCacheStrategy(
                    new DoctrineCacheStorage(
                        new FilesystemCache(BUILD_PATH . 'pincode_html/')
                    ),
                    1800, // the TTL in seconds
                    new KeyValueHttpHeader(['Authorization']) // Optionnal - specify the headers that can change the cache key
                )
            ), 'greedy-cache');

            $guzzleClient = new GuzzleClient(array(
                'timeout' => 60,
                'handler' => $stack
            ));
            $goutteClient->setClient($guzzleClient);
            self::$client = $goutteClient;

        }


        public static $BNKIFSCCDNUM = "/https?:\/\/bankifscpincodenumber\.com\/BankIFSC\/(.*)/";
        public static $BNKIFSCCDNUM_MAP = "/https?:\/\/maps\.googleapis\.com\/maps\/.*\&markers=([0-9\.]+),\ ([0-9\.]+)\&(.*)/";
        //https://maps.googleapis.com/maps/api/staticmap?center=75, Rehmat Manzil, Veer Nariman Road, Churchgate, Mumbai - 400020&zoom=12&size=600x300&maptype=roadmap&key=AIzaSyDRzCH4f8ftY_yw6xRiTW67gpJFDUUY5Tk&markers=18.9328172, 72.8269253&scale=3&feature:all

        public static $GETPINCODE = "/https?:\/\/(.*)getpincode\.info\/(.*)/";


        public static function scrapById($id)
        {
            $scrapurl = R::load("scrapurl", $id);
            if (!empty($scrapurl)) {
                return self::scrap($scrapurl->url);
            }
        }


        public static function saveBranch($detail)
        {
            $state = State::byName($detail["state"]);
            if (empty($state)) {
                return false;
            }
            $district = District::byName($detail["district"], $state->bean()->id);
            if (empty($district)) {
                return false;
            }
            $bank = Bank::byName($detail["bank"]);
            if (empty($bank)) {
                return false;
            }

            $branch = Branch::byIFSC($detail["ifsc"]);
            if (empty($branch)) {
                return false;
            }

            $branch->bean()->bank = $bank->bean();
            $branch->bean()->state = $state->bean();
            $branch->bean()->district = $district->bean();
            $branch->bean()->contact = $detail["contact"];
            $branch->bean()->address = $detail["address"];
            $branch->bean()->ifsc = $detail["ifsc"];
            $branch->bean()->micr = $detail["micr"];
            $branch->bean()->lat = $detail["lat"];
            $branch->bean()->long = $detail["long"];
            $branch->buildSearch();
            $branch->save();
        }

        public static function scrap($url)
        {
            $urlbean = R::findOneOrDispense("scrapurl", "url=?", array($url));

            if (!empty($urlbean->scrapped)) {
                return true;
            }

            $crawler = self::$client->request('GET', $url);


            if (self::$client->getResponse()->getStatus() != "200") {

                return false;
            }

            $match = array();
            if (preg_match(self::$BNKIFSCCDNUM, $url, $match) == 1) {
                $detail = array();
                $crawler->filter('#searchResult>div')->each(function ($node) use (&$detail) {

                    $p = $node->filter("p");

                    if (empty($p) || empty($p->count())) {
                        return;
                    }
                    $label = trim($p->text());

                    if ($label == "Bank:") {
                        $detail["bank"] = $p->nextAll()->text();
                    } else if ($label == "State:") {
                        $detail["state"] = $p->nextAll()->text();
                    } else if ($label == "District:") {
                        $detail["district"] = $p->nextAll()->text();
                    } else if ($label == "Branch:") {
                        $detail["branch"] = $p->nextAll()->text();
                    } else if ($label == "Contact:") {
                        $detail["contact"] = $p->nextAll()->text();
                    } else if ($label == "Address:") {
                        $detail["address"] = $p->nextAll()->text();
                    } else if ($label == "IFSC Code:") {
                        $detail["ifsc"] = $p->nextAll()->text();
                    } else if ($label == "MICR Code:") {
                        $detail["micr"] = $p->nextAll()->text();
                    }
                });

                $img = $crawler->filter('#searchResult>img');
                if (!empty($img) && !empty($img->count())) {
                    $matchimg = array();
                    if (preg_match(self::$BNKIFSCCDNUM_MAP, $img->attr("src"), $matchimg) == 1) {
                        $detail["lat"] = $matchimg[1];
                        $detail["long"] = $matchimg[2];
                    }
                }


                self::saveBranch($detail);

                $crawler->filter('#Msg a')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("href"), $anchor->text());;
                });
                $crawler->filter('#DdlBanks option')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("value"), $anchor->text());
                });
                $crawler->filter('#DDlState option')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("value"), $anchor->text());
                });
                $crawler->filter('#DDlDISTRICT option')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("value"), $anchor->text());
                });
                $crawler->filter('#DDlBranch_Name option')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("value"), $anchor->text());
                });
                $crawler->filter('#searchResult a')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("href"), $anchor->text());
                });

            } else if (preg_match(self::$GETPINCODE, $url, $match) == 1) {

            } else {
                return false;
            }

            $urlbean->url = $url;
            $urlbean->scrapped = true;
            $urlbean->context = "BANKIFSC";
            return R::store($urlbean);

        }

        public static function saveNextUrl($url, $text)
        {
            $match = null;
            if (preg_match(self::$BNKIFSCCDNUM, $url, $match) == 1) {
                return ScrapURL::byURL($url, $text, ScrapURL::$CONTEXT_BANK);
            }
        }

        public static function scrapRBIdata($ifsc_code)
        {
            $res = RazorPayService::lookupIFSC($ifsc_code);

            $bank = Bank::byName($res->BANK);
            if (empty($bank)) {
                return false;
            } else {
                //$bank
            }

            $state = State::byName($res->STATE);
            if (empty($state)) {
                return false;
            }
            $district = District::byName($res->DISTRICT, $state->bean()->id);
            if (empty($district)) {
                return false;
            }

            $city = City::byName($res->CITY, $state);
            if (empty($city)) {
                return false;
            }

            $branch = Branch::byIFSC($ifsc_code);
            if (empty($branch)) {
                return false;
            }

            if (empty($branch->bean()->title)) {
                $branch->bean()->title = $res->BRANCH;
            }
            if (empty($branch->bean()->bank)) {
                $branch->bean()->bank = $bank->bean();
            }
            if (empty($branch->bean()->state)) {
                $branch->bean()->state = $state->bean();
            }
            if (empty($branch->bean()->district)) {
                $branch->bean()->district = $district->bean();
            }
            if (empty($branch->bean()->city)) {
                $branch->bean()->city = $city->bean();
            }
            if (empty($branch->bean()->contact)) {
                $branch->bean()->contact = $res->CONTACT;
            } else if (!$res->CONTACT) {
                $contact = Contact::byName($res->CONTACT);
                if (!empty($contact)) {
                    $res->sharedContactList[] = $res->CONTACT;
                }
            }
            if (empty($branch->bean()->address)) {
                $branch->bean()->address = $res->ADDRESS;
            } else if (!$res->ADDRESS) {
                $address = BasicModel::byBeanTitle("address", $res->ADDRESS);
                if (!empty($address)) {
                    $res->sharedAddressList[] = $res->ADDRESS;
                }
            }
            $branch->bean()->rbi = TRUE;
            $branch->buildSearch();
            $branch->save();
        }

    }

    BankScrapper::configure();

}