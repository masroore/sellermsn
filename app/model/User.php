<?php

namespace app\model {

    use app\service\R;

    /**
     * Description of User, it basically extends AbstractUser and implemetns atleast two methods
     *
     * @Model(sessionUser)
     */
    class User extends AbstractUser
    {

        public $IS_MOD = false;
        public $managerid=-1;

        public function configure()
        {
            //One time per request
        }

        public function on_auth_success($user)
        {
            //After login is done succesfully
        }

        public function auth($username, $password,$type)
        {
          if($type=='bm')
          {
            $manager=R::findOne('manager','email=? and password=?',[$username, $password]);
            if($manager){
              $bean=R::load('brandmanager',$manager->id);

              $this->uid  = $bean->brandid;
              $this->uname= $manager->name;
              $this->managerid= $manager->id;
              $this->role = "manager";
              $this->setValid(TRUE);

            }
                // else{
                //   $model->assign("error", "Brand : Wrong credentials");
                //   return 'login';
                // }
          }else if($type='sm'){
              $store=R::findOne('store','email=? and password=?',[$username, $password]);
              if($store){
                $bean=R::load('brandmanager',$store->managerid);

                $this->uid  = $bean->brandid;
                $this->uname= $store->name;
                $this->role = "store";
                $this->setValid(TRUE);

              }
                // else{
                //     $model->assign("error", "Store : Wrong credentials");
                //     return 'login';
                // }
          }
            return $this->isValid();
        }

        public function basicAuth()
        {
            $this->configure();
            if (!$this->isValid()) {
                header('Location: /login');
                exit();
                return false;
            } else {
                return true;
            }
//            return $this->setUser("101", "someone@some.com", array(
//                "somedata" => "somevalue"
//            ));
        }

        public function unauth()
        {
            $this->configure();
            $this->setInValid();
            header('Location: /login');
            exit();
        }
    }
}
