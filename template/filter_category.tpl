<main >
    <article class="content-main">
        {foreach from=$news item=$n}
            <article class="card card-news">
            
                {if isset($n->img) && $n->img != null}
                    <img class="card-img-top" src="{$n->img}" alt="Card image cap">
                {else}
                    <img class="card-img-top" src="https://farm5.staticflickr.com/4363/36346283311_74018f6e7d_o.png" alt="Card image cap">
                {/if}

                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">{$n->category}</h6>
                    <h5 class="card-title">{$n->title}</h5>
                    <p class="card-text">{$n->description}</p>
                    <a href="news/{$n->id}" class="btn btn-dark">Ver mas</a>
                </div>
            </article>
        {/foreach}   
    </article>
</main>

{include file="./footer.tpl"}
