<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<<<<<<< Updated upstream
    <!--Link Style.css
    <link rel="stylesheet" href="style.css">
    -->
    <!--Boostrap CDN-->
    <link rel="stylesheet" href=" 	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src=" 	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" > </script>

    <style>
      body {
        margin: 0;
        padding: 0;
        background: linear-gradient(100deg, #000915, #003465);
      }
      button {
        border-radius: 30px;
      }
      h1 {
        font-family: "palatino linotype", palatino, serif;
        color: azure;
      }
      label{
        color: azure;
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
        .nameImg {
          width: 30px;
          height: 30px;
          margin-top: 10px;
        }
        .emailImg {
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
        .email {
          display: flex;
          flex-direction: row;
        }
        .name {
          display: flex;
          flex-direction: row;
        }
        .form-control {
          margin-left: 10px;
        }
        .btn-signUp{
          background-color: #06d001 !important;
          border-color: #06d001;
        }
        .create {
          text-decoration: none;
          color:aquamarine;
        }
=======
    <!--Link Style.css-->
    <link rel="stylesheet" href="signinStyle.css">

    <!--Boostrap CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
        /*background-color: rgba(255, 255, 255, 0.2);    transperant background: ;*/
        background-color: white;
        border-radius: 10px;
        height: 37rem;
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
      .clss-94{
        width: 5rem;
      }
      .contact-info{
        display: flex;
        flex-direction: row;
      }

      .btn-signUp {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 5px;
        border: 1px solid gray;
        width: 100%;
        padding: 0.2rem;
        cursor: pointer;
        font-weight: 600;
        background-color: #1ebba3;
        color: white;
        font-weight: 700;
      }

      .background-img {
        height: 30rem;
        width: 30rem; 
      }
>>>>>>> Stashed changes
    </style>
    <title>Sign Up</title>
</head>
<body class="body">
<<<<<<< Updated upstream
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
    <div class="col-md-8 col-lg-7 col-xl-6">
        <img id="genarateImg"
          class="img-fluid " src="src/img1.png" alt="Register img">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form>
          <h1 class="text-center">Sign Up</h1>
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
=======
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6 mb-5">
          <img class="img-fluid background-img" src="src/login-img.png" alt="login image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 loginpanel">
          <div class="container px-4">
            <form>
              <h1 class="mt-4">Sign Up</h1>
              <div class="d-flex justify-content-end my-4 me-md-2">
                <div class="row"> <label>Already have an account?<a href="signIn.php" class="create"> Sign In</a></label> </div>
              </div>

              <!--|Log in with google & facebook|-->
              <div class="d-flex justify-content-center">
                <!--|Google|-->
                <button class="google-btn"><span>Google</span> <img src="src/google.png"> </button>
                <!--|Facebook|-->
                <button class="facebook-btn"><span>Facebook</span> <img src="src/facebook.png"> </button>
              </div>
>>>>>>> Stashed changes

              <span class="d-flex justify-content-center text-secondary mt-4">OR</span>
              <div class="d-flex justify-content-center">
                <div class="w-100">
                  <!-- name input -->
                  <input type="text" name="text" class="form-control form-control-lg my-3 mx-auto" placeholder="Name"/>
                  <!-- Email-->
                  <input type="email" name="email" class="form-control form-control-lg mb-3 mx-auto" placeholder="Email"/>
                  <!-- Password input -->
                  <input type="password" name="password" class="form-control form-control-lg mb-3 mx-auto" placeholder="Password"/>
                  <!-- Contact input -->
                   <div class="contact-info">
                    <input type="text" class="form-control form-control-lg clss-94 mb-3 mx-auto" value="+94" readonly/>
                    <input type="tel" name="contactNo" id="contactNo" class="form-control form-control-lg mb-3 mx-auto" placeholder="Contact-No"/>

                     
                   </div>

                </div>
              </div>

              <div class="d-flex justify-content-center mt-4" id="bottem-btns">
                <!-- Submit button -->
                <input type="submit" class="btn-signUp" value="Sign Up">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
