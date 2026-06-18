<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>dist/bootstrap.min.css">
  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="https://uifreshnet.github.io/login-1/assets/css/all.min.css">
  <style type="text/css">
   :root {
    --primary-color: #842029;
    --primary-color-hover: #5a1118;
  }
  html, body{
    height: 100%;
  }
  body{
    display: flex;
    align-items: center;
    background: linear-gradient(90deg, rgba(235,238,174,1) 0%, rgba(168,198,154,1) 48%);
  }
  a{
    color: var(--primary-color);
    text-decoration: none;
  }
  a:hover{
    color: var(--primary-color-hover);
  }
  .uf-form-signin {
    width: 100%;
    max-width: 350px;
    padding: 15px;
    margin: auto;
  }
  .uf-input-group .input-group-text {
    background: #ffffff70;
    color: #f8f9fa;
    border: unset;
    font-size: 18px;
    padding: 15px;
    width: 50px;
  }

  .uf-input-group .form-control {
    border: unset;
    border-left: 1px solid #ffffff05;
    font-size: 16px;
    background: #ffffff70;
  }

  .uf-input-group .form-control:focus {
    box-shadow: unset;
    background: #ffffff;
  }
  .uf-btn-primary {
    background-color: var(--primary-color);
    color: #fff;
  }

  .uf-btn-primary:hover {
    background: var(--primary-color-hover);
    color: #fff;
  }

  .uf-form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
  }

  .uf-social-login .uf-social-ic+.uf-social-ic{
    margin-left: 15px;
  }
  .uf-social-ic{
    width: 40px;
    height: 40px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .uf-social-ic:hover{
    background: var(--maincolor);
  }
  .uf-social-ic:hover i{
    color: #fff;
  }
</style>
<title>Login</title>

</head>
<body>
  <div class="uf-form-signin">
    <div class="text-center">
      <a href=""><img src="<?php echo base_url();?>assets/logo.png" alt="" width="100" height="100"></a>
      <h1 class="text-white h3">Account Login</h1>
    </div>

    <form class="mt-4">
      <div class="input-group uf-input-group input-group-lg mb-3">
        <span class="input-group-text fa fa-user"></span>
        <input type="text" class="form-control" id="username" placeholder="Username">
      </div>
      <div class="input-group uf-input-group input-group-lg mb-3">
        <span class="input-group-text fa fa-lock"></span>
        <input type="password" class="form-control" id="password" placeholder="Password">
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="remember_me">
        <label class="form-check-label text-white" for="remember_me">
          Keep me signed in
        </label>
      </div>
      <div class="d-grid mb-4">
        <button type="button" id="login" class="btn uf-btn-primary btn-lg">Login</button>
      </div>
    </form>
  </div>
  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>dist/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>dist/sweetalert2.js"></script>
  <script type="text/javascript">
    $('#login').click(function(e){
      e.preventDefault();

      var username  = $("#username").val();
      var password  = $("#password").val();
      var remember  = $("#remember_me").is(':checked') ? 1 : 0;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Auth/processlogin",
        dataType: "json",
        data: {
          username: username,
          password: password,
          remember: remember
        },
        success : function(data){
          if (data.code == "200"){
            window.location.href = "<?php echo base_url(); ?>Dashboard";
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.msg,
            })
          }
        }
      });
    });
</script>
</body>
</html>