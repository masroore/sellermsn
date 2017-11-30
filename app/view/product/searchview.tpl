
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <title>Search Product</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
   <!--  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style type="text/css">
    
    </style>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->




</head>


<body>
<div class="container">
  <h6>Search List     Count : {$searchcount}</h6>
  <p> </p>            
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
        <td><a href="{$product->link[$i]}">
            <img src="{$product->src[$i]}" height="50" width="50" alt="MS"></a></td>
        <td>{$product->title[$i]} </td>
        <td>{$product->priceoriginal[$i]}</td>
        <td>{$product->price[$i]}</td>
        <td>{round((($product->priceoriginal[$i]-$product->price[$i])/$product->priceoriginal[$i])*100)}</td>
        <td><form action="/page/1" method="POST">
        <input type="hidden" name="url" value="{$product->link[$i]}">
        <input type="hidden" name="subid" value="{$superproduct->id}">
        <button type="submit" name="" value="Save" class="btn btn-primary btn-block">Save</button>
            </form></td>
      </tr>
{/for}
    </tbody>
  </table>
</div>
</body>
</html>
