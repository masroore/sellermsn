<?php

namespace app\service {

use Goutte\Client;

    class JabongService
    {
        private static $BASE_URL = "https://jabong.com/";

        public static function configure()
        {

        }

        /* Scrape the product details from the ecommerce paltform 
            Returns Json data */
        public static function getProductDetails($pid)
        {
            $url = self::$BASE_URL.$pid.".html";

            $client = new Client();
            $crawler = $client->request('GET',$url);
             sleep(3);
            $title = $crawler->filter('span.product-title')->extract('_text');
            $brand = $crawler->filter('span.brand')->extract('_text');

                $data=$crawler->filter('script')->extract('_text');
                $data[3]=str_replace("var globalConfig = ", "", $data[3]);
                $data[3]=str_replace(";", "", $data[3]);
                $obj=json_decode($data[3]);
            $family =$obj->product->subcategory; 
            $sex = $obj->product->gender;


                $description2=array();
                $description1 = $crawler->filter('span.product-info-left')->extract('_text');
                for($i=1; $i<=count($description1); $i++){
                    $d2 = $crawler->filter('#productInfo > section > ul > li:nth-child('.$i.') > span:nth-child(2)')->extract('_text');//      span.standard-price
                    array_push($description2, $d2[0]);
                }
                $desc=array();
                for($i=0;$i<count($description1);$i++){
                $desc[$i] = $description1[$i].':'.$description2[$i];
                }
            $description =  implode(';',$desc);


            $price = $crawler->filter('span.actual-price')->extract('_text');
            $mrp=$crawler->filter('span.standard-price')->extract('_text');
            $currency=$crawler->filter('span.rupee.hide')->extract('content');
            $size  = $crawler->filter('option.swatch-item')->extract('value');
            $color = array($obj->product->color);//$crawler->filter('a.swatch-item.color')->extract('title');
            $image = $crawler->filter('img.load-in-viewport.primary-image.first.thumb')->extract('data-img-config');
            $category = $crawler->filter('#content-wrapper > div.container-fluid.pdp-breadcrumb > div > div:nth-child(1) > ol > li:nth-child(3) > a > span')->extract('_text');
            $seller = $crawler->filter('#seller-info > span > a')->extract('_text');

            $img = json_decode($image[0]);

            $product['title']   = $title[0];
            $product['brand']   = $brand[0];
            $product['family']  = $family;
            $product['sex']     = $sex;

            $product['description']   = $description;
            $product['image']   = $img->base_path. $img->{320}; //combining base path with image path
            $product['price']   = $price[0];
            $product['mrp']     = $mrp[1];
            $product['currency']= $currency[0];
            $product['size']    = $size;
            $product['color']   = $color;
            $product['category']= $category[0];
            $product['seller']  = $seller[0];
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
                $host=R::findOneOrDispense('host','title=?',array("jabong"));
                $host->title="jabong";
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
                $family=R::findOneOrDispense('family','title=?',    array($product->family));
                $family->title=$product->family;
                R::store($family);
            $productBean->familyid = $family->id;
            
                $price=R::dispense('price');
                $price->price=$product->price;
                $price->mrp=$product->mrp;
                R::store($price);
            $productBean->priceid = $price->id;
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

            return $pid[0];
        }

        /* Scrape the Product list from E-Commerce Platform on the basis of $searchkey
            Returns Json (product list) */
        public static function searchProduct($searchkey)
        {
            // https://www.jabong.com/find/blue-jeans/?q=blue jeans
            $url = self::$BASE_URL.'find/'.$searchkey.'/?q='.$searchkey;

            // echo '<br>'.$url.'<br>'.$searchkey;die;

            $client  = new Client();
            $crawler = $client->request('GET', $url);
            sleep(3);
            $title = $crawler->filter('div.h4')->extract('_text');
            $size  = $crawler->filter('div.avail-size')->extract('_text');
            $image = $crawler->filter('img.load-in-viewport.primary-image.thumb')->extract('data-img-config');//load-in-viewport primary-image thumb

            $price  =array();
            $src    =array();
            $link   =array();
            $priceoriginal=array();

            for($i=1; $i<=count($title)-3; $i++){
                $pr = $crawler->filter('#catalog-product > section.row.search-product.animate-products > div:nth-child('.$i.')')->extract('data-discount-price');//      span.standard-price
                array_push($price, $pr[0]);

                // $sr  = $crawler->filter('#catalog-product > section.row.search-product.animate-products > div:nth-child('.$i.') > a > figure > img')->extract('src'); //primary-image thumb loaded
                // array_push($src, $sr[0]);

                $po = $crawler->filter('#catalog-product > section.row.search-product.animate-products > div:nth-child('.$i.')')->extract('data-original-price');//      span.standard-price
                 array_push($priceoriginal, $po[0]);

                $l = $crawler->filter('#catalog-product > section.row.search-product.animate-products > div:nth-child('.$i.') > a')->extract('href');
                array_push($link, (self::$BASE_URL.$l[0]));
            }


            foreach ($image as $key => $value) {
               $jd=json_decode($value);
               $imgurl= $jd->base_path.$jd->{320};
               array_push($src, $imgurl);
            }
            // $price = $crawler->filter('#catalog-product > section.row.search-product.animate-products > div:nth-child(1)')->extract('data-discount-price');//      span.standard-price



            $product['title']   = $title;
            $product['src']     = $src;
            $product['price']   = $price;
            $product['priceoriginal']   = $priceoriginal;
            $product['link']    = $link;
            $product['size']    = $size;
            // print_r($product);die;
            $product=json_decode(json_encode($product));

                for($id=0; $id<3; $id++){
                unset( $product->title[$id] );
                }
                unset( $product->size[0] );
                // for($id=0; $id<count($product->price); $id+=2){
                // unset( $product->price[$id] );
                // }
                $product->title = array_values($product->title);
                $product->size  = array_values($product->size);

            $product_json=json_encode($product);

            return $product_json;
        }


    }
}
