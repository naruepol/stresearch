<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>LogIn</title>
  </head>
  <body>
  <form action="./checklogin.php" id="check_login">
  <section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">USER Log in</h3>

            <div class="form-outline mb-4">
              <input type="email" id="user_email_in" class="form-control form-control-lg" />
              <label class="form-label" for="user_email_in">Email</label>
            </div>

            <div class="form-outline mb-4">
              <input type="password" id="user_password_in" class="form-control form-control-lg" />
              <label class="form-label" for="user_password_in">Password</label>
            </div>

            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

            <hr class="my-4">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</form>
  </body>
</html>