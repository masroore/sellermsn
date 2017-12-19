<?php

namespace app\controller {

    // use app\service\JabongService;
    // use app\service\FlipKartService;
    // use app\service\AmazonService;
    // use app\service\MyntraService;
    // use app\service\SearchService;
    use app\service\BrandManagerService as BMS;

    use app\service\R;

    class ProductController extends AbstractController
    {
        /**
         * @Description - Simple From to add Super Product in DB.
         * @RequestMapping(url="product/view",type="template", auth="true")
         * @RequestParams(true)
         */
        public function product($model)
        {
          $brand=BMS::getBrand($this->user->uid);
          $model->assign('brand',$brand);
            return 'product/view';
        }


        /**
         * @Description - For creating Super Product
         * @RequestMapping(url="product/addsuper",method="POST",type="template", auth="true")
         * @RequestParams(true)
         */
        public function addsuperproduct($model=null,$pid,$title,$image,$type,$family,$brand,$category,$platform,$country,$state,$city)
        {
            $superbean=R::dispense('superproduct');
                $superbean->title = $title;
                // $superbean->image = $image;
                $superbean->type = $type;
                $superbean->family = $family;
                $superbean->brand = $brand;
                $superbean->category = $category;
                $superbean->country = $country;
                $superbean->state = $state;
                $superbean->city = $city;
                $superbean->managerid = $this->user->managerid;
                $superbean->created = R::isoDateTime();
            $id = R::store($superbean);

            $this->header("Location", "getsuper?id=" . $id);

        }
        /**
         * @Description - Fetches Super Product from DB and screen 2 is for adding subproduct(variants)
         * @RequestMapping(url="product/getsuper",method="GET",type="template", auth="true")
         * @RequestParams(true)
         */
        public static function getSuper($model=null,$id)
        {
            // echo $id; die;

            $superbean=R::load('superproduct',$id);
            $model->assign('superproduct',$superbean);

            $subbean = R::find('subproduct','sid=?',[$id]);
            $model->assign('subproduct',$subbean);
// print_r($subbean);die;
            return 'product/screen2';
        }
        /**
         * @Description - Variants added in screen2 will be posted here and saved into db and redirect to screen2
         * @RequestMapping(url="product/addsubproduct",method="POST",type="template", auth="true")
         * @RequestParams(true)
         */
        public function addSubProduct($model=null,$sid,$image,$color,$price,$material,$rating,$pattern,$size,$sex)
        {
            // echo $sid.$color.$price.$material.$rating.$pattern.$size.$sex; die;

            $subbean=R::dispense('subproduct');
                $subbean->sid = $sid;
                $subbean->image = $image;
                $subbean->color = $color;
                $subbean->price = $price;
                $subbean->material = $material;
                $subbean->rating = $rating;
                $subbean->pattern = $pattern;
                $subbean->size = $size;
                $subbean->sex = $sex;
            $id=R::store($subbean);

        //TO UPDATE IN ELASTIC SEARCH INDEX
             // $ss=new SearchService();
             // $ss->update($id); //have to uncoment after successful build

            $this->header("Location", "getsuper?id=" . $sid);
        }

        /**
         * @Description - Screen3 will show the products available on different E-Commerce platform
         * @RequestMapping(url="product/screen3", method="POST",type="template", auth="true")
         * @RequestParams(true)
         */
        public function screen3($model=null,$subid,$superid,$search=null,$host=null)
        {
          //  echo $subid.$superid.$search.$host;
           $superbean = R::load('superproduct',$superid);
           $subbean   = R::load('subproduct',$subid);

           $model->assign('superproduct',$superbean);
           $model->assign('subproduct',$subbean);
           $model->assign('host',$host);


            // $searchkey=$name.' '.$color.' '.$pattern.' '.$brand.' '.$category.' for '.$sex;
            // $searchkey=(!is_null($search))? $search : $superbean->brand.' '.$superbean->family.' '.$superbean->category.' for '.$subbean->$sex;
            $searchkey=(!is_null($search))? $search.' '.$superbean->brand.' '.$superbean->family.' '.$subbean->color.' '.$superbean->category.' for '.$subbean->sex : $superbean->title.' '.$superbean->brand.' '.$superbean->family.' '.$subbean->color.' '.$superbean->category.' for '.$subbean->sex;
// echo $searchkey;die;
            self::search($model,$searchkey,$host);


            if(!is_null($search)){
              $model->assign('searchtitle',$search);
            }

            return 'product/screen3';
        }

        /**
         * @Description - This function searches the product on the platform passed in $host and returns json searchresult
         * @RequestMapping(url="product/search", method="GET",type="template", auth="true")
         * @RequestParams(true)
         */
        public static function search($model=null,$searchkey=null,$host=null)
        {

            if (strpos($host, 'myntra') !== false) {
                $searchresult=json_decode(MyntraService::searchProduct($searchkey));
                $searchcount =count($searchresult->title)-1;

                $model->assign('product',$searchresult);
                $model->assign('searchcount',$searchcount);

            }else if(strpos($host, 'amazon') !== false){
                $searchresult=json_decode(AmazonService::searchProduct($searchkey));
                $searchcount =count($searchresult->title)-1;

                $model->assign('product',$searchresult);
                $model->assign('searchcount',$searchcount);

            }else if(strpos($host, 'flipkart') !== false){
                $searchresult=json_decode(FlipKartService::searchProduct($searchkey));
                $searchcount =count($searchresult->title)-1;

                $model->assign('product',$searchresult);
                $model->assign('searchcount',$searchcount);

            }else{// if (strpos($host, 'jabong') !== false) {
                $searchresult=json_decode(JabongService::searchProduct($searchkey));
                $searchcount =count($searchresult->title)-1;

                $model->assign('product',$searchresult);
                $model->assign('searchcount',$searchcount);

            }
             return null;


         }

        /**
         * @RequestMapping(url="product/reg", method="GET",type="template", auth="true")
         * @RequestParams(true)
         */
        public function reg($model=null)
        {

            return 'product/searchview';
        }

    }
}
