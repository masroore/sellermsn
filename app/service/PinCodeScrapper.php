<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 28/07/17
 * Time: 10:56 PM
 */

namespace app\service {

    use app\model\BasicModel;
    use app\model\geo\District;
    use app\model\geo\DistrictRegion;
    use app\model\geo\Pincode;
    use app\model\geo\PostalArea;
    use app\model\geo\PostOffice;
    use app\model\geo\State;
    use app\model\geo\StateCircle;
    use app\model\geo\Taluk;
    use app\model\geo\TalukDivision;
    use app\model\ScrapURL;
    use Goutte\Client;
    use GuzzleHttp\Client as GuzzleClient;
    use Doctrine\Common\Cache\FilesystemCache;
    use GuzzleHttp\HandlerStack;
    use Kevinrob\GuzzleCache\CacheMiddleware;
    use Kevinrob\GuzzleCache\KeyValueHttpHeader;
    use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
    use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;


    class PinCodeScrapper
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


        public static $BNKIFSCCDNUM = "/https?:\/\/bankifscpincodenumber\.com\/(.*)\.html/";
        public static $GETPINCODE = "/https?:\/\/(.*)getpincode\.info\/(.*)/";
        public static $MAPSOFINDIA = "/https?:\/\/(.*)mapsofindia\.com\/pincode\/(.*)/";
        public static $MAPSOFINDIA_DISTRICT = "/https?:\/\/(.*)mapsofindia\.com\/pincode\/([\w\-_]+)\/([\w\-_]+)\/([\w-_]+)\//";


        public static function scrapById($id)
        {
            $scrapurl = R::load("scrapurl", $id);
            if (!empty($scrapurl)) {
                return self::scrap($scrapurl->url);
            }
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
                $state_text = $crawler->filter('#BackDisplay a')->nextAll()->text();

                if (!empty($state_text)) {
                    $pincode_text = str_replace("Other result of pin code", "", $crawler->filter('#OtherResult>h2')->text());
                    $postalArea_text = $crawler->filter('#hidAddress')->attr("value");
                    $state = State::byName($state_text);
                    $pincode = Pincode::byCode($pincode_text)->setState($state)->save();

                    $postalArea = PostalArea::byName($postalArea_text, $pincode);

                    $crawler->filter('#OtherResult tbody tr')->each(function ($tr) {

                        $tds = $tr->filter("td");
                        $state_text = $tds->text();

                        $tds = $tds->nextAll();
                        $postalArea_text = $tds->text();

                        $tds = $tds->nextAll();
                        $pincode_text = $tds->text();

                        $state = State::byName($state_text);
                        $pincode = Pincode::byCode($pincode_text)->setState($state)->save();

                        $postalArea = PostalArea::byName($postalArea_text, $pincode);
                        $postalArea->buildSearch()->save();

                    });
                }

                $crawler->filter('#DisplyPostalCircle a')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("href"),$anchor->text());
                });
                $crawler->filter('#TopResult a')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("href"),$anchor->text());
                });

            } else if (preg_match(self::$GETPINCODE, $url, $match) == 1) {

            } else if (preg_match(self::$MAPSOFINDIA, $url, $match) == 1) {

                if (preg_match(self::$MAPSOFINDIA_DISTRICT, $url, $match)) {

                    $tr = $crawler->filter('.table_hide .extrtable tr');
                    $tr0 = $tr->first();
                    $tds = $tr0->filter("td");

                    if ($tds->count() == 4 && trim($tds->text()) == "Location") {

                        $tr->nextAll()->each(function ($tr) {

                            $tds = $tr->filter("td");
                            $postalArea_text = $tds->text();
                            $tds = $tds->nextAll();
                            $pincode_text = $tds->text();
                            $tds = $tds->nextAll();
                            $state_text = $tds->text();
                            $tds = $tds->nextAll();
                            $district_text = $tds->text();

                            $state = State::byName($state_text);
                            $district = District::byName($district_text, $state);

                            $pincode = Pincode::byCode($pincode_text)->setState($state, $district)->save();
                            $postalArea = PostalArea::byName($postalArea_text, $pincode);

                            $postalArea->buildSearch()->save();

                        });
                    }
                }

                $crawler->filter('a')->each(function ($anchor) {
                    self::saveNextUrl($anchor->attr("href"),$anchor->text());
                });


            } else {
                return false;
            }

            $urlbean->url = $url;
            $urlbean->scrapped = true;
            $urlbean->context = "PINCODE";
            return R::store($urlbean);

        }


        public function getPostOffice($pincode)
        {
            $pincodeModel = Pincode::byCode($pincode);


            if (empty($pincodeModel->bean()->ownPostofficeList)) {
                $records = GovDataService::fetchPostOfficeByPincode($pincode);

                foreach ($records as $record) {

                    $postOffice = PostOffice::byName($record->officename, $pincodeModel);
                    $postOffice->bean()->type = $record->officeType;
                    $postOffice->bean()->delivery_status = $record->Deliverystatus;

                    $state = State::byName($record->statename);
                    $district = District::byName($record->Districtname, $state);
                    $taluk = Taluk::byName($record->Taluk, $district);

                    $postOffice->set($taluk);

                    $circle = StateCircle::byName($record->circlename);
                    $region = DistrictRegion::byName($record->regionname, $circle);
                    $talukdivision = TalukDivision::byName($record->divisionname, $region);

                    $postOffice->set($talukdivision);

                    $postOffice->save();

                }

            }

            return $pincodeModel->bean()->ownPostofficeList;

        }


        public static function saveNextUrl($url, $text)
        {
            $match = null;
            if (preg_match(self::$BNKIFSCCDNUM, $url, $match) == 1
                || preg_match(self::$MAPSOFINDIA, $url, $match) == 1
            ) {
                return ScrapURL::byURL($url, $text, ScrapURL::$CONTEXT_PINCODE);
            }
        }


    }

    PinCodeScrapper::configure();

}