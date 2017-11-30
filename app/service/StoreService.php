<?php
namespace app\service {

  class StoreService
  {
   

    public static function createStore($name, $address, $city, $state, $country, $pincode, $description, $email, $contact, $website, $type)
    {
    	$store=R::dispense('store');
    	$store->name=$name;
    	$store->address=$address;
    	$store->city=$city;
    	$store->state=$state;
    	$store->country=$country;
    	$store->pincode=$pincode;
    	$store->description=$description;
    	$store->email=$email;
    	$store->contact=$contact;
    	$store->website=$website;
        $store->type=$type;
        $store->password=rand(1000,9999);
    	$store->managerid=$_SESSION['managerid'];
        $store->brandid=$_SESSION['brandid'];
        $store->created=R::isoDateTime();
    	$id=R::store($store);
    	return $id;
    }

    public static function getAllStore($brandid)
    {
        $bean=R::find('store','brandid=?',[$brandid]);
        return $bean;
    }
  }
}