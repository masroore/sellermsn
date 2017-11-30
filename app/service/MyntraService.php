<?php

namespace app\service {

use Goutte\Client;

    class MyntraService
    {
        private static $BASE_URL = "https://myntra.com/";

        public static function configure()
        {

        }

        /* Scrape the product details from the ecommerce paltform 
            Returns Json data */
        public static function getProductDetails($pid)
        {
        	$url = self::$BASE_URL.$pid;

            $client = new Client();
            $crawler = $client->request('GET',$url);
             sleep(3);
            $data = $crawler->filter('body > script:nth-child(5)')->extract('_text');
            $data[0]=str_replace("window.__myx = ", "", $data[0]);
            $obj=json_decode($data[0]);

        // print_r($obj);die;

			$title = $obj->pdpData->name;
            $brand = $obj->pdpData->brand->name;
            $price = $obj->pdpData->price->discounted;
            $mrp   =$obj->pdpData->price->mrp;
            $currency="";
            $family = $obj->pdpData->analytics->articleType;

            $height =640; $qualityPercentage=90; $width=480;
            $image  = $obj->pdpData->media->albums[0]->images[0]->src;
// echo '<hr>'.$image .'<hr>';
 $image=str_replace("(\$height)",$height,$image);
 $image=str_replace("(\$qualityPercentage)",$qualityPercentage,$image);
 $image=str_replace("(\$width)",$width,$image);

// die;
            $category = $obj->pdpData->analytics->masterCategory;
            $gender = $obj->pdpData->analytics->gender;
            $seller = $obj->pdpData->sizes[0]->seller;

            $size  = array();
                foreach ($obj->pdpData->sizes as $key=>$value) {
                	$size[]=$value->label;
                }
            $color = array();
                foreach ($obj->pdpData->colours as $key=>$value) {
                    $color[]=$value->label;;
                }

                $description = array();
                foreach ($obj->pdpData->descriptors as $key=>$value) {
                    $description[]=$value->title.':'.$value->description;
                }
            $description=implode(';',$description);


            $product['title']   = $title;
            $product['brand']   = $brand;
            $product['description']= $description;
            $product['image']   = $image;
            $product['price']   = $price;
            $product['mrp']     = $mrp;
            $product['currency']= $currency;
            $product['size']    = $size;
            $product['color']   = $color;
            $product['sex']     = $gender;
            $product['family']  = $family;
            $product['category']= $category;
            $product['seller']  = $seller;

// print_r($product);die;
            return json_encode($product);
	    }



        /* Get the Product details returned by getProductDetails function , Save it DB 
            Returns Product Bean  */
        public static function addProduct($url = null,$subid)
        {
            $pid =  self::fetchProductIdFromUrl($url);
            $product = json_decode(self::getProductDetails($pid));

            $productBean = R::dispense('source');
            $productBean->subid   = $subid;
            $productBean->pid   = $pid;
            $productBean->title = $product->title;
            $productBean->url   = $url;
            $productBean->image = $product->image;
            $productBean->description=$product->description;
            $productBean->sex=$product->sex;

                $host=R::findOneOrDispense('host','title=?',array("myntra"));
                $host->title="myntra";
                R::store($host);
            $productBean->hostid = $host->id;

            if(!is_null(trim($product->brand))){
                $brand=R::findOneOrDispense('brand','title=?',array($product->brand));
                $brand->title=$product->brand;
                R::store($brand);
            $productBean->brandid = $brand->id;
            }

            if(!is_null(trim($product->currency))){
                $currency=R::findOneOrDispense('currency','title=?',array($product->currency));
                $currency->title=$product->currency;
                R::store($currency);
            $productBean->currencyid = $currency->id;
            }

                $price=R::dispense('price');
                $price->price=$product->price;
                $price->mrp=$product->mrp;
                R::store($price);
            $productBean->priceid = $price->id;

                $family=R::findOneOrDispense('family','title=?',array($product->family));
                $family->title=$product->family;
                R::store($family);
            $productBean->familyid = $family->id;

            if(!is_null(trim($product->category))){
                $category=R::findOneOrDispense('category','title=?',array($product->category));
                $category->title=$product->category;
                R::store($category);
            $productBean->categoryid = $category->id;
            }

            if(!is_null(trim($product->seller))){
                $seller=R::findOneOrDispense('seller','title=?',array($product->seller));
                $seller->title=$product->seller;
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
                foreach($product->color as $key=>$value){
                    $color=R::findOneOrDispense('color','title=?',array($value));
                    $color->title=$value;
                    R::store($color);
                    $sourcecolor=R::dispense('sourcecolor');
                    $sourcecolor->srcid=$id;
                    $sourcecolor->colorid=$color->id;
                    R::store($sourcecolor);
                }
            return $productBean;


        }
        /* Finds the Product Id from the url
            Returns String */
        public static function fetchProductIdFromUrl($url=null)//for Myntra
        {
            if(empty(trim($url)) || is_null($url))
            {
                echo "Empty Url";
                return 0;
            }
            $pid = parse_url($url, PHP_URL_PATH);

            $p=explode("-", $pid);
            // print_r($p);
            preg_match("![0-9]+!", $p[count($p)-1], $pid);

            if(is_null($pid[0]))
            {
                echo "Id not found";
                exit();
                return 0;
            }
            // echo $pid[0];die;

            return $pid[0];
        }

        /* Scrape the Product list from E-Commerce Platform on the basis of $searchkey
            Returns Json (product list) */
        public static function searchProduct($searchkey)
        {
            // https://www.myntra.com/blue-jeans
            $url = self::$BASE_URL.$searchkey;
            // echo $url; die;

            $client  = new Client();
            $crawler = $client->request('GET', $url);
            sleep(3);

            $data = $crawler->filter('script')->extract('_text');
            $data1=str_replace("window.__myx = ", "", $data[8]);
            $obj=json_decode($data1);

            // print_r($obj);


            foreach ($obj->searchData->results->products as $key=>$p) {
                $title[] = $p->stylename;
                $src[]   = $p->search_image;
                $price[] = $p->discount;
                $priceoriginal[] = $p->price;
                $link[]  = self::$BASE_URL.$p->dre_landing_page_url;
                $size[]  = $p->sizes;
                $brand[] = $p->brands_filter_facet;

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

            // print_r($product);die;


            $product_json=json_encode($product);

            return $product_json;
        }

    }
}
                                    // [discount] => 1079
                                    // [brands_filter_facet] => INVICTUS
                                    // [search_image] => http://myntra.myntassets.com/assets/images/1940919/2017/7/11/11499774926986-INVICTUS-Men-Navy-Blue-Slim-Fit-Printed-Formal-Shirt-8411499774926848-1.jpg
                                    // [discounted_price] => 719
                                    // [gender_from_cms] => Men
                                    // [score] => 1
                                    // [sizes] => 38,39,40,42,44
                                    // [price] => 1799
                                    // [product_additional_info] => Men Slim Fit Formal Shirt
                                    // [stylename] => INVICTUS Men Navy Blue Slim Fit Printed Formal Shirt
                                    // [id] => 0_style_1940919
                                    // [style_store1_sort_field] => 372030
                                    // [product] => INVICTUS Men Navy Blue Slim Fit Printed Formal Shirt
                                    // [dre_landing_page_url] => Shirts/INVICTUS/INVICTUS-Men-Navy-Blue-Slim-Fit-Printed-Formal-Shirt/1940919/buy
                                    // [global_attr_article_type] => Shirts
                                    // [global_attr_brand] => INVICTUS
