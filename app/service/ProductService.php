<?php

namespace app\service {

    class ProductService
    {

        public static function fetchSource($url,$subid)
        {
            if (strpos($url, 'flipkart.com') !== false) {
                return FlipKartService::addProduct($url,$subid);
            }else if (strpos($url, 'www.amazon.') !== false) {
                return AmazonService::addProduct($url,$subid);
            }else if (strpos($url, 'jabong.com') !== false) {
                return JabongService::addProduct($url,$subid);
            }else if (strpos($url, 'myntra.com') !== false) {
                return MyntraService::addProduct($url,$subid);
            }else if (strpos($url, 'ajio.com') !== false) {
                return AjioService::addProduct($url,$subid);
            }
            return null;
        }

        public static function getProduct($managerid)
        {
            $product=R::find('superproduct','managerid=? order by created limit 7',[$managerid]);
            foreach ($product as $p) {
                $r=null;
                $r->id=$p->id;
                $r->title=$p->title;
                $r->type=$p->type;
                $r->family=$p->family;
                $r->brand=$p->brand;
                $r->category=$p->category;
                $r->country=$p->country;
                $r->state=$p->state;
                $r->city=$p->city;
                $r->created=$p->created;
                $res[]=$r;
            }
         return json_decode(json_encode($res));
        }
    }
}
