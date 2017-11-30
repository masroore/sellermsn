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
<div id="wrapper">
<div id="main">
    <div id="content">
<!-- ===================================================== -->
 <div class="container">
  <a href="view">Add Super Product</a> |
    <a href="getsuper">Add Sub Product</a>
        <div class="row" >
          <h6>Super Product</h6>
            <div  class="col-md-3">
                PID :   {$superproduct->id}
            </div>
            <!-- <div  class="col-md-8"> -->
              <form action="screen3" method="POST"  id="mf" class="form-group">
              <input type="hidden" name="subid" value="{$subproduct->id}">
              <input type="hidden" name="superid" value="{$subproduct->sid}">
              <textarea rows="1" cols="100" id="key" name="search">
                {(!is_null($searchtitle)) ? trim($searchtitle) : trim($superproduct->title)}  </textarea>
                <img src="/src/image/logo/flipkart.png" height="20" width="20"><input type="radio" name="host" value="flipkart" title="flipkart" {($host=='flipkart')?checked:""}>
                <img src="/src/image/logo/amazon.png" height="20" width="20"><input type="radio" name="host" value="amazon" title="amazon" {($host=='amazon')?checked:""}>
                <img src="/src/image/logo/jabong.png" height="20" width="20"><input type="radio" name="host" value="jabong" title="jabong" {($host=='jabong')?checked:""}>
                <img src="/src/image/logo/myntra.png" height="20" width="20"><input type="radio" name="host" value="myntra" title="myntra" {($host=='myntra')?checked:""}>
              <button type="submit" id="search"  onclick="return ddsearchLoad()" id="searchbtn" class="btn btn-primary">Search</button></form>

            <!-- </div> -->
            <div  class="col-md-12">
                Image :   {$superproduct->image}
            </div>
            <div  class="col-md-4">
                Type :   {$superproduct->type}
            </div>
            <div  class="col-md-4">
                Family :   {$superproduct->family}
            </div>
            <div  class="col-md-4">
                Brand :   {$superproduct->brand}
            </div>
            <div  class="col-md-4">
                Category :   {$superproduct->category}
            </div>
            <div  class="col-md-4">
                Country :   {$superproduct->country}
            </div>
            <div  class="col-md-4">
                State :   {$superproduct->state}
            </div>
            <div  class="col-md-4">
                City :   {$superproduct->city}
            </div>

<hr>
<!-- =====================================================================             -->

           <table class="table table-striped">
    <thead>
      <tr>
        <th>SPID</th>
        <th>SPSID</th>
        <th>Image</th>
        <th>Color</th>
        <th>Price</th>
        <th>Material</th>
        <th>Rating</th>
        <th>Pattern</th>
        <th>Size</th>
        <th>Sex</th>
      </tr>
    </thead>

    <tbody>

      <tr>
        <td>{$subproduct->id}</td>
        <td>{$subproduct->sid}</td>
        <td><img src="{$subproduct->image}" height="50" width="50" alt="MS"></td>
        <td>{$subproduct->color}</td>
        <td>{$subproduct->price}</td>
        <td>{$subproduct->material}</td>
        <td>{$subproduct->rating}</td>
        <td>{$subproduct->pattern}</td>
        <td>{$subproduct->size}</td>
        <td>{$subproduct->sex}</td>
        <!-- <td><form action="screen3" method="POST"  id="mf" class="form-group" style="float:right;">
              <input type="hidden" name="subid" value="{$subproduct->id}">
              <input type="hidden" name="superid" value="{$subproduct->sid}">
              <input type="hidden" name="host" value="myntra">
              <button type="submit" id="search"  class="">
                <img src="/src/image/logo/myntra.png" height="20" width="20"></button>
            </form>
            <form action="screen3" method="POST"  id="mf" class="form-group" style="float:right;">
              <input type="hidden" name="subid" value="{$subproduct->id}">
              <input type="hidden" name="superid" value="{$subproduct->sid}">
              <input type="hidden" name="host" value="jabong">
              <button type="submit" id="search"  class="">
                <img src="/src/image/logo/jabong.png" height="20" width="20" alt="Jabong"></button>
            </form>
            <form action="screen3" method="POST"  id="mf" class="form-group" style="float:right;">
              <input type="hidden" name="subid" value="{$subproduct->id}">
              <input type="hidden" name="superid" value="{$subproduct->sid}">
              <input type="hidden" name="host" value="flipkart">
              <button type="submit" id="search"  class="">
                <img src="/src/image/logo/flipkart.png" height="20" width="20" alt="Flipkart"></button>
            </form>
            <form action="screen3" method="POST"  id="mf" class="form-group" style="float:right;">
              <input type="hidden" name="subid" value="{$subproduct->id}">
              <input type="hidden" name="superid" value="{$subproduct->sid}">
              <input type="hidden" name="host" value="amazon">
              <button type="submit" id="search"  class="">
                <img src="/src/image/logo/amazon.png" height="20" width="20" alt="Amazon"></button>
            </form></td> -->
      </tr>

    </tbody>
  </table>
  </div> <!-- row -->
             <div id="loadsearch" class="container" style="height: 350px; overflow: scroll;">
               <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>MRP</th>
                    <th>Price</th>
                    <th>Disc.</th>
                    <th>Store</th>
                  </tr>
                </thead>
                <tbody>

             {for $i=0 to $searchcount }
                  <tr>
                    <td><a href="{$product->link[$i]}">
                        <img src="{$product->src[$i]}" height="50" width="50" alt="MS"></a></td>
                    <td>{$product->title[{$i}]} </td>
                    <td>{$product->priceoriginal[$i]}</td>
                    <td>{$product->price[$i]}</td>
                    <td>{round((($product->priceoriginal[$i]-$product->price[$i])/$product->priceoriginal[$i])*100)}</td>
                    <td><form action="/page/1" method="POST">
                        <input type="hidden" name="url" value="{$product->link[$i]}">
                        <input type="hidden" name="subid" value="{$subproduct->id}">
                        <button type="submit"  class="btn btn-primary btn-block">Save</button>
                        </form></td>
                  </tr>
            {/for}
                </tbody>
              </table>
            </div>
    </div> <!-- #container -->
</div><!-- #main -->


<footer>

</footer>



</div><!-- /#wrapper -->
</body>


<script type="text/javascript">
    function searchLoad(){
        var key=document.getElementById('key').value;
        document.getElementById("searchbtn").disabled = true;
        document.getElementById("searchbtn").className = "btn btn-danger";
        document.getElementById("searchbtn").innerHTML = "Searching...";

        var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
             document.getElementById("loadsearch").innerHTML = "";
             document.getElementById("loadsearch").innerHTML = this.responseText;
             document.getElementById("searchbtn").disabled = false;
             document.getElementById("searchbtn").className = "btn btn-primary";
             document.getElementById("searchbtn").innerHTML = "Search";

            }
          };
          xhttp.open("GET", "search?searchkey="+key, true);
          xhttp.send();
    }
</script>
