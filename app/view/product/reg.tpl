<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Product Interface</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="/src/style/default.css"/>
    </head>
    <body>    
        <form action="screen3" method="POST" target="_blank" id="mf" class="register">
            <h1>Product Interface <textarea rows="3" cols="40" id="key" name="search">
          Blue Shirt for men   </textarea><br></h1>
            <fieldset class="row1">
                <legend>Super Product
                </legend>
                <p>
                    <label>PID *
                    </label>
                    <input type="text" name="pid" class="form-control" value="{$pid}" placeholder="Product Id/Catalogue Id" readonly/>
                    <label>Title *
                    </label>
                    <input type="text" name="name" class="form-control" value="{$name}" placeholder="Name/Title of the Product" readonly/>
                </p>
                <p>
                    <label>Image*
                    </label>
                    <input type="text" name="image" class="form-control" value="{$image}" placeholder="Image URL of Product" readonly/>
                    <label>Country *
                    </label>
                    <select name="type"  value="{$type}" readonly>
                    <option  value="0" selected>Select Product Type</option>
                    <option {($type === 'cloth') ? 'selected="selected"':'disabled'} value="cloth">Cloth</option>
                    <option {($type === 'footwear') ? 'selected="selected"':'disabled'} value="footwear">Footwear</option>
                    <option {($type === 'eyewear') ? 'selected="selected"':'disabled'} value="eyewear">Eye Wear</option>
                    <option {($type === '0') ? 'selected="selected"':'disabled'} value="0">Other</option> 
                    </select>
                </p>
                <p>
                    <label>Family *
                    </label>
                    <select name="family"  value="{$family}" readonly>
                     <option value="0" selected>Select Family</option>
                    <option {($family === 'jeans') ? 'selected="selected"':'disabled'} value="jeans">Jeans</option>
                    <option {($family === 'shirt') ? 'selected="selected"':'disabled'} value="shirt">Shirt</option>
                    <option {($family === 'saree') ? 'selected="selected"':'disabled'} value="saree">Saree</option>
                    <option {($family === 'suit') ? 'selected="selected"':'disabled'} value="suit">Suit</option>
                    <option {($family === '0') ? 'selected="selected"':'disabled'} value="0">Other</option>  
                    </select>
                    <label>Brand*
                    </label>
                    <input type="text" name="brand" class="form-control" value="{$brand}" placeholder="Product Brand" readonly/>
                    
                </p> 
                <p>
                    <label>Category *
                    </label>
                    <select value="{$country}" name="country" readonly>
                   <option value="0" selected>Select Category</option>
                    <option {($category === 'cloth') ? 'selected="selected"':'disabled'} value="cloth">Cloth</option>
                    <option {($category === 'footwear') ? 'selected="selected"':'disabled'} value="footwear">Footwear</option>
                    <option {($category === 'eyewear') ? 'selected="selected"':'disabled'} value="eyewear">Eye Wear</option>
                    <option {($category === '0') ? 'selected="selected"':'disabled'} value="0">Other</option> 
                    </select>
                    <label>Country *
                    </label>
                    <select value="{$country}" name="country" readonly>
                    <option value="0" selected>Select Country</option>
                    <option {($country === 'india') ? 'selected="selected"':'disabled'} value="india">India</option>
                    <option {($country === '0') ? 'selected="selected"':'disabled'} value="0">Other</option> 
                </select>
                </p>
                <p>
                    <label>State*
                    </label>
                    <select value="{$state}" name="state" readonly>
                    <option value="0" selected>Select State</option>
                    <option {($state === 'up') ? 'selected="selected"':'disabled'} value="up">UP</option>
                    <option {($state === '0') ? 'selected="selected"':'disabled'} value="0">Other</option> 
                </select>
                    <label>City*
                    </label>
                    <select value="{$city}" name="city" readonly>
                    <option value="0" selected>Select City</option>
                    <option {($city === 'noida') ? 'selected="selected"':'disabled'} value="noida">Noida</option>
                    <option {($city === '0') ? 'selected="selected"':'disabled'} value="0">Other</option> 
                </select>
                </p>   
                                                
            </fieldset>

            <fieldset class="row2">
                <legend>Sub Product
                </legend>
                <p>
                    <label>Color *
                    </label>
                    <input type="text" class="long" name="color" value="{$color}" placeholder="Color of the Product"/>
                </p>
                <p>
                    <label>Price *
                    </label>
                    <input type="text" name="price" value="{$price}" placeholder="Price"/>
                </p>
                <p>
                    <label>Material
                    </label>
                    <select  name="material" >
                    <option value="0" selected>Select Material</option>
                    <option {($material === 'cotton') ? 'selected="selected"':'disabled'} value="cotton">Cotton</option>
                    <option {($material === 'polyster') ? 'selected="selected"':'disabled'} value="polyster">Polyster</option>
                    <option {($material === '0') ? 'selected="selected"':'disabled'} value="0">Other</option> 
                    </select>
                </p>
                <p>
                    <label>Rating *
                    </label>
                    <select  name="rating" >
                    <option  value="0" selected>Select Ratings</option>
                    <option {($rating === '1') ? 'selected="selected"':'disabled'} value="1">1</option>
                    <option {($rating === '2') ? 'selected="selected"':'disabled'} value="2">2</option>
                    <option {($rating === '3') ? 'selected="selected"':'disabled'} value="3">3</option>
                    <option {($rating === '4') ? 'selected="selected"':'disabled'} value="4">4</option>
                    <option {($rating === '5') ? 'selected="selected"':'disabled'} value="5">5</option>
                    </select>
                </p>
                <p>
                    <label>Pattern *
                    </label>
                    <select  name="pattern" >
                    <option value="0" selected>Select Pattern</option>
                    <option {($pattern === 'solid') ? 'selected="selected"':'disabled'} value="solid">solid</option>
                    <option {($pattern === 'printed') ? 'selected="selected"':'disabled'} value="printed">Printed</option>
                    <option {($pattern === 'striped') ? 'selected="selected"':'disabled'} value="striped">Striped</option>
                    <option {($pattern === 'checked') ? 'selected="selected"':'disabled'} value="checked">Checked</option>
                    <option {($pattern === '0') ? 'selected="selected"':'disabled'} value="0">Other</option> 
                     </select>
                </p>
                <p>
                    <label>Size
                    </label>
                    <select  name="size" >
                    <option value="0" selected>Select Size</option>
                    <option {($size === 'S') ? 'selected="selected"':'disabled'} value="S">S</option>
                    <option {($size === 'M') ? 'selected="selected"':'disabled'} value="M">M</option>
                    <option {($size === 'L') ? 'selected="selected"':'disabled'} value="L">L</option>
                    <option {($size === 'XL') ? 'selected="selected"':'disabled'} value="XL">XL</option>
                    <option {($size === 'XXL') ? 'selected="selected"':'disabled'} value="XXL">XXL</option>
                    <option {($size === 'XXXL') ? 'selected="selected"':'disabled'} value="XXXL">XXXL</option>
                    </select>

                </p>
                <p>
                    <label class="radio-inline"><input type="radio" value="men" name="sex" {($sex === 'men') ? 'checked':'disabled'}>Men</label>
                    <label class="radio-inline"><input type="radio" value="women" name="sex" {($sex === 'women') ? 'checked':'disabled'}>Women</label>
                    <label class="radio-inline"><input type="radio" value="unisex" name="sex" {($sex === 'unisex') ? 'checked':'disabled'}>Unisex</label>
                </p>
            </fieldset>
            <fieldset class="row3">
                <legend>Further Information
                </legend>
                <div class="container" style="height: 350px; overflow: scroll;">
               <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Std. Price</th>
                    <th>Price</th>
                    <th>Disc.</th>
                    <th>Store</th>
                  </tr>
                </thead>
                <tbody>

             {for $i=0 to $searchcount }
                  <tr>
                    <td><a href="https://jabong.com<?php echo $product->link[$i]; ?>">
                        <img src="{$product->src[$i]}" height="50" width="50" alt="MS"></a></td>
                    <td>{$product->title[{$i}]} </td>
                    <td>{$product->priceoriginal[$i]}</td>
                    <td>{$product->price[$i]}</td>
                    <td>{round((($product->priceoriginal[$i]-$product->price[$i])/$product->priceoriginal[$i])*100)}</td>
                    <td><form action="/page/1" method="POST">
                    <input type="hidden" name="url" value="https://jabong.com{$product->link[$i]}">
                    <button type="submit"  class="btn btn-primary btn-block">Save</button>
                         </form></td>
                  </tr>
            {/for}
                </tbody>
              </table>
            </div>
            </fieldset>
            <fieldset class="row4">
                <legend>Terms and Mailing
                </legend>
               <script type="text/javascript">
            function searchLoad(){
                var key=document.getElementById('key').value;
                document.getElementById("searchbtn").disabled = true;
                document.getElementById("searchbtn").className = "btn btn-danger";
                document.getElementById("searchbtn").innerHTML = "Searching...";

                var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                     document.getElementById("loadsearch").innerHTML = this.responseText;
                     document.getElementById("searchbtn").disabled = false;
                     document.getElementById("searchbtn").className = "button";
                     document.getElementById("searchbtn").innerHTML = "Search";

                    }
                  };
                  xhttp.open("GET", "search?searchkey="+key, true);
                  xhttp.send();
          }
        </script>
        <textarea rows="3" cols="40" id="key" name="search">
          Blue Shirt for men   </textarea><br>
        <button onclick="return searchLoad()" id="searchbtn" class="button">Search</button>

        <div id="loadsearch" style="height: 200px; overflow: scroll;"></div>
            </fieldset>
            <!-- <div><button class="button">Register &raquo;</button></div> -->
        </form>
    </body>
</html>





