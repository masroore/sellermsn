<?php

namespace app\controller {
  use app\service\ProductService;
  use app\service\BrandManagerService as BMS;
  use \app\service\SellerService;
  use \app\service\StoreService;


  class BasicController extends AbstractController
  {

    /**
    * @Description - Welcome page
    *
    * @RequestMapping(url="welcome",method="GET",type="template")
    * @RequestParams(true)
    */
    public function welcome($model = null, $name = null)
    {

      $profile = array(
        "name" => $name
      );

      $model->assign("profile", $profile);

      return "welcome";
    }


    /**
    * @Description - Json Api
    *
    * @RequestMapping(url="api/data/{data_id}",method="GET",type="json")
    * @RequestParams(true)
    */
    public function sampleApi($model = null, $data_id = null)
    {

      return array(
        "id" => $data_id,
        "name" => "No Name yet"
      );

    }

    /**
    * @Description - Default page
    *
    * @RequestMapping(url="",method="GET",type="template")
    * @RequestParams(true)
    */
    public function index($model = null)
    {
      // echo 'role'.$this->user->role.$this->user->uid.$this->user->uname;die;
      $brand=BMS::getBrand($this->user->uid);
      $model->assign('brand',$brand);

      $manager=SellerService::getAllManager($this->user->uid);
      $model->assign('manager',$manager);
      $store=StoreService::getAllStore($this->user->uid);
      $model->assign('store',$store);
      $product = ProductService::getProduct($this->user->managerid);
      $model->assign('product',$product);

      if($this->user->isValid() && $this->user->role=='manager'){
        return "index";
      }else if($this->user->isValid() && $this->user->role=='store'){
        return "store/index";
      }else{
        $model->assign('error','You are not Logged In');
        return 'login';
      }
    }

  }
}
