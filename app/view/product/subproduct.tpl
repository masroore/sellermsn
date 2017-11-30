      <table class="table table-striped">
    <thead>
      <tr>
        <th>SPID</th>
        <th>SPSID</th>
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
        <td>{$sp->color}</td>
        <td>{$sp->price}</td>
        <td>{$sp->material}</td>
        <td>{$sp->rating}</td>
        <td>{$sp->pattern}</td>
        <td>{$sp->size}</td>
        <td>{$sp->sex}</td>
        <td>
        <form action="screen3" method="POST" target="_blank" id="mf" class="form-group">
        <input type="hidden" name="subid" value="{$sp->id}">
        <input type="hidden" name="superid" value="{$sp->sid}">
        <button type="submit" id="search"  class="btn btn-primary btn-block">Save</button>
        </form>
            </td>
      </tr>
{/foreach}
    </tbody>
  </table>            

