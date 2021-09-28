<article>

    <div class="card card-body border-secondary text-center m-3">
                        <!--Form con post-->
        <form id="formupdate-category" method="POST">
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
            <h1 class="display-4">Update Category!</h1>
            <p class="lead">The Category ID:#{$cate->id} Title:{$cate->category} was updated</p>
            <hr class="my-4">

            <p class="lead">
                <a class="btn btn-primary btn-lg" href="admin" role="button">Go Admin</a>
            </p>
        </div>
        <div  id="error-update" class="alert alert-danger d-none" role="alert">
           Server ERROR <a href="confirm-update-news/{$cate->id}" class="alert-link">click here</a>. to try again.
        </div>
    </div>
</article>
<script src="./js/formUpdateCategory.js"></script>