<?php

namespace app\controller {
  use app\service\SellerService;
  use \app\service\R;

  class BrandManagerController extends AbstractController
  {

    /**
    * @Description - Dashoard page for seller
    *
    * @RequestMapping(url="seller/view",method="GET",type="template", auth="true")
    * @RequestParams(true)
    */
    public function view($model = null)
    {
      $res=SellerService::getAllSeller();
      // echo '<pre>';
      // print_r($res);die;
      $model->assign('res',$res);
      return 'seller/view';
    }
    /**
    * @Description - Form to Create New Seller with Brand manager
    *
    * @RequestMapping(url="seller/registerbrand",method="GET",type="template", auth="true")
    * @RequestParams(true)
    */
    public function registerBrand($model = null)
    {
      return 'seller/brandform';
    }

    /**
    * @Description - Form to Create New Seller with Brand manager
    *
    * @RequestMapping(url="seller/registermanager",method="GET",type="template", auth="true")
    * @RequestParams(true)
    */
    public function registerManager($model = null)
    {
      $brand=R::load('sellerbrand',$_SESSION['brandid']);
      $brand=json_decode(json_encode($brand));
      $model->assign('brand',$brand);

      return 'seller/managerform';
    }

    /**
    * @Description - Form to Create New Seller with Brand manager
    *
    * @RequestMapping(url="seller/createbrand",method="POST",type="template", auth="true")
    * @RequestParams(true)
    */
    public function createBrand($model = null, $name, $username, $company, $website, $email, $contact, $type)
    {
      SellerService::createBrand($name, $username, $company, $website, $email, $contact,$type);
      return 'seller/managerform';
    }

    /**
    * @Description - Form to Create New Seller with Brand manager
    *
    * @RequestMapping(url="seller/createmanager",method="POST",type="template", auth="true")
    * @RequestParams(true)
    */
    public function createManager($model = null, $brandid, $name, $email, $contact)
    {
      SellerService::createManager($brandid,$name, $email, $contact);
      $this->header('Location','/');
      return 'index';
    }


  }
}
