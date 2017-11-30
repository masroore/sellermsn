<?php
namespace app\service {

  class SellerService
  {


    public static function createBrand($name, $username, $company, $website, $email, $contact, $type)
    {
    	$brand=R::findOneOrDispense('sellerbrand','username=?',[$username]);
        $brand->name = $name;
    	$brand->username= $username;
    	$brand->company	= $company;
    	$brand->website	= $website;
    	$brand->email 	= $email;
    	$brand->contact = $contact;
    	$brand->type 	= $type;
    	$brand->created = R::isoDateTime();
    	$id = R::store($brand);

    	return $id;
    }
    public static function createManager($brandid, $name, $email, $contact)
    {
            // echo 'fff'.$brandid.$name.$email.$contact;die;

        $manager=R::findOneOrDispense('manager','email=?',[$email]);
        $manager->name=$name;
        $manager->email=$email;
        $manager->contact=$contact;
        $manager->password=1234;
        $manager->status=0;
        $manager->created=R::isoDateTime();
        $managerid=R::store($manager);

        $bm=R::dispense('brandmanager');
        $bm->brandid=$brandid;
        $bm->managerid=$managerid;
        $id=R::store($bm);

    }
    public static function getAllSeller()
    {
        $bean=R::find('sellerbrand','order by created desc limit 7');
        foreach ($bean as $b) {
            $r=null;
            $r->id=$b->id;
            $r->name=$b->name;
            $r->username=$b->username;
            $r->company=$b->company;
            $r->website=$b->website;
            $r->email=$b->email;
            $r->contact=$b->contact;
            $r->type=$b->type;
            $r->created=$b->created;
        $res[]=$r;
        }
        return json_decode(json_encode($res));

    }

    public static function getAllManager($brandid)
    {
        // echo $brandid.'dsd';
        $bean=R::find('brandmanager','brandid=?',[$brandid]);
        // print_r($bean);die;
        foreach ($bean as $b) {
         $ids[]=$b->id;
        }
        $bean=R::loadAll('manager',$ids);

        return (($bean));

    }

  }
}
