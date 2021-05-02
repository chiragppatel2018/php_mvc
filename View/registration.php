<div class="row justify-content-center">
<div class="col-9">
<form method="POST" action="">
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= $name; ?>" id="name" />
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" class="form-control" value="<?= $email; ?>" id="email" />
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="<?= $username; ?>" id="username" />
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Conform Password</label>
    <input type="password" name="cpassword" class="form-control" id="exampleInputPassword1">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>