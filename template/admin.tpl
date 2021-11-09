<div id="accordion">
   <h1>Admin: {$user->name} {$user->surname}</h1>

    <main class=''>
        <div class="content-news-admin">
            <!--Recortar esto para el forench-->
            {foreach from=$news item=$n}
            <div class="card-body">
                <div class="card text-center  border-secondary m-3">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <button type="button" class="btn btn-primary"><a class="text-light" href="update-news/{$n->id}">Update</a></button>
                                <button type="button" class="btn btn-danger"><a class="text-light" href="confirm-delete-news/{$n->id}">Delete</a></button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                    {if isset($n->img) && $n->img != null}
                        <img class="card-img-top p-5" src="{$n->img}" alt="Card image cap">
                    {else}
                        <img class="card-img-top  p-5" src="https://farm5.staticflickr.com/4363/36346283311_74018f6e7d_o.png" alt="Card image cap">
                    {/if}
                        <h6 class='card-subtitle mb-2 text-muted'>Categoria: {$n->category}</h6>
                        <h5 class="card-title">{$n->title}</h5>
                        <p class="card-text">{$n->description}</p>
                    </div>
                </div>
            </div>
            {/foreach}
        </div>
          <article class = 'pagination-news'>
            <nav aria-label="..."  class='nav-pagination'>
                <ul class="pagination">
                    {if $page-1 <1}
                        <li class="page-item disabled"><a class="page-link" href="admin/{$page-1}" tabindex="-1">Previous</a></li>
                    {else}
                        <li class="page-item"><a class="page-link" href="admin/{$page-1}" tabindex="-1">Previous</a></li>
                    {/if}
                          
                    {for $i = 1 to $page_count}
                        {if $page == $i}
                            <li class="page-item active"><a class="page-link" href="admin/{$i}">{$i}</a></li>
                        {else}
                            <li class="page-item"><a class="page-link" href="admin/{$i}">{$i}</a></li>
                        {/if}
                       
                    {/for}

                    {if $page+1 > $page_count}
                        <li class="page-item disabled"><a class="page-link" href="admin/{$page+1}">Next</a></li>
                    {else}
                        <li class="page-item"><a class="page-link" href="admin/{$page+1}">Next</a></li>
                    {/if}
                            
                </ul>
            </nav>
        </article>
    </main>

    <div class="card border-secondary m-5">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Send News / Category
                  </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link active" id="news-button">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="category-button">Categories</a>
                        </li>
                    </ul>
                </div>
               
                    <div class="card-body">
                        <!--Form con post-->
                        <form action="send-news" id='formsend-news' method="POST" enctype = 'multipart/form-data'>
                            <label class="form-control-lg">Send News</label>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Title</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="title_news" required>
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
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description_news" required></textarea>
                            </div>
                            <div class="custom-file">
                                <input type="file" name = 'input_file' class="custom-file-input" id="customFileLang" lang="es">
                                <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                            </div>
                            <button type="submit" class="btn btn-primary m-2">Submit</button>
                        </form>
                        <div id="send-error-news" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                          <strong>Error!</strong> Server Error.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div id="send-success-news" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                          <strong>Ready!</strong> The news was sent successfully, Reloading page...
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <!--FORMULARIO CATEGORY-->
                        <form id="formsend-category" class='d-none' method="POST">
                            <label class="form-control-lg">Send Category</label>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Title</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="title_category" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="description_category" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <div id="send-error-category" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                          <strong>Error!</strong> Server Error.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div id="send-success-category" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                          <strong>Ready!</strong> The category was sent successfully, Reloading page...
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    </div>
              
            </div>

        </div>
    </div>
    
    <div class="card card border-secondary m-5">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Update/Delete Category
                  </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class='content-main'>
                    <!--For-->
                    {foreach from=$category item=$cate } 
                    {if $cate->category !='Undefined'}
                        <div class="card-body">
                            <div class="card text-center  border-secondary m-3">
                                <div class="card-header">
                                    <ul class="nav nav-pills card-header-pills">
                                        <li class="nav-item">
                                            <button type="button" class="btn btn-primary"><a class="text-light" href="update-category/{$cate->id}">Update</a></button>
                                            <button type="button" class="btn btn-danger"><a class="text-light" href="confirm-delete-category/{$cate->id}">Delete</a></button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h6 class='card-subtitle mb-2 text-muted'>ID: #{$cate->id}</h6>
                                    <h5 class="card-title">{$cate->category}</h5>
                                    <p class="card-text">{$cate->description}</p>
                                </div>
                            </div>
                        </div>
                    {/if} 
                    {/foreach}
                    <!--For-->
                </div>
            </div>
            <!--Recortar esto para el forench-->
        </div>
    </div>
    <div class="card border-secondary m-5">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Users
                  </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="content-main-users">
                <!--For-->
                {foreach from=$users item=$u } 
                    <div class="card-body">
                        <div class="card text-center  border-secondary m-3">
                            <div class="card-header">
                                <ul class="nav nav-pills card-header-pills">
                                    <li class="nav-item">
                                        <button type="button" class="btn btn-success"><a class="text-light" href="update-admin/{$u->id}">Add Admin</a></button>
                                        <button type="button" class="btn btn-warning"><a class="text-light" href="remove-admin/{$u->id}">Remove Admin</a></button>
                                        <button type="button" class="btn btn-danger"><a class="text-light" href="confirm-delete-user/{$u->id}">Delete User</a></button>
                                          
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h6 class='card-subtitle mb-2 text-muted'>ID: #{$u->id}</h6>
                                <h5 class="card-title">Name:{$u->name} {$u->surname}</h5>
                                <p class="card-text">Email: {$u->email}</p>
                                <p class="card-text">Role: {$u->role}</p>
                            </div>
                        </div>
                    </div>
                {/foreach}

                <!--For-->
            </div>
        </div>
    </div>
</div>
</div>
<script src="./js/formSend.js"></script>

{include file="./footer.tpl"}