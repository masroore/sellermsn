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
        <div class="row" >
          <h6>Super Product <a href="view" >Add New Super Product </a>
                <form style="float:right;" action="getsuper" method="GET" >
                <input type="text" name="id" placeholder="Enter Super Product Id">
                <button type="sumbit"> Find   </button>
                </form>     </h6>
            <div  class="col-md-4">
                PID :   {$superproduct->id}
            </div>
            <div  class="col-md-8">
                Title :   {$superproduct->title}
            </div>
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
                Platform :   {$superproduct->platform}
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

          <h6>Sub Product</h6>
    <form action="addsubproduct" method="POST" id="mf" class="form-group">
            <input type="hidden" name="sid" id="sid" value="{$superproduct->id}" >

            <input type="text" name="image" id="image" placeholder="Image of the Product" >

            <input type="text" name="color" id="color" placeholder="Color of the Product" >

            <input type="text" name="price" id="price" placeholder="Price" >

            <select  name="material" id="material" >
                    <option value="0" selected>Select Material</option>
                    <option value="cotton">Cotton</option>
                    <option value="polyster">Polyster</option>
                    <option value="0">Other</option>
            </select>

            <select  name="rating" id="rating" >
                    <option value="0" selected>Select Ratings</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
            </select>

            <select  name="pattern" id="pattern">
                    <option value="0" selected>Select Pattern</option>
                    <option value="solid">solid</option>
                    <option value="printed">Printed</option>
                    <option value="striped">Striped</option>
                    <option value="checked">Checked</option>
                    <option value="0">Other</option>
            </select>

            <select  name="size" id="size">
                    <option value="0" selected>Select Size</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="XXXL">XXXL</option>
            </select>

            <label class="radio-inline"><input type="radio" id="sex" value="men" name="sex">Men</label>
            <label class="radio-inline"><input type="radio" id="sex" value="women" name="sex">Women</label>
            <label class="radio-inline"><input type="radio" id="sex" value="unisex" name="sex">Unisex</label>

            <input type="submit" value="Add" onclick="" id="addbtn" >
    </form>

    <div id="subproductlist">
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
             {foreach $subproduct as $sp}
                  <tr>
                    <td>{$sp->id}</td>
                    <td>{$sp->sid}</td>
                    <td><img src="{$sp->image}" height="50" width="50" alt="MS"></td>
                    <td>{$sp->color}</td>
                    <td>{$sp->price}</td>
                    <td>{$sp->material}</td>
                    <td>{$sp->rating}</td>
                    <td>{$sp->pattern}</td>
                    <td>{$sp->size}</td>
                    <td>{$sp->sex}</td>
                    <td>
                     <!--  <form action="screen3" method="POST" target="_blank" id="mf" class="form-group" style="float:right;">
                        <input type="hidden" name="subid" value="{$sp->id}">
                        <input type="hidden" name="superid" value="{$sp->sid}">
                        <input type="hidden" name="host" value="myntra">
                        <button type="submit" id="search"  class="">
                          <img src="/src/image/logo/myntra.png" height="20" width="20"></button>
                      </form>
                      <form action="screen3" method="POST" target="_blank" id="mf" class="form-group" style="float:right;">
                        <input type="hidden" name="subid" value="{$sp->id}">
                        <input type="hidden" name="superid" value="{$sp->sid}">
                        <input type="hidden" name="host" value="jabong">
                        <button type="submit" id="search"  class="">
                          <img src="/src/image/logo/jabong.png" height="20" width="20" alt="Jabong"></button>
                      </form>
                      <form action="screen3" method="POST" target="_blank" id="mf" class="form-group" style="float:right;">
                        <input type="hidden" name="subid" value="{$sp->id}">
                        <input type="hidden" name="superid" value="{$sp->sid}">
                        <input type="hidden" name="host" value="flipkart">
                        <button type="submit" id="search"  class="">
                          <img src="/src/image/logo/flipkart.png" height="20" width="20" alt="Flipkart"></button>
                      </form>
                      <form action="screen3" method="POST" target="_blank" id="mf" class="form-group" style="float:right;">
                        <input type="hidden" name="subid" value="{$sp->id}">
                        <input type="hidden" name="superid" value="{$sp->sid}">
                        <input type="hidden" name="host" value="amazon">
                        <button type="submit" id="search"  class="">
                          <img src="/src/image/logo/amazon.png" height="20" width="20" alt="Amazon"></button>
                      </form></td> -->
                  </tr>
            {/foreach}
                </tbody>
              </table>
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