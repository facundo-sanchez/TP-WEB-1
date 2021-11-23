<article>

    <div class="card card-body border-secondary text-center m-3">
    
        {if $success == false}
            <form action="update-news" method="POST" enctype = 'multipart/form-data'>
                <label class="form-control-sm">News ID</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="id_news" id="exampleRadios1" value="{$news->id}" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        #{$news->id}
                    </label>
                </div>

                <label class="form-control-lg">Update News</label>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Title</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="title_news" value ='{$news->title}' required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Category select</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="category_news" required>
                        {foreach from=$category item=$cat}
                            {if $cat->category != 'Undefined'}
                                <option value="{$cat->id}">{$cat->category}</option>
                            {/if}     
                        {/foreach}  
                    </select>
                </div>
                <div class="custom-file">
                   <input type="file" name = 'input_file' class="custom-file-input" id="customFileLang" lang="es">
                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                </div>
                <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description_news" required>{$news->description}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        {/if}
        {if $success == true}
            <div class="jumbotron">
                <h1 class="display-4">Update News!</h1>
                <p class="lead">The news ID:#{$news->id} Title:{$news->title} was updated</p>
                <hr class="my-4">
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="admin/" role="button">Go Admin</a>
                </p>
            </div>
        {/if}
    </div>
</article>
{include file="./footer.tpl"}