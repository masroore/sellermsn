<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">

  <head>
{include file="header.tpl"}
  </head>

  <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">

    <!-- navbar-fixed-top-->
   {include file="navbartop.tpl"}

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- main menu-->
    {include file="navbar.tpl"}
    <!-- / main menu-->

    <div class="app-content content container-fluid">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- stats -->
<div class="row">
    <div class="container">
    <a href="view">Add Super Product</a> |
    <a href="getsuper">Add Sub Product</a>
    <div class="row title text-center" style="padding:0px">
      <h3>Add Super Product </h3>
    </div>

           <!--********************-->
    <form action="addsuper" method="POST" class="form">

            <div  class="col-md-4">
                <input type="text" name="pid" class="form-control" value="" placeholder="Product Id/SKU " >
            </div>

            <div  class="col-md-8">
                <input type="text" name="title" class="form-control" value="" placeholder="Name/Title of the Product" >
            </div>


           <!--  <div  class="col-md-4">
              <input type="text" name="image" class="form-control" value="" placeholder="Image URL of Product" >
            </div> -->


             <div  class="col-md-4">
                <select class="form-control" name="type" >
                    <option value="0" selected>Select Product Type</option>
                    <option value="cloth">Cloth</option>
                    <option value="footwear">Footwear</option>
                    <option value="eyewear">Eye Wear</option>
                    <option value="0">Other</option>
                </select>
            </div>

             <div  class="col-md-4">
                <select class="form-control" name="family" >
                    <option value="0" selected>Select Family</option>
                    <option value="jeans">Jeans</option>
                    <option value="shirt">Shirt</option>
                    <option value="saree">Saree</option>
                    <option value="suit">Suit</option>
                    <option value="0">Other</option>
                </select>
            </div>

            <div  class="col-md-4">
              <input type="text" name="brand" value="" class="form-control" placeholder="Product Brand" >
            </div>

             <div  class="col-md-4">
                <select class="form-control" name="category" >
                    <option value="0" selected>Select Category</option>
                    <option value="cloth">Cloth</option>
                    <option value="footwear">Footwear</option>
                    <option value="eyewear">Eye Wear</option>
                    <option value="0">Other</option>
                </select>
            </div>

            <div  class="col-md-4">
                <select class="form-control" name="country" >
                    <option value="0" selected>Select Country</option>
                    <option selected value="india">India</option>
                    <option value="0">Other</option>
                </select>
            </div>

              <div  class="col-md-4">
                <select class="form-control" name="state" >
                    <option value="0" selected>Select State</option>
                    <option selected value="up">UP</option>
                    <option value="0">Other</option>
                </select>
            </div>

              <div  class="col-md-4">
                <select class="form-control" name="city" >
                    <option value="0" selected>Select City</option>
                    <option selected value="noida">Noida</option>
                    <option value="0">Other</option>
                </select>
            </div>

            <div  class="col-md-6">
                <input type="submit" name="submit" onclick="" class=" btn btn-success btn-lg" >
            </div>
            <div  class="col-md-6">
                <input type="reset" name="reset" class="btn btn-primary btn-lg">
           </div>
    </form>

           <div  class="col-md-6">
           <!--********************--><h1> Or Upload CSV </h1>
            </div>
            <div  class="col-md-6">
              <form action="catalogue.php" method="post" enctype="multipart/form-data">
                <input type="file" name="csv" value="" class="btn btn-primary" />
                <input type="submit" name="submit" value="Upload" class="btn btn-primary btn-success" />
              </form>
          </div>

  </div>
  </div>
</div>
<!--/ stats -->
<!--/ project charts -->

<!--/ project charts -->
<!-- Recent invoice with Statistics -->

<!-- Recent invoice with Statistics -->
<div class="row match-height">
    <div class="col-xl-4 col-md-6 col-sm-12">
        <div class="card" style="height: 440px;">
            <div class="card-body">
                <img class="card-img-top img-fluid" src="/src/app-assets/images/carousel/05.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4 class="card-title">Basic</h4>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-outline-pink">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 col-sm-12">
        <div class="card" style="height: 440px;">
            <div class="card-body">
                <div class="card-block">
                    <h4 class="card-title">List Group</h4>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <span class="tag tag-default tag-pill bg-primary float-xs-right">4</span> Cras justo odio
                    </li>
                    <li class="list-group-item">
                        <span class="tag tag-default tag-pill bg-info float-xs-right">2</span> Dapibus ac facilisis in
                    </li>
                    <li class="list-group-item">
                        <span class="tag tag-default tag-pill bg-warning float-xs-right">1</span> Morbi leo risus
                    </li>
                    <li class="list-group-item">
                        <span class="tag tag-default tag-pill bg-success float-xs-right">3</span> Porta ac consectetur ac
                    </li>
                    <li class="list-group-item">
                        <span class="tag tag-default tag-pill bg-danger float-xs-right">8</span> Vestibulum at eros
                    </li>
                </ul>
                <div class="card-block">
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12 col-sm-12">
        <div class="card" style="height: 440px;">
            <div class="card-body">
                <div class="card-block">
                    <h4 class="card-title">Carousel</h4>
                    <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                </div>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item">
                            <img src="/src/app-assets/images/carousel/02.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item active">
                            <img src="/src/app-assets/images/carousel/03.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img src="/src/app-assets/images/carousel/01.jpg" alt="Third slide">
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="icon-prev" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="icon-next" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="card-block">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    {include file="footer.tpl"}
    
  </body>
</html>
