<?php

namespace app\service {

    class FlipKartService
    {
        private static $API = null;
        private static $BASE_URL = "https://affiliate-api.flipkart.net/affiliate";

        public static function configure()
        {
            $config = \Config::getSection("FLIPKART_CONFIG");
            self::$API = new Flipkart($config['API_KEY'], $config['API_SECRET'], "json");
        }

        /* Scrape the product details from the ecommerce paltform 
            Returns Json data */
        public static function getProductDetails($pid)
        {
            return self::$API->get(self::$BASE_URL . "/product/json",
                array(
                    "id" => $pid
                )
            );
        }
/*
Array
(
    [productBaseInfo] => Array
        (
            [productIdentifier] => Array
                (
                    [productId] => TOPEPC9JJHX9NWU8
                    [categoryPaths] => Array
                        (
                            [categoryPath] => Array
                                (
                                    [0] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [title] => Apparels>Women>Western Wear>Shirts, Tops & Tunics>Tops
                                                )

                                        )

                                )

                        )

                )

            [productAttributes] => Array
                (
                    [title] => The Vanca Casual Sleeveless Printed Women's Green Top
                    [productDescription] => Camoflage print top with ruffles on neckline
                    [imageUrls] => Array
                        (
                            [unknown] => http://img.fkcdn.com/image/top/6/u/g/tsf400903-the-vanca-xl-800-imaepc4axcqby53w.jpeg
                        )

                    [maximumRetailPrice] => Array
                        (
                            [amount] => 999
                            [currency] => INR
                        )

                    [sellingPrice] => Array
                        (
                            [amount] => 599
                            [currency] => INR
                        )

                    [productUrl] => https://dl.flipkart.com/dl/vanca-casual-sleeveless-printed-women-s-green-top/p/itmet7pvpwpngkqz?pid=TOPEPC9JJHX9NWU8&affid=kanlaltan
                    [productBrand] => The Vanca
                    [inStock] => 1
                    [isAvailable] => 1
                    [codAvailable] => 1
                    [emiAvailable] => 
                    [discountPercentage] => 58
                    [cashBack] => 
                    [offers] => Array
                        (
                        )

                    [size] => M
                    [color] => Green
                    [sizeUnit] => 
                    [sizeVariants] => [TOPEPC9JGRVRGCVW, TOPEPC9RNHQ9PAHT, TOPEPDBAMXY246UG, TOPEPC9JJHX9NWU8]
                    [colorVariants] => [TOPEPC9JGRVRGCVW, TOPEPDA4ZDZKP5XT, TOPEPDB6GHVT36PQ, TOPEPDBAMXY246UG, TOPEPDBAPNAV3SFB, TOPEPDBFAVQBRZ8W]
                    [styleCode] => 
                )

        )

    [productShippingBaseInfo] => Array
        (
            [shippingOptions] => 
        )

    [offset] => 
)
*/
         /* Get the Product details returned by getProductDetails function , Save it DB 
            Returns Product Bean  */
        public static function addProduct($url = null,$subid)
        {
            $productBean = null;
            if (!is_null($url) && !empty($url)) {
                $parsed = parse_url($url);
                $query = array();
                parse_str($parsed["query"], $query);
                $fkid = $query["pid"];
                $product = self::getProductDetails($fkid);
                print_r($product);

                \RudraX\Utils\FileUtil::build_write("source/fk/".$fkid.'.json', json_encode($product,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            $productBean = R::dispense('source');
            $productBean->subid   = $subid;
            $productBean->pid   = $fkid;
            $productBean->title = $product["productBaseInfo"]["productAttributes"]["title"];
            $productBean->url   = $product["productBaseInfo"]["productAttributes"]["productUrl"];
            $arrimg=$product['productBaseInfo']['productAttributes']['imageUrls'];
               // print_r($arrimg['unknown']);die;
                 if (array_key_exists('400x400', $arrimg)) {
                    $productBean->image = $arrimg['400x400'];
                } else if (array_key_exists('200x200', $arrimg)) {
                    $productBean->image = $arrimg["200x200"];
                } else if (array_key_exists('unknown', $arrimg)) {
                    $productBean->image = $arrimg["unknown"];
                }
            $productBean->description=$product["productBaseInfo"]["productAttributes"]["productDescription"];;


                $host=R::findOneOrDispense('host','title=?',array("flipkart"));
                $host->title="flipkart";
                R::store($host);
            $productBean->hostid = $host->id;

            if(!is_null($product["productBaseInfo"]["productAttributes"]["productBrand"])) {
                $brand=R::findOneOrDispense('brand','title=?',array($product["productBaseInfo"]["productAttributes"]["productBrand"]));
                $brand->title=$product["productBaseInfo"]["productAttributes"]["productBrand"];
                R::store($brand);
            $productBean->brandid = $brand->id;
            }
            
            if(!is_null(trim($product["productBaseInfo"]["productAttributes"]["sellingPrice"]["currency"]))){
                $currency=R::findOneOrDispense('currency','title=?',array($product["productBaseInfo"]["productAttributes"]["sellingPrice"]["currency"]));
                $currency->title=$product["productBaseInfo"]["productAttributes"]["sellingPrice"]["currency"];
                R::store($currency);
            $productBean->currencyid = $currency->id;
            }
            
           
            
                $price=R::dispense('price');
                $price->price=$product["productBaseInfo"]["productAttributes"]["sellingPrice"]["amount"];
                $price->mrp=$product["productBaseInfo"]["productAttributes"]["maximumRetailPrice"]["amount"];
                R::store($price);
            $productBean->priceid = $price->id;

            // $sex,$family,$category,$size,$color;

                $cats = $product["productBaseInfo"]["productIdentifier"]["categoryPaths"]["categoryPath"][0][0]['title'];
                $cats=explode('>',$cats);
          
            $sex = $cats[1];
            $category1 = $cats[0];
            $family1= $cats[count($cats)-1];


            $productBean->sex=$sex;

            if(!is_null(trim($category1))){
                $category=R::findOneOrDispense('category','title=?',array($category1));
                $category->title=$category1;
                R::store($category);
            $productBean->categoryid = $category->id;
            }

                $family=R::findOneOrDispense('family','title=?',array($family1));
                $family->title=$family1;
                R::store($family);
            $productBean->familyid = $family->id;


            // if(!is_null(trim($product->seller))){
            //     $seller=R::findOneOrDispense('seller','title=?',array($product->seller));
            //     $seller->title=$product->seller;
            //     R::store($seller);
            // $productBean->sellerid = $seller->id;
            // }


            $id = R::store($productBean);
                // foreach($product->size as $key=>$value){
                    $size=R::findOneOrDispense('size','title=?',array($product["productBaseInfo"]["productAttributes"]['size']));
                    $size->title=$product["productBaseInfo"]["productAttributes"]['size'];
                    R::store($size);
                    $sourcesize=R::dispense('sourcesize');
                    $sourcesize->srcid=$id;
                    $sourcesize->sizeid=$size->id;
                    R::store($sourcesize);
                // }
                // foreach($product->color as $key=>$value){
                    $color=R::findOneOrDispense('color','title=?',array($product["productBaseInfo"]["productAttributes"]['color']));
                    $color->title=$product["productBaseInfo"]["productAttributes"]['color'];
                    R::store($color);
                    $sourcecolor=R::dispense('sourcecolor');
                    $sourcecolor->srcid=$id;
                    $sourcecolor->colorid=$color->id;
                    R::store($sourcecolor);
                // }
/*
                $productBean = R::dispense("source");
                $productBean->pid = $fkid;
                $cats = $product["productBaseInfo"]["productIdentifier"]["categoryPaths"]["categoryPath"][0];

                foreach ($cats as $index => $cat) {
                    $category = R::findOneOrDispense("category", "title=?", array($cat["title"]));
                    $category->title = $cat["title"];
                    $productBean->sharedCategoryList[] = $category;
                }

                $productBean->title = $product["productBaseInfo"]["productAttributes"]["title"];
                $productBean->description = $product["productBaseInfo"]["productAttributes"]["productDescription"];

                $imageUrls = $product['productBaseInfo']['productAttributes']['imageUrls'];

                if (array_key_exists('400x400', $imageUrls)) {
                    $productBean->image = $imageUrls["400x400"];
                } else if (array_key_exists('200x200', $imageUrls)) {
                    $productBean->image = $imageUrls["200x200"];
                } else if (array_key_exists('unknown', $imageUrls)) {
                    $productBean->image = $imageUrls["unknown"];
                }

 //               exit(json_encode($imageUrls));

                $productBean->price = $product["productBaseInfo"]["productAttributes"]["sellingPrice"]["amount"];
                $productBean->currency = $product["productBaseInfo"]["productAttributes"]["sellingPrice"]["currency"];
                $productBean->url = $product["productBaseInfo"]["productAttributes"]["productUrl"];

                $brand_title = $product["productBaseInfo"]["productAttributes"]["productBrand"];
                $brand = R::findOneOrDispense("brand", "title=?", array($brand_title));
                $brand->title = $brand_title;
                $productBean->brand = $brand;

//                if (!isset($productBean->family_id) || empty($productBean->family_id)) {
//                    $productBean->family = $family;
//                    $family_id = $family->id;
//                } else if (!is_null($family_id)) {
//                    $productBean->family = $family;
//                    $family_id = $family->id;
//                } else {
//                    $family_id = $productBean->family_id;
//                }
                R::store($productBean);
            }
*/
            }
            return $productBean;
        }

        /* Scrape the Product list from E-Commerce Platform on the basis of $searchkey
            Returns Json (product list) */
        public static function searchProduct($searchkey)
        {
            $searchlist = (self::$API->get(self::$BASE_URL . "/search/json", array('query'=>$searchkey,'resultCount'=>10)));

// print_r($searchlist);die;
            for($i=0; $i<10; $i++){
               $title[] = $searchlist['productInfoList'][$i]['productBaseInfo']['productAttributes']['title']; 
               $src[] = $searchlist['productInfoList'][$i]['productBaseInfo']['productAttributes']['imageUrls']['unknown'];
               $price[] = $searchlist['productInfoList'][$i]['productBaseInfo']['productAttributes']['sellingPrice']['amount']; 
               $priceoriginal[] = $searchlist['productInfoList'][$i]['productBaseInfo']['productAttributes']['maximumRetailPrice']['amount']; 
               $link[] = $searchlist['productInfoList'][$i]['productBaseInfo']['productAttributes']['productUrl']; 
               $size[] = $searchlist['productInfoList'][$i]['productBaseInfo']['productAttributes']['size']; 
               $brand[] = $searchlist['productInfoList'][$i]['productBaseInfo']['productAttributes']['productBrand']; 
            }


            $product['title']   = $title;
            $product['src']     = $src;
            $product['price']   = $price;
            $product['priceoriginal']   = $priceoriginal;
            $product['link']    = $link;
            $product['size']    = $size;
            $product['brand']    = $brand;

// print_r($product);die;
            $product_json=json_encode($product);

            return $product_json;
        }

    }

    FlipKartService::configure();

}

