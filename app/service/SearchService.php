<?php
namespace app\service {

  use Elasticsearch\ClientBuilder;


  class SearchService
  {
      private $client = null;
      
    function __construct()
    {
        $host=['0.0.0.0:9200','127.0.0.1'];
        $this->client = ClientBuilder::create()
                                  ->setHosts($host)
                                  ->build();
     }
     /* SEARCH IN ELASTIC SERVER according to the $query(string). Returns the best matched result array */
    public function search($query) 
    {
      $i = 0;
      $response=array();

        $params = [
        'index' => 'products',
        'type' => 'product',
        'body' => [
          "query"=> [
              "bool"=> [
                "should"=> [
                  [ "match"=> [ 
                      "brand"=>  [
                        "query"=> $query,
                        "boost"=> 2
                  ]]],
                  [ "match"=> [ 
                      "category"=>  [
                        "query"=> $query,
                        "boost"=> 2
                  ]]],
                  [ "match"=> [ 
                      "family"=>  [
                        "query"=> $query,
                        "boost"=> 2
                  ]]],
                  [ "bool"=>  [ 
                      "should"=> [
                        [ "match"=> [ "title"=> $query ]],
                        [ "match"=> [ "family"=> $query ]],
                        [ "match"=> [ "color"=> $query ]],
                        [ "match"=> [ "type"=> $query ]],
                        [ "match"=> [ "sex"=> $query ]]
                      ]
                  ]],
                  ["fuzzy" => [
                        "title" => [
                            "value" => $query,
                                "boost" =>  1.0,
                                "fuzziness" => 2,
                                "prefix_length" => 0,
                                "max_expansions"=> 100
                        ]
                    ]
                 ],
                ]
              ]
            ]

        ]//body
        ];

      $query = $this->client->search($params);
      $hits = sizeof($query['hits']['hits']);
      $hit = $query['hits']['hits'];
      $response['searchfound'] = $hits;
      while ($i < $hits){
        $response['result'][$i] = $query['hits']['hits'][$i]['_source'];
        $i++;
      }
      return $response;
    }
    
    /* searches the product against the id given. */
    public function searchById($id)
    {

          // $params = [
          //     'index' => 'products',
          //     'type' => 'product',
          //     'id' => $id
          // ];
          // try{
          //   $response = $this->client->get($params);
          // }catch(\Exeption $e){
          //   $response=[
          //             "_index"=>"products",
          //             "_type"=>"product",
          //             "_id"=>$id,
          //             "_version"=>2,
          //             "found"=>false,
          //             "_source"=>null
          //           ];
          // }
          // // print_r($response);die;
     $response= $this->searchByIds(array($id));
      return $response[0];
    }


    /* Searches all Products from ElasticServer given id as an array in $ids. 
      Returns products in json */
    public function searchByIds($ids)
    {
      // if(!is_array($ids)){ $ids=array($ids); }
      $products=array();
      foreach ($ids as $key => $value) 
      {
        // echo $value;
        if($value!=0){
          $params = [
              'index' => 'products',
              'type' => 'product',
              'id' => $value
          ];
        try{
          $response = $this->client->get($params);
        }catch(\Exception $e){
          $response=[
                      "_index"=>"products",
                      "_type"=>"product",
                      "_id"=>(string)$value,
                      "_version"=>2,
                      "found"=>false,
                      "_source"=>null
                    ];
        }
          // print_r($response);die;
          $products[] = $response;//['_source'];
        }
      }//foreach
      // print_r($products);die;
      return $products;
    }

    public function getSource($id)
    {
      $res=null;
      $source=R::find('source','subid=?',[$id]);
      // print_r($source);die;
      foreach ($source as $s) {
        $host=R::load('host',$s->hostid);
        $brand=R::load('brand',$s->brandid);
        $currency=R::load('currency',$s->currencyid);
        $price=R::load('price',$s->priceid);
        $family=R::load('family',$s->familyid);
        $category=R::load('category',$s->categoryid);
        $seller=R::load('seller',$s->sellerid);

          $sourcesize=R::find('sourcesize','srcid=?',[$s->id]);
          $size=array();
          foreach ($sourcesize as $ss) {
            $temp=R::load('size',$ss->sizeid);
            $size[]=$temp->title;
          }
        $res=null;
        $res->id=$s->id;
        $res->subid=$s->subid;
        $res->pid=$s->pid;
        $res->title=$s->title;
        $res->url=$s->url;
        $res->image=array($s->image);
        $res->description=$s->description;
        $res->sex=$s->sex;
        $res->host=$host->title;
        $res->brand=$brand->title;
        $res->size=$size;
        $res->currency=$currency->title;
        $res->discounted_price=$price->price;
        $res->mrp=$price->mrp;
        $res->family=$family->title;
        $res->category=$category->title;
        $res->seller=$seller->title;
        
      $response[]=$res;
      }
      return $response;
    }

    public function getSourceBySourdeId($id)
    {
      $res=null;
      $source=R::load('source',$id);
      // print_r($source);die;
      // foreach ($source as $s) {
        $host=R::load('host',$source->hostid);
        $brand=R::load('brand',$source->brandid);
        $currency=R::load('currency',$source->currencyid);
        $price=R::load('price',$source->priceid);
        $family=R::load('family',$source->familyid);
        $category=R::load('category',$source->categoryid);
        $seller=R::load('seller',$source->sellerid);

          $sourcesize=R::find('sourcesize','srcid=?',[$source->id]);
          $size=array();
          foreach ($sourcesize as $ss) {
            $temp=R::load('size',$ss->sizeid);
            $size[]=$temp->title;
          }
        $res=null;
        $res->id=$source->id;
        $res->subid=$source->subid;
        $res->pid=$source->pid;
        $res->title=$source->title;
        $res->url=$source->url;
        $res->image=array($source->image);
        $res->description=$source->description;
        $res->sex=$source->sex;
        $res->host=$host->title;
        $res->brand=$brand->title;
        $res->size=$size;
        $res->currency=$currency->title;
        $res->discounted_price=$price->price;
        $res->mrp=$price->mrp;
        $res->family=$family->title;
        $res->category=$category->title;
        $res->seller=$seller->title;
        
      // $response[]=$res;
      // }
      return $res;
    }
    
    public function update($id) //UPDATE (here $id = subproduct id)
    {
      $subbean  = R::load('subproduct',$id);
      $superbean= R::load('superproduct',$subbean->sid);
        
        $params = null;
          // foreach ($bean as $b)
          // {
               $params['body'][] = [
                    'index' => [
                        '_index' => 'products',
                        '_type' => 'product',
                        '_id'   => $subbean['id']
                    ]
                ];

                $params['body'][] = [
                    'id'   => $subbean['id'],//suproduct id for furure reference
                    'title'   => $superbean['title'],
                    'image'   => $subbean['image'],
                    'type'    => $superbean['type'],
                    'category'=> $superbean['category'],
                    'family'  => $superbean['family'],
                    'brand'   => $superbean['brand'],
                    'color'   => $subbean['color'],
                    'price'   => $subbean['price'],
                    'pattern' => $subbean['pattern'],
                    'size'    => $subbean['size'],
                    'sex'     => $subbean['sex']
                ];
          // }

        // $this->createIndex(); //To create only if index does not exist=??
        $responses = $this->client->bulk($params);
        print_r($responses);
        // echo 'updated';
      return true;
    }
    
    public function createIndex()//INDEX CREATE on ELASTIC SERVER
    {
        $params = [
            'index' => 'products',
            'body' => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 2
                ],
                'mapping' => [
                    'product' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                                'analyzer' => 'standard'
                            ],
                            'title' => [
                                'type' => 'string'
                            ],
                            'image' => [
                                'type' => 'string'
                            ],
                            'type'=>[
                                'type' => 'string'

                            ],
                            'category'=>[
                                'type' => 'string'

                            ],
                            'family'=>[
                                'type' => 'string'

                            ],
                            'brand'=>[
                                'type' => 'string'

                            ],
                            'color'=>[
                                'type' => 'string'

                            ],
                            'pattern'=>[
                                'type' => 'string'

                            ],
                            'sex'=>[
                                'type' => 'string'

                            ]
                        ]
                    ]
                ]
            ]
        ];

      // Create the index with mappings and settings now
      $response = $this->client->indices()->create($params);
      echo "Index Created";
      return $response;
    }

    public function delete($id)
    {
         
    }
    

  }
}





















































// namespace app\service {

//     class SearchService
//     {

//       public function __construct()
//       {

//       }

//       public static function getSearch($searchkey)
//       {
//         // $searchkey = strtolower($searchkey);
//         // $searchkey = implode(' ',array_unique(explode(' ',$searchkey)));
//         // // echo 'strlower:'.$searchkey;
//         //
//         // $brand = self::getBrand($searchkey);//array of brands
//         // $searchkey=str_replace($brand,"",$searchkey);
//         // echo 'leftout:'.$searchkey;
//         // $q="SELECT id, title, MATCH (title)  AGAINST ('".$searchkey."' IN BOOLEAN MODE) AS score FROM brand ORDER BY score DESC";
//         // $q="SELECT *, MATCH (brand,title,category,family) AGAINST('".$searchkey."' IN BOOLEAN MODE) AS score FROM superproduct ORDER BY score DESC";
//         // $q="select * from superproduct sp left join subproduct sb on sp.id=sb.sid where match(sp.brand,sp.title,sp.category,sp.family) against('".$searchkey."' in boolean mode) or match(sb.color,sb.pattern,sb.sex) against('".$searchkey."' in boolean mode)";
//         $q="SELECT *, MATCH (superproduct.brand,superproduct.title,superproduct.category,superproduct.family) AGAINST('".$searchkey."' IN BOOLEAN MODE) AS score1,match(subproduct.color,subproduct.pattern,subproduct.sex) against('".$searchkey."' in boolean mode)as score2 FROM superproduct left join subproduct on superproduct.id=subproduct.sid where(MATCH (superproduct.brand,superproduct.title,superproduct.category,superproduct.family) AGAINST('p".$searchkey."' IN BOOLEAN MODE) or match(subproduct.color,subproduct.pattern,subproduct.sex) against('".$searchkey."' in boolean mode)) having(score1+score2)>0 ORDER BY (score1+score2) DESC";

//         $bean = R::getAll($q );
//         echo '<hr><pre>';
//         print_r($bean);

//           foreach($bean as $b)
//           {
//             if($b['score1']+$b['score2']<=0){
//               break;
//             }
//             $pro[]=strtolower($b['title']);
//           }
//         echo '<hr><pre>';
//         print_r($pro);
//       }








//       public static function getBrand($searchkey)
//       {

//         $q="SELECT id, title, MATCH (title)  AGAINST ('".$searchkey."' IN BOOLEAN MODE) AS score FROM brand ORDER BY score DESC";
//         $brandbean = R::getAll($q );
//           foreach($brandbean as $b)
//           {
//             if($b['score']<1){
//               break;
//             }
//             $brand[]=strtolower($b['title']);
//           }
//         // echo '<hr><pre>';
//         // print_r($brandbean);
//         echo '<hr><pre>';
//         print_r($brand);
//         return $brand;

//       }



//     }
// }

/*
SELECT *,
 MATCH(books.title) AGAINST('$q') as tscore,
 MATCH(authors.authorName) AGAINST('$q') as ascore,
 MATCH(chapters.content) AGAINST('$q') as cscore
FROM books
LEFT JOIN authors ON books.authorID = authors.authorID
LEFT JOIN chapters ON books.bookID = chapters.bookID
WHERE
 MATCH(books.title) AGAINST('$q')
 OR MATCH(authors.authorName) AGAINST('$q')
 OR MATCH(chapters.content) AGAINST('$q')
ORDER BY (tscore + ascore + cscore) DESC
*/


//SELECT id, title, MATCH (title)  AGAINST ('uni* indd* h*' IN BOOLEAN MODE) AS score FROM brand ORDER BY score DESC

// $q="select * from brand where match(title) against('".$searchkey."')";
