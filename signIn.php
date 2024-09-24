<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title id="pagetitle">Sign In</title>
  <!-- Bootstrap Icon CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <!-- Bootstrap Bundle JS (includes Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script src="https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/EasePack.min.js"></script>
  <script src="https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/rAF.js"></script>
  <script src="https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/TweenLite.min.js"></script>
  <link rel="stylesheet" href="https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/css/demo.css.css">


  <style>
    

    .toast-success {
      border-left: 5px solid green;
    }

    .toast-error {
      border-left: 5px solid red;
    }

    .toast-header-success {
      background-color: #d4edda;
      color: #155724;
    }

    .toast-header-error {
      background-color: #f8d7da;
      color: #721c24;
    }

    .has-error .form-control {
      border-color: red;
    }

    .custom-modal-header {
      background-color: #fc3b56;

      color: #f8d7da;

    }

    .custom-modal-header-active {
      background-color: #155724;

      color: #d4edda;

    }

    .errMsg {
      color: red;
      font-size: 13px;
    }

    html {
      /* overflow-y: hidden; */
      /* overflow-y: auto; */
      scrollbar-width: none;

    }

    .custom-btn-width {
      width: 45%;
      /* Set button width to 45% of the modal width */
    }

    .main-body {
      position: absolute;
      margin: 0;
      padding: 0;
      top: 53%;
      left: 50%;
      -webkit-transform: translate3d(-50%, -50%, 0);
      transform: translate3d(-50%, -50%, 0);
    }

    /* #large-header {
      background-image: url("src/bus.png");
    } */

    body {
      background-color: #0c2b3d;
    }

    nav {
      background-color: #0c2b3d;
      height: 64px;
      padding: 0 20px;
      display: flex;
      align-items: center;
      gap: 28px;
      box-shadow: 0 4px 8px rgba(255, 255, 255, 0.2);

    }

    .form-container {
      max-width: 400px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);

    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .toggle-text {
      cursor: pointer;
      color: blue;
    }

    .back-arrow {
      cursor: pointer;
      color: black;
    }

    .back-arrow:hover {
      cursor: pointer;
      color: blue;
    }

    #otp-form {
      width: 100%;
      display: flex;
      gap: 20px;
      align-items: center;
      justify-content: center;
    }

    #otp-form input {
      margin-top: 5px;
      margin-bottom: 10px;
      border: none;
      font-size: 32px;
      text-align: center;
      padding: 10px;
      width: 100%;
      max-width: 70px;
      height: 60px;
      border-radius: 4px;
      outline: 2px solid #b6c4c9;
    }

    #otp-form input:focus-visible {
      outline: 2px solid royalblue;
    }

    #otp-form input.filled {
      outline: 2px solid rgb(7, 192, 99);
    }

    button.resend {
      background-color: transparent;
      border: none;
      font-weight: 600;
      color: #0b2639;
      cursor: pointer;
    }

    button.resend :hover {
      background-color: white;
    }

    button.resend i {
      margin-left: 5px;
    }

    button.resend[disabled] {
      background-color: transparent !important;
      border: none !important;
      font-weight: 600 !important;
      color: #0b2639 !important;
      cursor: not-allowed !important;
    }


    .textcolor {
      color: #0b2639;
      font-weight: 600;

    }

    #timer {
      font-size: 1rem;
      font-weight: bold;
      color: #FF0000;
    }

    .glass {
      background-color: #fdfeff47;
      -webkit-backdrop-filter: blur(4px);
      backdrop-filter: blur(3px);
    }

    .icon {
      width: 20px;
      height: 20px;
    }

    .social-btn {
      margin-inline: 2px;
      height: 35px;
      text-align: center;
      border-color: #0b2639;
    }


    @media only screen and (max-width: 576px) {
      /* .main-body {
        width: 100%;
        top: 0;
        transform: none;
      } */

      .main-body {
        margin-top: 0px;
        position: absolute;
        -webkit-transform: translate3d(-50%, -50%, 0);
        transform: translate3d(-50%, -50%, 0);
      }

      .form-container {
        width: 300px;
        /* Full width for small devices */
        padding: 10px;
      }

      .social-btn {
        flex-direction: column;
      }

      #otp-form input {
        font-size: 16px;
        padding: 10px;
        height: 50px;
        width: 50px;
      }

      button.resend {
        font-size: 12px;
      }

      .form-control {
        font-size: 14px;
        /* Smaller font for inputs on small screens */
      }

      #otp-form input {
        margin-top: 5px;
        margin-bottom: 10px;
        border: none;
        font-size: 32px;
        text-align: center;
        padding: 2px;
        width: 100%;
        max-width: 70px;
        height: 60px;
        border-radius: 4px;
        outline: 2px solid #b6c4c9;
      }

      .toggle-text {
        font-size: 14px;
        /* Smaller toggle text */
      }
    }



    /* Footer */
    .footer {
      background-color: #212529;
      color: #ffffff;
      padding: 20px 0;
    }

    .footer h5 {
      color: #ffffff;
    }

    .footer a {
      color: #ffffff;
      text-decoration: none;
    }

    .footer a:hover {
      color: #f8f9fa;
      text-decoration: underline;
    }

    .footer ul {
      padding: 0;
      list-style-type: none;
    }

    .footer .list-unstyled li {
      margin-bottom: 10px;
    }

    .footer .bi {
      font-size: 1.5rem;
    }

    @media only screen and (max-width: 768px) {
      .footer {
        text-align: center;
      }

      .footer .row>div {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<nav class="navbar navbar-expand-lg ">

</nav>

<body>
  <div id="large-header">
    <canvas id="demo-canvas"></canvas>
    <div class="main-body">
      <div class="container form-container  mt-4 glass" id="authContainer">
        <!-- Sign In Form -->
        <form id="signinForm">
          <h2 class="textcolor">Sign In</h2>

          <div class="d-flex justify-content-between gap-2 mb-2">
            <button class="social-btn form-control p-0" id="signingoogle">Sign In With Google <img class="icon" src="src/google.png"> </button>
          </div>
          <hr>
          <div class="mb-3">
            <input type="text" class="form-control" id="id" placeholder="Email or Contact">
            <span class="errMsg" id="id_err"></span>
          </div>
          <div class="mb-3 position-relative">
            <input type="password" class="form-control" id="Password" placeholder="Password">
            <span id="togglePassword" class="position-absolute" style="right: 15px; top: 10px; cursor: pointer;">
              <i class="bi bi-eye-slash" id="eyeIcon"></i>
            </span>
            <span class="errMsg" id="password_err"></span>
          </div>

          <button type="button" class="btn btn-primary w-100" id="signin">SIGN IN</button>

          <div class="mt-0 text-center">
            <small><span class="toggle-text" id="toggleForgotPassword">FORGOT PASSWORD</span></small>
          </div>

          <div class="mt-3 text-center">
            <span>Don't have an account? <span class="toggle-text" id="viewsignupForm">SIGN UP</span></span>
          </div>
        </form>

        <!-- Sign Up Form -->
        <form id="signupForm" style="display: none;">
          <h2 class="textcolor">Sign Up</h2>
          <div class="d-flex justify-content-between gap-2 mb-2">
            <button class="social-btn form-control p-0" id="signupgoogle">SignUp With Google <img class="icon" src="src/google.png"></button>
          </div>
          <hr>
          <div class="row mb-3">
            <div class="col-12 col-md-6 mb-2">
              <!-- First Name -->
              <input type="text" class="form-control form-control-sm" name="first_name" id="first_name" placeholder="First Name">
              <span class="errMsg" id="first_name_err"></span>
            </div>
            <div class="col-12 col-md-6">
              <!-- Last Name -->
              <input type="text" class="form-control form-control-sm" name="last_name" id="last_name" placeholder="Last Name">
              <span class="errMsg" id="last_name_err"></span>
            </div>
          </div>
          <div class="mb-3">
            <input type="email" name="email" id="email" class="form-control form-control-sm mb-2" placeholder="Email" />
            <span class="errMsg" id="email_err"></span>
          </div>
          <div class="mb-3">
            <input type="text" name="contact" id="contact" class="form-control form-control-sm mb-2" placeholder="Contact" />
            <span class="errMsg" id="contact_err"></span>
          </div>
          <div class="mb-3">
            <!-- Password input -->
            <input type="password" name="password" id="password" class="form-control form-control-sm mb-2" placeholder="Password" />
            <!-- Confirm Password input -->
            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-sm mb-2" placeholder="Confirm Password" />
            <span class="errMsg" id="pw_err"></span>
          </div>
          <button type="button" class="btn btn-success w-100" id="signup">Sign Up</button>
          <div class="mt-3 text-center">
            <span>Already have an account? <span class="toggle-text" id="viewsigninForm">SIGN IN</span></span>
          </div>
        </form>

        <!-- Forget PW & Verify OTP -->
        <form id="forgotForm" style="display: none;">
          <h3 class="ms-auto d-flex gap-5 mb-5"><a id="forgetBack" class="back-arrow"><i class="bi bi-arrow-left-circle"></a></i>Verify User</h3>
          <div class="mb-1">
            <label for="email" class="form-label">Email </label>
            <input type="text" class="form-control" id="userInput" placeholder="example@gmail.com">
            <span class="errMsg" id="userInput_err"></span>
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="resend " id="resendBtn">Send OTP <i class="fa fa-caret-right"></i></button>
            <!-- <button type="button" class="btn btn-primary  mb-3 " id="sendOTP">Send OTP</button> -->
          </div>

          <div id="otp-form" class="mt-3">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
          </div>
          <div id="otpError" style="color: red; display: none;" class="text-center"></div>
          <div class="text-center">
            <span id="timer"></span>
          </div>
          <!-- <button id="verify-btn" class="btn btn-primary w-100">Verify OTP</button> -->

        </form>

        <!-- Change PW -->
        <form id="changePasswordForm" style="display: none;">
          <h3 class="ms-auto d-flex gap-5">
            <a id="newPasswordBack" class="back-arrow"><i class="bi bi-arrow-left-circle"></i></a>
            Change Password
          </h3>

          <!-- New Password Field -->
          <div class="mb-3 position-relative">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPW" placeholder="New Password">
            <span id="toggleNewPassword" class="position-absolute" style="right: 15px; top: 35px; cursor: pointer;">
              <i class="bi bi-eye-slash" id="eyeIconNewPW"></i>
            </span>
          </div>

          <!-- Confirm Password Field -->
          <div class="mb-3 position-relative">
            <label for="conformPW" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="conformPW" placeholder="Confirm Password">
            <span id="toggleConfirmPassword" class="position-absolute" style="right: 15px; top: 35px; cursor: pointer;">
              <i class="bi bi-eye-slash" id="eyeIconConformPW"></i>
            </span>
            <span class="errMsg" id="PW_err"></span>
          </div>

          <button type="button" class="btn btn-success w-100" id="changePW">Change Password</button>
        </form>




      </div>
    </div>
  </div>
  <div id="loadingspiner">

  </div>

  <!-- Toast container -->
  <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <!-- Toasts will be appended here -->
  </div>


  <!-- Footer -->
  <footer class="footer bg-dark text-light">
    <div class="container py-4 ">
      <div class="row">
        <div class="col-12 col-md-4 mb-4">
          <h5 class="text-uppercase">Follow Us</h5>
          <ul class="list-unstyled  ">
            <li class="d-flex align-items-center mb-2">
              <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i><span class="ms-2">Facebook</span></a>
            </li>
            <li class="d-flex align-items-center mb-2">
              <a href="#" class="text-light me-2"><i class="bi bi-twitter"></i><span class="ms-2">Twitter</span></a>
            </li>
            <li class="d-flex align-items-center mb-2">
              <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i><span class="ms-2">Instagram</span></a>
            </li>
            <li class="d-flex align-items-center mb-2">
              <a href="#" class="text-light me-2"><i class="bi bi-linkedin"></i><span class="ms-2">Linkedin</span></a>
            </li>
          </ul>
        </div>

        <div class="col-12 col-md-4 mb-4">
          <h5 class="text-uppercase">Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-light">Home</a></li>
            <li><a href="#" class="text-light">Services</a></li>
            <li><a href="#" class="text-light">Contact Us</a></li>
            <li><a href="#" class="text-light">Privacy Policy</a></li>
          </ul>
        </div>

        <div class="col-12 col-md-4 mb-4">
          <h5 class="text-uppercase">About Us</h5>
          <p>
            We are a dedicated team providing secure and reliable web solutions to enhance your online experience. Feel free to explore our services.
          </p>
          <ul class="list-unstyled  ">
            <li class=" mb-2 mt-3">
              <a href="EzBusLogin.php" class="text-light me-2" id="adminlogin"><i class="bi bi-person-lines-fill"></i><span class="ms-2">Administrator Login</span></a>
            </li>
          </ul>
        </div>
      </div>

      <div class="text-center pt-3 border-top">
        <p class="mb-0">&copy; 2024 Your Company. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- showToast('Success', response.message, 'success'); -->
  <script>
    $(document).ready(function() {
      let OTP = 0; // Declare OTP variable
      let countdown; // Declare countdown variable to manage the timer

      // View Sign Up Form
      $('#viewsignupForm').on('click', function(event) {
        $('.errMsg').text('');
        event.preventDefault();
        $('#signinForm').hide();
        $('#signupForm').show();
        $('.form-control').val("");
      });

      // View Sign In Form
      $('#viewsigninForm').on('click', function(event) {
        $('.errMsg').text('');
        event.preventDefault();
        $('#signupForm').hide();
        $('#signinForm').show();
        $('.form-control').val("");
      });

      // Forgot Password Form
      $('#toggleForgotPassword').on('click', function(event) {
        event.preventDefault();
        $('#signinForm').hide();
        $('#forgotForm').show();
        resetForm();
        $(".otp-input").val('');
        $('#resendBtn').show();
      });

      // Back to Sign In from Forgot Password Form
      $('#forgetBack').on('click', function(event) {
        event.preventDefault();
        $('.errMsg').text('');
        $('#forgotForm').hide();
        $('#signinForm').show();
        $('.form-control').val("");
      });

      // Back Button on New Password Form
      $('#newPasswordBack').on('click', function(event) {
        event.preventDefault();
        $('#forgotForm').show();
        $('#changePasswordForm').hide();
        $('#resendBtn').show();
        resetForm();
      });

      // Resend OTP Button Click Handler
      $('#resendBtn').on('click', function(event) {
        event.preventDefault();
        $('.errMsg').text('');

        var userInput = $('#userInput').val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Email validation

        // Validate input
        if (!emailRegex.test(userInput)) {
          $('#userInput_err').text('Please enter a valid email');
          return;
        } else {
          // Disable the button immediately to prevent duplicate requests
          $('#resendBtn').prop('disabled', true);

          // Call checkEmail with a callback
          checkEmail(userInput, function(Isvalid) {
            if (Isvalid) {
              $('.errMsg').text("");
              OTP = generateOTP();
              sendOTPtoEmail(OTP, userInput);
              console.log("Generated OTP:", OTP);
              // Start the timer for 2 minutes (120 seconds)
              startTimer(120, document.getElementById('timer'), $('#resendBtn'));
              // Clear all OTP input fields and remove the 'filled' class
              $('#otp-form input').val('').removeClass('filled');
              $('#otp-form input').first().focus();
              // $('.form-control').val("");
            } else {
              showToast('Error', 'Email not found or invalid.', 'error');
              $('#resendBtn').prop('disabled', false); // Re-enable the button in case of an error
            }
          });
        }
      });

      // OTP Input Handling
      $('#otp-form input').on('input', function() {
        let $input = $(this);
        toggleFilledClass($input);

        if ($input.next('input').length) {
          $input.next('input').focus();
        }
        verifyOTP(); // Verify OTP on each input
      });

      // Check if all OTP inputs are filled
      function isAllInputFilled() {
        return $('#otp-form input').toArray().every(function(item) {
          return $(item).val();
        });
      }

      // Get the OTP entered by the user
      function getOtpText() {
        let text = "";
        $('#otp-form input').each(function() {
          text += $(this).val();
        });
        return text;
      }

      // Verify OTP Function
      function verifyOTP() {

        if (isAllInputFilled()) {
          showSpiner();
          setTimeout(function() {
            hideSpiner()
          }, 2000);
          const enteredOTP = getOtpText(); // Get OTP entered by user
          console.log(OTP + "-" + enteredOTP);


          if (enteredOTP == OTP && enteredOTP !== 0) { // Compare entered OTP with generated OTP

            console.log("OTP is correct");
            clearInterval(countdown); // Stop the timer
            $('#forgotForm').hide();
            $('#changePasswordForm').show();
            $('#resendBtn').prop('disabled', false); // Enable resend button
            $('#timer').text(''); // Clear the timer display
          } else {
            displayOtpError("Incorrect OTP. Please try again.");
            // Clear all OTP input fields and remove filled class
            $('#otp-form input').val('').removeClass('filled');
            // Set focus to the first OTP input field
            $('#otp-form input').first().focus();
          }
        }
      }

      // Toggle filled class for OTP input fields
      function toggleFilledClass($field) {
        if ($field.val()) {
          $field.addClass('filled');
        } else {
          $field.removeClass('filled');
        }
      }

      // OTP auto-fill on paste and backspace handling
      $('#otp-form input').each(function(index) {
        let $input = $(this);

        toggleFilledClass($input); // Initial fill check

        // Handle paste event
        $input.on('paste', function(e) {
          e.preventDefault();
          let text = e.originalEvent.clipboardData.getData('text');
          $('#otp-form input').each(function(i, item) {
            if (i >= index && text[i - index]) {
              $(item).focus().val(text[i - index]);
              toggleFilledClass($(item));
            }
          });
          verifyOTP(); // Verify OTP after pasting
        });

        // Handle backspace event
        $input.on('keydown', function(e) {
          if (e.keyCode === 8 && !$input.val()) {
            e.preventDefault();
            if ($input.prev('input').length) {
              $input.prev('input').val('').focus(); // Clear previous input and move focus
              toggleFilledClass($input.prev('input'));
            }
          }
        });
      });

      // Timer function for OTP resend
      function startTimer(duration, display, button) {
        let timer = duration,
          minutes, seconds;
        countdown = setInterval(function() {
          minutes = Math.floor(timer / 60);
          seconds = timer % 60;
          minutes = minutes < 10 ? '0' + minutes : minutes;
          seconds = seconds < 10 ? '0' + seconds : seconds;
          display.textContent = `${minutes}:${seconds}`;

          if (--timer < 0) {
            clearInterval(countdown);
            $(button).text("Resend OTP").prop('disabled', false); // Enable resend button
            display.textContent = ""; // Clear timer text
            OTP = generateOTP();
            displayOtpError("OTP expired,Resend new OTP .");
          }
        }, 1000);
      }

      // Reset all input fields and hide forms
      function resetForm() {
        $('#otp-form input').val('').removeClass('filled'); // Clear OTP inputs
        $('#changePasswordForm input').val(''); // Clear password inputs
        $('#resendBtn').show() // Enable resend button
        clearInterval(countdown); // Clear the timer
        $('#timer').text(''); // Clear the timer display
        OTP = 0; // Reset OTP
        $('#otpError').hide(); // Hide error message if any
        console.log("Generated OTP:", OTP);
      }

      // OTP generation function
      function generateOTP() {
        return Math.floor(10000 + Math.random() * 90000); // Generate 5-digit OTP
      }

      // Display error message for OTP
      function displayOtpError(message) {
        $('#otpError').text(message).show();
      }
    });



    $('#signin').on('click', function(event) {
      event.preventDefault();
      var id = $('#id').val();
      var password = $('#Password').val();

      var IsValid = true;
      IsValid = signinValidation(id, password);
      // console.log(IsValid);

      if (IsValid) {
        signin(id, password);
      }


    });

    $('#signup').on('click', function(event) {
      event.preventDefault();
      var first_name = $('#first_name').val();
      var last_name = $('#last_name').val();
      var email = $('#email').val();
      var contact = $('#contact').val();
      var password = $('#password').val();
      var confirm_password = $('#confirm_password').val();

      var IsValid = true;
      IsValid = signupValidation(first_name, last_name, email, contact, password, confirm_password);
      // console.log(IsValid);

      if (IsValid) {
        var name = first_name + " " + last_name;
        signUp(name, email, contact, password);
      }
    });

    $('#togglePassword').on('click', function() {
      const passwordField = $('#Password');
      const eyeIcon = $('#eyeIcon');

      if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text'); // Change type to text
        eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye'); // Change icon to eye-slash
      } else {
        passwordField.attr('type', 'password'); // Change type back to password
        eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash'); // Change icon back to eye
      }
    });

    $('#toggleNewPassword').on('click', function() {
      let newPW = $('#newPW');
      let eyeIconNewPW = $('#eyeIconNewPW');

      if (newPW.attr('type') === 'password') {
        newPW.attr('type', 'text');
        eyeIconNewPW.removeClass('bi-eye-slash').addClass('bi-eye');
      } else {
        newPW.attr('type', 'password');
        eyeIconNewPW.removeClass('bi-eye').addClass('bi-eye-slash');
      }
    });

    $('#toggleConfirmPassword').on('click', function() {
      let confirmPW = $('#confirmPW');
      let eyeIconConformPW = $('#eyeIconConformPW');

      if (confirmPW.attr('type') === 'password') {
        confirmPW.attr('type', 'text');
        eyeIconConformPW.removeClass('bi-eye-slash').addClass('bi-eye');
      } else {
        confirmPW.attr('type', 'password');
        eyeIconConformPW.removeClass('bi-eye').addClass('bi-eye-slash');
      }
    });

    $('#changePW').on('click', function(event) {
      event.preventDefault();
      var NewPW = $('#newPW').val();
      var ConformPW = $('#conformPW').val();
      var UID = $('#changePW').data('userid');
      console.log(UID, ConformPW, NewPW);

      var IsValid = true;
      IsValid = ChangePWValidation(NewPW, ConformPW);

      if (IsValid) {
        ChangePW(UID, NewPW);
      }


    });

    function signinValidation(id, password) {

      $('.errMsg').text('');
      var isValid = true;
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      var contactNoRegex = /^\d{10}$/;
      try {
        if (id === '') {
          $('#id_err').text('Email or Contact No is required');
          isValid = false;
          return;
        } else if (!emailRegex.test(id) && !contactNoRegex.test(id)) {
          $('#id_err').text('Please enter a valid email or Contact No');
          isValid = false;
          return;
        }
        if (password === '') {
          $('#password_err').text('Password is required');
          isValid = false;
          return;
        }


      } catch (err) {
        alert("Somthing Went Wrong........\n (Sign in Validation)\n" + err);
      } finally {
        return isValid;
      }
    }

    function signupValidation(first_name, last_name, email, contact, password, confirm_password) {
      console.log(first_name, last_name, email, contact, password, confirm_password);
      $('.errMsg').text(''); // Clear previous errors
      var isValid = true;
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email regex pattern
      var contactNoRegex = /^\d{10}$/; // Contact number must be exactly 10 digits

      try {
        // Validate First Name
        if (first_name.trim() === '') {
          $('#first_name_err').text('First name is required');
          isValid = false;
          return;
        }

        // Validate Last Name
        if (last_name.trim() === '') {
          $('#last_name_err').text('Last name is required');
          isValid = false;
          return;
        }

        // Validate Email
        if (!emailRegex.test(email)) {
          $('#email_err').text('Please enter a valid email');
          isValid = false;
          return;
        }
        // Validate Contact
        if (!contactNoRegex.test(contact)) {
          $('#contact_err').text('Please enter a valid Contact No');
          isValid = false;
          return;
        }
        // Validate Password
        if (password === '') {
          $('#pw_err').text('Password is required');
          isValid = false;
          return;
        } else if (confirm_password === '') {
          $('#pw_err').text('Confirm Password is required');
          isValid = false;
          return;
        } else if (password !== confirm_password) {
          $('#pw_err').text('Passwords do not match');
          isValid = false;
          return;
        }

      } catch (err) {
        alert("Something Went Wrong\n(Signup Validation)\n" + err);
      }

      return isValid; // Return the final result of validation
    }

    function ChangePWValidation(NewPW, ConformPW) {
      var IsValid = true;

      if (!NewPW || !ConformPW) {
        $('#PW_err').text('Both password fields are required');
        IsValid = false;
        return;
      }

      if (NewPW !== ConformPW) {
        $('#PW_err').text('New Password and Confirm Password do not match');
        IsValid = false;
        return;
      }

      return IsValid;
    }

    function signin(id, password) {
      console.log(id, password);

      $.ajax({
        type: "POST",
        url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
        data: {
          action: 'EzBusLogin',
          'ID': id,
          'Password': password,
          'UserType': "Passenger",
        },
        dataType: 'json',
        success: function(response) {
          console.log("Data sent:\n", response);
          if (response.success) {
            showSpiner();
            // showToast('Success', response.message, 'success');
            setTimeout(function() {
              window.location.href = './index.php'; // Redirect after 1 second
              hideSpiner()
            }, 2000);
          } else {

            showToast('Error', response.message, 'error');

          }
        },
        error: function(xhr, status, error) {
          console.error("Error Passenger Sign In: " + status + " - " + error);
          showToast('Error', "An error occurred: " + status + " - " + error, 'error');
        }
      });
    }

    function signUp(name, email, contact, password) {
      console.log(name, email, contact, password);
      $.ajax({
        type: "POST",
        url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
        data: {
          action: 'addPassenger',
          'Name': name,
          'Email': email,
          'Contact': contact,
          'Password': password,
        },
        dataType: 'json', // Expect JSON response from the server
        success: function(response) {
          console.log("Data sent:\n", response);
          if (response.success) {
            showToast('Success', response.message, 'success');
            signin(email, password);
          } else {
            showToast('Error', response.message, 'error');
          }

        },
        error: function(xhr, status, error) {
          console.error("Error adding passenger: " + status + " - " + error);
          showToast('Error', "An error occurred: " + status + " - " + error, 'error');
        }
      });

    }

    function ChangePW(id, password) {
      $.ajax({
        type: "POST",
        url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
        data: {
          action: 'changePW',
          'ID': id,
          'Password': password,
        },
        dataType: 'json',
        success: function(response) {
          console.log("Data sent:\n", response);

          if (response.success) {
            showToast('Success', response.message, 'success');
            $('.errMsg').text('');
            $('#changePasswordForm').hide();
            $('#signinForm').show();
            $('.form-control').val("");

          } else {
            showToast('Error', response.message, 'error');

          }
        },
        error: function(xhr, status, error) {
          console.error("Error Passenger Sign In: " + status + " - " + error);
          showToast('Error', "An error occurred: " + status + " - " + error, 'error');
        }
      });
    }

    function AddPassenger(name, email, contact, password) {
      $.ajax({
        type: "POST",
        url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
        data: {
          action: 'addPassenger',
          'Name': name,
          'Email': email,
          'Contact': contact,
          'Password': password,
        },
        dataType: 'json', // Expect JSON response from the server
        success: function(response) {
          console.log("Data sent:\n", response);
          if (response.success) {

            $('#first_name').val('');
            $('#last_name').val('');
            $('#email').val('');
            $('#contact').val('');
            $('#password').val('');
            $('#confirm_password').val('');

            showToast('Success', response.message, 'success');
          } else {
            showToast('Error', response.message || "Failed to add Passenger", 'error');
            if (response.message === "Email already exists.") {
              $('#email_err').text('Email already exists');
            }
          }
        },
        error: function(xhr, status, error) {
          console.error("Error adding admin: " + status + " - " + error);
          showToast('Error', "An error occurred: " + status + " - " + error, 'error');
        }
      });
    }

    function checkEmail(userInput, callback) {
      $.ajax({
        type: "POST",
        url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
        data: {
          action: 'getUserDetail',
          'Email': userInput,
        },
        dataType: 'json',
        success: function(response) {
          console.log("Data sent:\n", response);

          if (response.success) {
            var UserID = response['user']['UserID'];
            $('#changePW').data('userid', UserID);
            // Pass true to the callback function if email is valid
            callback(true);
          } else {
            showToast('Error', response.message, 'error');
            // Pass false to the callback function if email is not valid
            callback(false);
          }
        },
        error: function(xhr, status, error) {
          console.error("Error Passenger Sign In: " + status + " - " + error);
          showToast('Error', "An error occurred: " + status + " - " + error, 'error');
          // Pass false to the callback function if an error occurred
          callback(false);
        }
      });
    }


    // function sendOTPtoContact(OTP, userInput) {
    //   if (userInput.startsWith('0')) {
    //     userInput = '94' + userInput.substring(1); // Remove '0' and prepend '94'
    //   }

    //   console.log(OTP + ' - ' + userInput);

    //   $.ajax({
    //     type: "POST",
    //     url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
    //     data: {
    //       action: 'SendSMS',
    //       'MSG': id,
    //       'Contact': userInput,
    //     },
    //     dataType: 'json',
    //     success: function(response) {
    //       console.log("Data sent:\n", response);

    //       if (response.success) {
    //         showToast('Success', "OTP Sent Sucessful", 'success');

    //       } else {
    //         return false;

    //       }
    //     },
    //     error: function(xhr, status, error) {
    //       console.error("Error Passenger Sign In: " + status + " - " + error);
    //       showToast('Error', "An error occurred: " + status + " - " + error, 'error');
    //     }
    //   });
    // }

    function sendOTPtoEmail(OTP, userInput) {

      console.log(OTP + ' - ' + userInput);

      $.ajax({
        type: "POST",
        url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
        data: {
          action: 'sendOTPEmail',
          'OTP': OTP,
          'Email': userInput,
        },
        dataType: 'json',
        success: function(response) {
          console.log("Data sent:\n", response);

          if (response.success) {
            showToast('Success', "OTP Sent Sucessful", 'success');

          } else {
            return false;

          }
        },
        error: function(xhr, status, error) {
          console.error("Error Passenger Sign In: " + status + " - " + error);
          showToast('Error', "An error occurred: " + status + " - " + error, 'error');
        }
      });
    }

    // Function to show Bootstrap toast
    function showToast(title, message, type) {
      const borderClass = type === 'success' ? 'toast-success' : 'toast-error'; //asing the boder color as msg type
      const headerClass = type === 'success' ? 'toast-header-success' : 'toast-header-error';
      const time = new Date().toLocaleTimeString();
      const toastHTML = `
                <div class="toast ${borderClass}" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header ${headerClass}">
                        <img src="..." class="rounded me-2" alt="...">
                        <strong class="me-auto">${title}</strong>
                        <small class="text-muted">${time}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;

      const toastContainer = $('#toastContainer');
      toastContainer.append(toastHTML);
      const newToast = toastContainer.find('.toast').last();
      new bootstrap.Toast(newToast).show();

      // Initialize and show the toast with a 5-second display time
      new bootstrap.Toast(newToast, {
        delay: 10000
      }).show();
    }

    function showSpiner() {
      $("#loadingspiner").append(`<div id="loading" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.1); z-index: 9999; justify-content: center; align-items: center; display: flex;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`)
    }

    function hideSpiner() {
      $("#loadingspiner").text("");
    }

    (function() {
      var width,
        height,
        largeHeader,
        canvas,
        ctx,
        points,
        target,
        animateHeader = true;

      // Main
      initHeader();
      initAnimation();
      addListeners();

      function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {
          x: width,
          y: height
        };

        largeHeader = document.getElementById("large-header");
        largeHeader.style.height = height + "px";

        canvas = document.getElementById("demo-canvas");
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext("2d");

        // create points
        points = [];
        for (var x = 0; x < width; x = x + width / 23) {
          for (var y = 0; y < height; y = y + height / 23) {
            var px = x + (Math.random() * width) / 23;
            var py = y + (Math.random() * height) / 23;
            var p = {
              x: px,
              originX: px,
              y: py,
              originY: py
            };
            points.push(p);
          }
        }

        // for each point find the 5 closest points
        for (var i = 0; i < points.length; i++) {
          var closest = [];
          var p1 = points[i];
          for (var j = 0; j < points.length; j++) {
            var p2 = points[j];
            if (!(p1 == p2)) {
              var placed = false;
              for (var k = 0; k < 5; k++) {
                if (!placed) {
                  if (closest[k] == undefined) {
                    closest[k] = p2;
                    placed = true;
                  }
                }
              }

              for (var k = 0; k < 5; k++) {
                if (!placed) {
                  if (getDistance(p1, p2) < getDistance(p1, closest[k])) {
                    closest[k] = p2;
                    placed = true;
                  }
                }
              }
            }
          }
          p1.closest = closest;
        }

        // assign a circle to each point
        for (var i in points) {
          var c = new Circle(
            points[i],
            2 + Math.random() * 2,
            "rgba(255,255,255,0.9)"
          );
          points[i].circle = c;
        }
      }

      // Event handling
      function addListeners() {
        if (!("ontouchstart" in window)) {
          window.addEventListener("mousemove", mouseMove);
        }
        window.addEventListener("scroll", scrollCheck);
        window.addEventListener("resize", resize);
      }

      function mouseMove(e) {
        var posx = (posy = 0);
        if (e.pageX || e.pageY) {
          posx = e.pageX;
          posy = e.pageY;
        } else if (e.clientX || e.clientY) {
          posx =
            e.clientX +
            document.body.scrollLeft +
            document.documentElement.scrollLeft;
          posy =
            e.clientY +
            document.body.scrollTop +
            document.documentElement.scrollTop;
        }
        target.x = posx;
        target.y = posy;
      }

      function scrollCheck() {
        if (document.body.scrollTop > height) animateHeader = false;
        else animateHeader = true;
      }

      function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        largeHeader.style.height = height + "px";
        canvas.width = width;
        canvas.height = height;
      }

      // animation
      function initAnimation() {
        animate();
        for (var i in points) {
          shiftPoint(points[i]);
        }
      }

      function animate() {
        if (animateHeader) {
          ctx.clearRect(0, 0, width, height);
          for (var i in points) {
            // detect points in range
            if (Math.abs(getDistance(target, points[i])) < 4000) {
              points[i].active = 0.3;
              points[i].circle.active = 0.6;
            } else if (Math.abs(getDistance(target, points[i])) < 20000) {
              points[i].active = 0.1;
              points[i].circle.active = 0.3;
            } else if (Math.abs(getDistance(target, points[i])) < 40000) {
              points[i].active = 0.02;
              points[i].circle.active = 0.1;
            } else {
              points[i].active = 0;
              points[i].circle.active = 0;
            }

            drawLines(points[i]);
            points[i].circle.draw();
          }
        }
        requestAnimationFrame(animate);
      }

      function shiftPoint(p) {
        TweenLite.to(p, 1 + 1 * Math.random(), {
          x: p.originX - 50 + Math.random() * 100,
          y: p.originY - 50 + Math.random() * 100,
          ease: Circ.easeInOut,
          onComplete: function() {
            shiftPoint(p);
          }
        });
      }

      // Canvas manipulation
      function drawLines(p) {
        if (!p.active) return;
        for (var i in p.closest) {
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(p.closest[i].x, p.closest[i].y);
          ctx.strokeStyle = "rgba(156,217,249," + p.active + ")";
          ctx.stroke();
        }
      }

      function Circle(pos, rad, color) {
        var _this = this;

        // constructor
        (function() {
          _this.pos = pos || null;
          _this.radius = rad || null;
          _this.color = color || null;
        })();

        this.draw = function() {
          if (!_this.active) return;
          ctx.beginPath();
          ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
          ctx.fillStyle = "rgba(156,217,249," + _this.active + ")";
          ctx.fill();
        };
      }

      // Util
      function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
      }
    })();
  </script>

</body>


</html>