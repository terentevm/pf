<div class="page-header">
    <h2>Please fill registration form!</h2>
</div>
<?php if(isset($_SESSION['error'])):?>
        
    
<div class="alert alert-danger" role="alert">
<?= $_SESSION['error']?>
</div>
<?php endif;?>
<?php if(isset($_SESSION['error'])) unset($_SESSION['error'])?>

<form action='/user/signup' method='post'>
  <div class="form-group">
    <label for="InputName">Your name</label>
    <input type="text" name="name" class="form-control" id="InputName" placeholder="Enter name">
  </div>
    
   <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="login" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="InputPassword1" placeholder="Password">
  </div>

    <button type="submit" name="buttonregister" class="btn btn-primary active">Register</button>
</form>

