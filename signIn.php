<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <!--Link Style.css-->
  <link rel="stylesheet" href="signinStyle.css">

  <!--Boostrap CDN-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> </script>

  <style>
    button {
      border-radius: 30px;
    }

    h1 {
      font-family: "palatino linotype", palatino, serif;
      color: azure;
    }

    label {
      color: azure;
    }

    .body {
      margin: 0;
      padding: 0;
      background-color: #071927;
      /*background-color: #282a35;*/
      background-image: url(src/bus.jpg.png);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 90vh
    }

    .form-control {
      margin-left: 10px;
    }

    .forget-pass:hover {
      color: #1e7dea;
    }

    .create {
      text-decoration: none;
      color: #1ebba3;
    }

    .create:hover {
      color: #1e7dea;
    }

    .btn-signIn {
      background-color: #06d001 !important;
      border-color: #06d001;
    }

    label {
      color: #282a35;
      font-weight: 600;
    }

    .loginpanel {
      background-color: white;
      border-radius: 10px;
      height: 33rem;
      width: 28rem;
    }

    button {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 5px;
      border: 1px solid gray;
      background-color: white;
      font-weight: 600;
      width: 10.7rem;
      padding: 0.2rem 1rem;
      cursor: pointer;
    }


    .google-btn {
      margin-right: 1rem;
    }

    button span {
      margin-right: auto;
    }

    button img {
      margin-left: auto;
      max-width: 1.5rem;
    }

    input {
      border: 1px solid gray;
      background-color: white;
    }

    .bottum-btns {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 5px;
      border: 1px solid gray;
      width: 10.7rem;
      padding: 0.2rem;
      cursor: pointer;
      font-weight: 600;

    }

    .forgte-btn {
      text-decoration: none;
    }

    .btn-login {
      background-color: #1ebba3;
      color: white;
      margin-left: 1rem;
      font-weight: 700;
    }

    .background-img {
      height: 30rem;
      width: 30rem;
    }

    .userImg {
      width: 30px;
      height: 30px;
      margin-top: 10px;
    }

    .pwImg {
      width: 30px;
      height: 30px;
      margin-top: 10px;
    }

    .userName {
      display: flex;
      flex-direction: row;
    }

    .password {
      display: flex;
      flex-direction: row;
    }

    .forget-pass {
      text-decoration: none;
      color: #5b548a;
    }

    .form-control {
      margin-left: 10px;
    }

    .forget-pass:hover {
      color: #1e7dea;
    }

    .create {
      text-decoration: none;
      color: #5b548a;
    }

    .create:hover {
      color: #1e7dea;
    }

    .btn-signIn {
      background-color: #06d001 !important;
      border-color: #06d001;
    }

    .loginpanel {
      background-color: whi;
    }
  </style>
  <title>Sign In</title>
    <!--Link Style.css
    <link rel="stylesheet" href="style.css">
    -->
    <!--Boostrap CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src=" 	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" > </script>

    <style>
      h1 {
        font-weight: bold;
        color: #282a35;
      }

      .body {
        margin: 0;
        padding: 0;
        background-color: #282a35;
      }

      .form-control {
        margin-left: 10px;
      }

      .forget-pass:hover {
        color: #1e7dea;
      }

      .create {
        text-decoration: none;
        color: #1ebba3;
      }

      .create:hover {
        color: #1e7dea;
      }

      .btn-signIn {
        background-color: #06d001 !important;
        border-color: #06d001;
      }

      label {
        color: #282a35;
        font-weight: 600;
      }

      .loginpanel {
        background-color: white;
        border-radius: 10px;
        height: 33rem;
        width: 28rem;
      }

      button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 5px;
        border: 1px solid gray;         
        background-color: white;
        font-weight: 600;
        width: 10.7rem;
        padding: 0.2rem 1rem;
        cursor: pointer;
      }
    

      .google-btn {
        margin-right: 1rem;
      }

      button span {
        margin-right: auto;
      }

      button img {
        margin-left: auto;
        max-width: 1.5rem;
      }

      input {
        border: 1px solid gray;         
        background-color: white;
      }

      .bottum-btns {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 5px;
        border: 1px solid gray;
        width: 10.7rem;
        padding: 0.2rem;
        cursor: pointer;
        font-weight: 600;
      
      }
      .forgte-btn{
        text-decoration: none;
      }

      .btn-login {
        background-color: #1ebba3;
        color: white;
        margin-left: 1rem;
        font-weight: 700;
      }
      
      .background-img {
        height: 30rem;
        width: 30rem; 
      }
    </style>
    <title>Sign In</title>

</head>

<body class="body">
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img id="genarateImg" class="img-fluid " src="src/img1.png" alt="Phone image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 loginpanel">
          <form>
            <h1 class="text-center">Sign In</h1>
            <!-- userName input -->
            <div data-mdb-input-init class="form-outline mb-4 userName">
              <img src="src/User.png" alt="user" class="userImg">
              <input type="text" name="userName" class="form-control form-control-lg" placeholder="UserName" />

              <section class="vh-100">
                <div class="container py-5 h-100">
                  <div class="row d-flex align-items-center justify-content-center h-100">
                    <div class="col-md-8 col-lg-7 col-xl-6 mb-5">

                    </div>
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 loginpanel ">
                      <div class="container px-4">
                        <form>
                          <h1 class="mt-4">Sign In</h1>
                          <div class="d-flex justify-content-end my-4 me-md-2">
                            <div class="row"> <label>Don't have an account?<a href="signUp.php" class="create"> Sign Up</a></label> </div>
                          </div>


                          <!--|Log in with google & facebook|-->

                          <div class="d-flex justify-content-center">

                            <!--|Google|-->

                            <button class="google-btn"><span>Google</span> <img src="src/google.png"> </button>

                            <!--|Facebook|-->

                            <button class="facebook-btn"><span>Facebook</span> <img src="src/facebook.png"> </button>

                          </div>
                          <span class="d-flex justify-content-center text-secondary mt-4">OR</span>
                          <div class="d-flex justify-content-center">
                            <div class="w-100">
                              <!-- Email-->
                              <input type="email" name="email" class="form-control form-control-lg my-4 mx-auto" placeholder="email" />
                              <!-- Password input -->
                              <input type="password" name="password" class="form-control form-control-lg mb-3 mx-auto" placeholder="password" />
                            </div>
                          </div>
                          <div class="d-flex justify-content-center mt-4" id="bottem-btns">
                            <!--|forget password|-->
                            <a href="forgotPassword.php" class="forgte-btn"><input type="button" class="bottum-btns  text-secondary" value="Forget Password?"></a>
                            <!-- Submit button -->
                            <input type="submit" class="bottum-btns btn-login" value="Login">
                          </div>
                        </form>
                        >>>>>>> Stashed changes
                      </div>

                      <!-- Password input -->
                      <div data-mdb-input-init class="form-outline mb-4 password">
                        <img src="src/Padlock.png" alt="pw" class="pwImg">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                      </div>

                      <div class="d-flex justify-content-around align-items-center mb-4">
                        <!-- Checkbox -->
                        <div>
                          <input class="form-check-input" type="checkbox" value="" name="rememberMe" checked />
                          <label class="form-check-label" for="form1Example3"> Remember me </label>
                        </div>
                        <div class="forget-create">
                          <div class="col " id="other">
                            <div class="row"><a href="#!" class="forget-pass">Forgot password?</a></div>
                            <div class="row"> <label>No Account?<a href="signUp.php" class="create"> Create</a></label> </div>
                          </div>
                        </div>
                      </div>
                      <!-- Submit button -->
                      <button type="submit" class="btn btn-primary btn-lg btn-block btn-signIn" name="btnSignIn">Sign in</button>
          </form>
        <div class="col-md-8 col-lg-7 col-xl-6 mb-5">
          <img class="img-fluid background-img" src="src/login-img.png" alt="login image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 loginpanel " >
          <div class="container px-4">
            <form>
              <h1 class="mt-4">Sign In</h1>
              <div class="d-flex justify-content-end my-4 me-md-2">
                <div class="row"> <label>Don't have an account?<a href="signUp.php" class="create"> Sign Up</a></label> </div>
              </div>


              <!--|Log in with google & facebook|-->

              <div class="d-flex justify-content-center">

                <!--|Google|-->

                <button class="google-btn"><span>Google</span> <img src="src/google.png"> </button>

                <!--|Facebook|-->

                <button class="facebook-btn"><span>Facebook</span> <img src="src/facebook.png"> </button>

              </div>
              <span class="d-flex justify-content-center text-secondary mt-4">OR</span>
              <div class="d-flex justify-content-center">
                <div class="w-100">
                  <!-- Email-->
                  <input type="email" name="email" class="form-control form-control-lg my-4 mx-auto" placeholder="email"/>
                  <!-- Password input -->
                  <input type="password" name="password" class="form-control form-control-lg mb-3 mx-auto" placeholder="password"/>
                </div>
              </div>
              <div class="d-flex justify-content-center mt-4" id="bottem-btns">
                <!--|forget password|-->
               <a href="forgotPassword.php" class="forgte-btn"><input type="button" class="bottum-btns  text-secondary" value="Forget Password?"></a> 
                <!-- Submit button -->
                <input type="submit" class="bottum-btns btn-login" value="Login">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>

<?php
if (isset($_POST["btnSignIn"])) {

  if (empty($_POST["userName"]) || empty($_POST["password"])) {
    echo "<script>alert('Please Enter Data into Feilds');</script>";
  } else {
    $userName = $_POST["userName"];
    $password = $_POST["password"];

    //! connection start=>
    $conn = mysqli_connect("localhost", "chanuka", "Chanuka@20021004");

    //! connection data bas=>
    mysqli_select_db($conn, "");

    //! perform queary=>
    $query = "Select * From <table> where userName ='$userName' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_fetch_array($result) > 0) { //

      if (isset($_POST["rememberMe"])) { //* set cookies-------------------------------------------------
        //one mounth cookie
        $expire = 30 * 24 * 3600;
        setcookie("UserName", "$userName", time() + $expire, "/", "", 0);
        setcookie("Password", "$password", time() + $expire, "/", "", 0);

        //* start session-------------------------------------------------
        session_start();
        $_SESSION["UserName"] = $userName;
      }
    } else {
      echo "UserName or Password wrong!";
    }
  }
}
?>
</html>

