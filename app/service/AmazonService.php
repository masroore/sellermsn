<?php

namespace app\service {

    use ApaiIO\Configuration\GenericConfiguration;
    use ApaiIO\Operations\Lookup;
    use ApaiIO\ApaiIO;
    use ApaiIO\Operations\Search;

    class AmazonService
    {
        private static $API = null;
        private static $BASE_URL = "https://affiliate-api.flipkart.net/affiliate";


        public static function configure()
        {
            $config = \Config::getSection("AMAZON_CONFIG");
            $conf = new GenericConfiguration();
            //$client = new \GuzzleHttp\Client();
            //$request = new \ApaiIO\Request\GuzzleRequest($client);

            $conf
                ->setCountry('in')
                ->setAccessKey($config['API_KEY'])
                ->setSecretKey($config['API_SECRET'])
                ->setAssociateTag($config['ASSOCIATE_TAG'])
                ->setResponseTransformer('\ApaiIO\ResponseTransformer\XmlToSimpleXmlObject');
            // ->setRequest($request);
            self::$API = new ApaiIO($conf);
        }

        /* Scrape the product details from the ecommerce paltform 
            Returns Json data */
        public static function getProductDetails($pid)
        {
            $lookup = new Lookup();
            $lookup->setItemId($pid);
            $lookup->setResponseGroup(array('Large', 'Small'));
            $formattedResponse = self::$API->runOperation($lookup);
            return json_decode(json_encode($formattedResponse), true);
        }

         /* Get the Product details returned by getProductDetails function , Save it DB 
            Returns Product Bean  */
        public static function addProduct($url = null, $subid)
        {
            $productBean = null;
            if (!is_null($url) && !empty($url)) {
                $parsed = parse_url($url);
                $query = array();
                $amzid = null;
                if (preg_match("/\/(.*)\/(dp)\/(.*)\/(.*)/", $parsed["path"], $query) == 1) {
                    $amzid = $query["3"];
                } else if (preg_match("/\/(.*)\/(dp)\/(.*)/", $parsed["path"], $query) == 1) {
                    $amzid = $query["3"];
                }
                $product = self::getProductDetails($amzid);
                // echo '<pre>';
                // print_r($product); die;

                \RudraX\Utils\FileUtil::build_write("source/amz/".$amzid.'.json', json_encode($product,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            $productBean = R::dispense('source');
            $productBean->subid   = $subid;
            $productBean->pid   = $amzid;
            $productBean->title = $product["Items"]["Item"]["ItemAttributes"]["Title"];
            $productBean->url   = $product["Items"]["Item"]["DetailPageURL"];
            $productBean->image = $product["Items"]["Item"]["LargeImage"]["URL"];
            $productBean->description=implode(";", $product["Items"]["Item"]["ItemAttributes"]["Feature"]);


            $productBean->sex=$product["Items"]["Item"]["ItemAttributes"]["Department"];

                $host=R::findOneOrDispense('host','title=?',array("amazon"));
                $host->title="amazon";
                R::store($host);
            $productBean->hostid = $host->id;

            if(!is_null(trim($product["Items"]["Item"]["ItemAttributes"]["Brand"]))){
                $brand=R::findOneOrDispense('brand','title=?',array($product["Items"]["Item"]["ItemAttributes"]["Brand"]));
                $brand->title=$product["Items"]["Item"]["ItemAttributes"]["Brand"];
                R::store($brand);
            $productBean->brandid = $brand->id;
            }

            if(!is_null(trim($product["Items"]["Item"]['OfferSummary']['LowestNewPrice']['CurrencyCode']))){
                $currency=R::findOneOrDispense('currency','title=?',array($product["Items"]["Item"]['OfferSummary']['LowestNewPrice']['CurrencyCode']));
                $currency->title=$product["Items"]["Item"]['OfferSummary']['LowestNewPrice']['CurrencyCode'];
                R::store($currency);
            $productBean->currencyid = $currency->id;
            }

                $price=R::dispense('price');
                $price->price=$product["Items"]["Item"]['OfferSummary']['LowestNewPrice']['Amount'] / 100;
                $price->mrp=$product["Items"]["Item"]["ItemAttributes"]['ListPrice']['Amount'] / 100;
                R::store($price);
            $productBean->priceid = $price->id;

                $family=R::findOneOrDispense('family','title=?',array($product["Items"]["Item"]["ItemAttributes"]["ProductTypeName"]));
                $family->title=$product["Items"]["Item"]["ItemAttributes"]["ProductTypeName"];
                R::store($family);
            $productBean->familyid = $family->id;

            if(!is_null(trim($product["Items"]["Item"]["ItemAttributes"]["ProductGroup"]))){
                $category=R::findOneOrDispense('category','title=?',array($product["Items"]["Item"]["ItemAttributes"]["ProductGroup"]));//Binding in place of ProductGroup can also be used
                $category->title=$product["Items"]["Item"]["ItemAttributes"]["ProductGroup"];
                R::store($category);
            $productBean->categoryid = $category->id;
            }

            if(!is_null(trim($product["Items"]["Item"]["ItemAttributes"]["Manufacturer"]))){
                $seller=R::findOneOrDispense('seller','title=?',array($product["Items"]["Item"]["ItemAttributes"]["Manufacturer"]));
                $seller->title=$product["Items"]["Item"]["ItemAttributes"]["Manufacturer"];
                R::store($seller);
            $productBean->sellerid = $seller->id;
            }


            $id = R::store($productBean);

                foreach($product->size as $key=>$value){
                    $size=R::findOneOrDispense('size','title=?',array($value));
                    $size->title=$value;
                    R::store($size);
                    $sourcesize=R::dispense('sourcesize');
                    $sourcesize->srcid=$id;
                    $sourcesize->sizeid=$size->id;
                    R::store($sourcesize);
                }
                echo $product["Items"]["Item"]["ItemAttributes"]["Color"];
                // foreach($product->color as $key=>$value){
                    $color=R::findOneOrDispense('color','title=?',array($product["Items"]["Item"]["ItemAttributes"]["Color"]));
                    $color->title=$product["Items"]["Item"]["ItemAttributes"]["Color"];
                    R::store($color);
                    $sourcecolor=R::dispense('sourcecolor');
                    $sourcecolor->srcid=$id;
                    $sourcecolor->colorid=$color->id;
                    R::store($sourcecolor);
                // }
                // echo '<pre>';
            // print_r(json_decode(json_encode($productBean)));die;
            return $productBean;

            }
        }

        /* Scrape the Product list from E-Commerce Platform on the basis of $searchkey
            Returns Json (product list) */
        public static function searchProduct($searchkey)
        {

            $search = new Search();
            $search->setCategory('All');
            $search->setResponseGroup(array('Large', 'Small'));
            $search->setKeywords($searchkey);

            $formattedResponse = self::$API->runOperation($search);
            $response = json_decode(json_encode($formattedResponse), true);
            // print_r ($response); 

            foreach ($response['Items']['Item'] as $key=>$p) {
                $title[] = $p['ItemAttributes']['Title'];
                $src[]   = $p['LargeImage']['URL'];
                $price[] = $p['OfferSummary']['LowestNewPrice']['Amount'] / 100;
                $priceoriginal[] = $p['ItemAttributes']['ListPrice']['Amount'] / 100;
                $link[]  = $p['DetailPageURL'];
                $size[]  = $p['ItemAttributes']['ClothingSize'];
                $brand[] = $p['ItemAttributes']['Brand'];

                if($key==50){
                    break;
                }
            }

            $product['title']   = $title;
            $product['src']     = $src;
            $product['price']   = $price;
            $product['priceoriginal']   = $priceoriginal;
            $product['link']    = $link;
            $product['size']    = $size;
            $product['brand']    = $brand;

            // print_r($product);


            $product_json=json_encode($product);

            return $product_json;

           
            //All','Beauty','Grocery','Industrial','PetSupplies','OfficeProducts','Electronics','Watches','Jewelry','Luggage','Shoes','Furniture','KindleStore','Automotive','Pantry','MusicalInstruments','GiftCards','Toys','SportingGoods','PCHardware','Books','LuxuryBeauty','Baby','HomeGarden','VideoGames','Apparel','Marketplace','DVD','Appliances','Music','LawnAndGarden','HealthPersonalCare','Software' 
            
        }

    }

    AmazonService::configure();

}

