{if $delete === false}
  <div class="card m-5">
    <h5 class="card-header">{$title}</h5>
    <div class="card-body">
      <h5 class="card-title">Do you want to confirm this operation?</h5>
    
      <a href="{$url}/{$id}" class="btn btn-danger">Yes delete</a>
      <a href="admin/" class="btn btn-primary">Go Admin</a>
    </div>
  </div>

  {elseif $delete === true}
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">News or Category Delete!</h4>
        <p>The news or the category has been deleted successfully.</p>
        <hr>
        <a href="admin/" class="alert-link">Click Here</a> to Admin.
    </div>
  </div>
{/if}

{include file="./footer.tpl"}