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

  <div class='card m-5'>
  <form id='form'>
    <div class="form-group m-2">
    <input class="form-check-input d-none" type="radio" name="id_news" id="exampleRadios1" value="{$news->id}" checked>
      <label for="exampleFormControlSelect1">Puntos</label>
      <select class="form-control" id="exampleFormControlSelect1" name ='points'>
          <option value = '1'>1</option>
          <option value = '2'>2</option>
          <option value = '3'>3</option>
          <option value = '4'>4</option>
          <option value = '5'>5</option>
      </select>
    </div>
    <div class="form-group m-2">
      <label for="exampleFormControlTextarea1">Comments</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='comment'></textarea>
    </div>

    <div class="col-auto">
      <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>
  </form>
</div>



<div class='card m-5'>
  <div class="card-header">
   <div class="d-flex flex-row align-items-center justify-content-between">
     <h6 class="">Comments</h6>
        <div class="dropdown no-arrow">
          <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw">Order/Filter</i>
           </a>
           <div class="dropdown-menu dropdown-menu-right shadow " aria-labelledby="dropdownMenuLink">
              <div class="dropdown-header">Order:</div>
              <a class="dropdown-item" data-order="asc"  data-option='point'>ASC Points</a>
              <a class="dropdown-item" data-order="desc" data-option='point'>DESC Points</a>
              <a class="dropdown-item" data-order="asc" data-option='date'>ASC Date</a>
              <a class="dropdown-item" data-order="desc" data-option='date'>DESC Date</a>
              <div class="dropdown-divider"></div>
              <div class="dropdown-header">Filter:</div>
              <a class="dropdown-item" data-filter="1">1</a>
              <a class="dropdown-item" data-filter="2">2</a>
              <a class="dropdown-item" data-filter="3">3</a>
              <a class="dropdown-item" data-filter="4">4</a>
              <a class="dropdown-item" data-filter="5">5</a>
           </div>
        </div>
      </div>
  </div>

  <div class="alert alert-warning alert-dismissible fade show d-none" id='alert_filter' role="alert">
   Filter applied! <strong> <a id='filter_delete'>Click Here</a></strong> to remove filter.
  </div>
  <div class="alert alert-danger alert-dismissible fade show" id = 'filter_not_found' role="alert">
    Comments Not Found.
  </div>
  <!--Comentarios-->

  {literal}

    <article class='comments' id = 'comments'>
      <div class="card comments-card" v-for='c in comments'>
        <div class="card-header" style="height: 50px;">
        <p>Points: <strong>{{c.points}}</strong> Date: <strong>{{c.date}}</strong></p>      
        </div>
        <div class="card-body">
          {{c.comment}}
          <button class="btn btn-danger p-1 m-2" v-if ='' v-bind:data-id='c.id'>Delete</button>
        </div>
      </div>
    </article>
    
  {/literal}

</div>
</article>
<script src="./js/api-comments.js"></script>
{include file="./footer.tpl"}