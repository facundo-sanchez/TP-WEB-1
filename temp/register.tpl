<article class = "form-login">
<h1 class="card-title p-3">Register</h1>

<form action = 'register' class = "m-3" method ="POST">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" id="inputEmail4" placeholder="Name" name ="user_name" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Surname</label>
      <input type="text" class="form-control" id="inputPassword4" placeholder="Surname" name ="user_surname" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Email</label>
    <input type="email" class="form-control" id="inputAddress" placeholder="example@example.com" name ="user_email" required>
  </div>
  <div class="form-group">
    <label for="inputAddress2">Password</label>
    <input type="password" class="form-control" id="inputAddress2" placeholder="" name ="user_pass" required>
  </div>
    <div class="form-group">
    <label for="inputAddress2">Repeat Password</label>
    <input type="password" class="form-control" id="inputAddress2" placeholder="" name ="user_repeat_pass" required>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
  </div>
    {if $error === true}
        <div class="alert alert-danger" role="alert">
          {$msg}
        </div>
    {elseif $error === false}
        <div class="alert alert-success" role="alert">
            The email has been registered correctly!
        </div>
    {/if}
    
</form>
</article>
{include file="./footer.tpl"}