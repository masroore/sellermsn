<?php

namespace app\service {

use Goutte\Client;

    class AjioService
    {
        private static $BASE_URL = "https://ajio.com/";

        public static function configure()
        {
         //body > script:nth-child(3)
        }
         public static function getProductDetails($pid)
        {
        	$url =$pid;// self::$BASE_URL.$pid;
            echo $url.'<hr>';

            $client = new Client();
            $crawler = $client->request('GET',$url);
             sleep(3);
            $data = $crawler->filter('body > script:nth-child(3)  ')->extract('_text');
            // print_r($data);die;

            $data[0]=str_replace(" window.__PRELOADED_STATE__ = ", "", $data[0]);
            var_dump($data);die;
// print_r(json_decode($data[0]));die;
            $obj=json_decode($data[0]);

        print_r($obj);die;





// print_r($product);die;
            return json_encode($product);
	    }




        public static function addProduct($url = null,$subid)
        {
            // $pid =  self::fetchProductIdFromUrl($url);
            $product = json_decode(self::getProductDetails($url));


            return $productBean;


        }
    }
}
