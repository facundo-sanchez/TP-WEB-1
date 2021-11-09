<article>
    <div class="card card-body border-secondary text-center m-3">
    {if $success == false}
        <!--Form con post-->
        <form action="update-category" method="POST">
            <label class="form-control-sm">Category ID</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="id_category" id="exampleRadios1" value="{$cate->id}" checked>
                <label class="form-check-label" for="exampleRadios1">
                    #{$cate->id}
                </label>
            </div>
            <label class="form-control-lg">Update Category</label>
            <div class="form-group">
                <label for="exampleFormControlInput1">Title</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="title_category" value ='{$cate->category}' required>
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Description</label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description_category" required>{$cate->description}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    {/if}
    {if $success == true}
        <div class="jumbotron">
            <h1 class="display-4">Update Category!</h1>
            <p class="lead">The Category ID:#{$cate->id} Title:{$cate->category} was updated</p>
            <hr class="my-4">
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="admin/" role="button">Go Admin</a>
            </p>
        </div>
    {/if}
    </div>
</article>
{include file="./footer.tpl"}