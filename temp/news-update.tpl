<article>

    <div class="card card-body border-secondary text-center m-3">
                        <!--Form con post-->
        <form id="formupdate-news" method="POST">
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
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Description</label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description_news" required>{$news->description}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div id="send-error-news" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
            <strong>Error!</strong> Server Error.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="send-success-news" class="alert alert-success alert-dismissible fade show d-none" role="alert">
            <strong>Ready!</strong> The news was sent successfully
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="jumbotron d-none" id="content-update">
            <h1 class="display-4">Update News!</h1>
            <p class="lead">The news ID:#{$news->id} Title:{$news->title} was updated</p>
            <hr class="my-4">

            <p class="lead">
                <a class="btn btn-primary btn-lg" href="admin" role="button">Go Admin</a>
            </p>
        </div>
        <div  id="error-update" class="alert alert-danger d-none" role="alert">
           Server ERROR <a href="confirm-update-news/{$news->id}" class="alert-link">click here</a>. to try again.
        </div>
    </div>
</article>
<script src="./js/formUpdateNews.js"></script>