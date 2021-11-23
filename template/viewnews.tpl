<article>
<div class='card m-5'>
        <div class='card-header'>
        <h2>{$news->title}</h2>
        
        </div>
        <div class='card-body'>
          <blockquote class='blockquote mb-0'>
          {if isset($news->img) && $news->img != null}
          <img class="w-50 card-img-top align-items-center" src="{$news->img}" alt="Card image cap">
        {else}
            <img class="w-50 card-img-top m-auto" src="https://farm5.staticflickr.com/4363/36346283311_74018f6e7d_o.png" alt="Card image cap">
        {/if}

            <p>{$news->description}</p>
            <footer class='blockquote-footer'>Categoria: <cite title='Source Title'>{$news->category}</cite></footer>
          </blockquote>
        </div>
</div>
{if isset($smarty.session.user_id)}
  <div class='card m-5'>
  <form id='form'>
    <div class="form-group m-2">
    <input class="form-check-input d-none" type="radio" name="id_news" id="exampleRadios1" value="{$news->id}" checked required>
      <label for="exampleFormControlSelect1">Points</label>
      <select class="form-control" id="exampleFormControlSelect1" name ='points' required>
          <option value = '1'>1</option>
          <option value = '2'>2</option>
          <option value = '3'>3</option>
          <option value = '4'>4</option>
          <option value = '5'>5</option>
      </select>
    </div>
    <div class="form-group m-2">
      <label for="exampleFormControlTextarea1">Comments</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='comment' required></textarea>
    </div>

    <div class="col-auto">
      <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>
  </form>
</div>
{/if}
  

<article class = 'content-view-news'>

<div class='card m-5 content-filter'>

  <form id="search-comment" class="p-2"  method='get'>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Order</label>
    <select class="form-control" name ='order'>
      <option value ='none'>None</option>
      <option value ='asc-date'>Ascending Date</option>
      <option value ='des-date'>Descending Date</option>
      <option value ='asc-point'>Ascending Points</option>
      <option value ='des-point'>Descending Points</option>
    </select>
  </div>
    <div class="form-group">
    <label for="exampleFormControlSelect1">Filter</label>
    <select class="form-control" name='points'>
      <option value ='1'>1</option>
      <option value ='2'>2</option>
      <option value ='3'>3</option>
      <option value ='4'>4</option>
      <option value ='5'>5</option>
    </select>
  </div>
    <div>
      <button type="submit" class="btn btn-primary ">Search</button>
    </div>
  </form>
</div>


<div class='card m-5 content-comment'>
  <div class="card-header">
   <div class="d-flex flex-row align-items-center justify-content-between">
     <h6 class="">Comments</h6>
    </div>
  </div>
      <div class="alert alert-warning alert-dismissible fade show d-none" id='alert_filter' role="alert">
    Filter applied! <strong> <a id='filter_delete'>Click Here</a></strong> to remove filter.
    </div>
    <div class="alert alert-danger alert-dismissible fade show" id = 'filter_not_found' role="alert">
      Comments Not Found.
    </div>

    
    <article class='comments' id = 'comments' data-comment = '{$news->id}'>
      
     {literal}
        <div class="card comments-card" v-for='c in comments'>
          <div class="card-header" style="height: 80px;">
          <p><strong>{{c.name}} {{c.surname}}</strong><span class="badge badge-primary ml-3" v-if='c.role == 0'>User</span><span class="badge badge-success ml-3" v-if='c.role == 1'>Admin</span></p>
          <p>Points: <strong>{{c.points}}</strong> Date: <strong>{{c.date}}</strong></p>      
          </div>
          <div class="card-body">
            {{c.comment}}
            {/literal}
            {if isset($smarty.session.user_id) && $smarty.session.role == 1}
              <button class="btn btn-danger p-1 m-2" v-if ='' v-bind:data-id='c.id'>Delete</button>
            {/if}
          
          </div>
        </div>
   
    </article>
</div>
</article>

</article>

<script src="./js/comments/main-comments.js" type = 'module'></script>
{include file="./footer.tpl"}