<?php

namespace app\controller {

use \app\service\R;
use \app\service\ProductService;
use \app\service\BrandManagerService as BMS;
use \app\service\SellerService;
use \app\service\StoreService;


    class MyController extends AbstractController
    {

      /**
         * @RequestMapping(url="login",method="GET",type="template")
         * @RequestParams(true)
         */
        public function login1($model,$username,$password)
        {
          $this->header('location','/');
        }

        /**
         * @RequestMapping(url="login",method="POST",type="template")
         * @RequestParams(true)
         */
        public function login($model,$username,$password,$type)
        {
          if($this->user->auth($username, $password,$type) && $type="bm") {
              $brand=BMS::getBrand($this->user->uid);
              $model->assign('brand',$brand);

              $manager=SellerService::getAllManager($this->user->uid);
              $model->assign('manager',$manager);

              $store=StoreService::getAllStore($this->user->uid);
              $model->assign('store',$store);

              $product = ProductService::getProduct($this->user->managerid);
              $model->assign('product',$product);
              return "index";
            
            }else if($this->user->auth($username, $password,$type) && $type="bm"){
                $brand=BMS::getBrand($this->user->uid);
                $model->assign('brand',$brand);

                $manager=SellerService::getAllManager($this->user->uid);
                $model->assign('manager',$manager);

                $store=StoreService::getAllStore($this->user->uid);
                $model->assign('store',$store);

                $product = ProductService::getProduct($this->user->managerid);
                $model->assign('product',$product);
                return "store/index";
            
            }else {
                return "login";
            }
         
        }

       /**
         * @RequestMapping(url="logout",method="GET",type="template")
         * @RequestParams(true)
         */
        public function logout($model)
        {
           $this->user->setInvalid();
           session_destroy();
           $model->assign("error", "Successfully Logged Out");
          return "login"; //path of smarty tempalte file in view folder

        }

    }
}
