<?php

namespace app\service {


    class BrandManagerService
    {
    	public static function getBrand($id)
      {
        $brand = R::load('sellerbrand',$id);
        return $brand;
      }

    }
}
