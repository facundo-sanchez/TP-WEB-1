<article>
<div class='card m-5'>
        <div class='card-header'><h2>
          {$news->title}</h2>
        </div>
        <div class='card-body'>
          <blockquote class='blockquote mb-0'>
            <p>{$news->description}</p>
            <footer class='blockquote-footer'>Categoria: <cite title='Source Title'>{$news->category}</cite></footer>
          </blockquote>
        </div>
</div>
</article>
{include file="./footer.tpl"}