<?php

namespace app\controller {
    use app\service\StoreService;
    use app\service\R;
    use app\model\User;

    class StoreController extends AbstractController
    {

        /**
         * @Description - Dashoard page for seller
         *
         * @RequestMapping(url="store/registerstore",method="GET",type="template", auth="true")
         * @RequestParams(true)
         * @Role - store
         * @Model(sessionUser)
         */
        public function registerStore($model = null)
        {
          // echo $this->user->role.$this->user->validate();die;

            $manager=R::load('manager',$_SESSION['managerid']);
            $model->assign('manager',(json_decode(json_encode($manager))));
            return 'store/storeform';
        }

         /**
         * @Description - Dashoard page for seller
         *
         * @RequestMapping(url="store/createstore",method="POST",type="template")
         * @RequestParams(true)
         */
        public function createStore($model = null,$name, $address, $city, $state, $country, $pincode, $description, $email, $contact, $website, $type, $brandid)
        {
            // echo $name. $address. $city. $state. $country. $pincode. $description. $email. $contact. $website. $type;die;
            StoreService::createStore($name, $address, $city, $state, $country, $pincode, $description, $email, $contact, $website, $type);
            $model->assign('msg','Store Created');
            $this->header('location','registerstore');
            return 'store/storeform';
        }
    }
}
