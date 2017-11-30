<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex">

<title>Product Catalogue</title>
<head>
    {include file="product/header.tpl"}
</head>
<body>
	<div class="container">
    <a href="view">Add Super Product</a> |
    <a href="getsuper">Add Sub Product</a>
    <div class="row title text-center" style="padding:0px">
      <h3>Add Super Product </h3>
    </div>

           <!--********************-->
    <form action="addsuper" method="POST" class="form-group">
        <div class="row" >

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
</body>
</html>
