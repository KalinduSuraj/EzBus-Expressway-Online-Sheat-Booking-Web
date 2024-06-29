<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Link Style-->
    <link rel="stylesheet" href="signupStyle.css">
    
    <!--Boostrap CDN-->
    <link rel="stylesheet" href=" 	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src=" 	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" > </script>

    
    <title>Sign Up</title>
</head>
<body class="body">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top ">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="src/" alt="Logo"></a> <!-- Add logo -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
  <!-- End Navigation -->

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
    <div class="col-md-8 col-lg-7 col-xl-6">
        <img id="genarateImg"
          class="img-fluid " src="src/img1.png" alt="Register img">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form>
          <h1 class="text-center title">Sign Up</h1>
          <!-- email input -->
          <div data-mdb-input-init class="form-outline mb-4 email">
            <img src="src/Email.png" alt="user" class="emailImg">
            <input type="email" name="email" class="form-control form-control-lg" placeholder="Email"/>
          </div>
          
          <!-- name input -->
          <div data-mdb-input-init class="form-outline mb-4 name">
            <img src="src/Id-card.png" alt="user" class="nameImg">
            <input type="text" name="name" class="form-control form-control-lg" placeholder="Name"/>
          </div>

          <!-- userName input -->
          <div data-mdb-input-init class="form-outline mb-4 userName">
            <img src="src/User.png" alt="user" class="userImg">
            <input type="text" name="userName" class="form-control form-control-lg" placeholder="UserName"/>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-4 password">
          <img src="src/Padlock.png" alt="pw" class="pwImg">
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password"/>
          </div>

          <div class="d-flex justify-content-around align-items-center mb-4">
            <!-- Checkbox -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
              <label class="form-check-label"> Remember me </label>
            </div>
            <div>
                <div class="col ">
                    <div class="row"> 
                      <label>Have Account?<a href="signIn.php" class="create"> Sign In</a></label> 
                    </div>
                </div>
            </div>
          </div>
          <!-- Submit button -->
          <button type="submit"  class="btn btn-primary btn-lg btn-block btn-signUp">Sign Up</button>
        </form>
      </div>
    </div>
  </div>
</section>
</body>
</html>