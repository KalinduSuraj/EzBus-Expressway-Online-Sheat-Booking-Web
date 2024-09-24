<?php
session_start(); // Start the session

// Check if the user is logged in and is a Conductor
if (isset($_SESSION['logedUser'])&& $_SESSION['logedUser']['UserType']==="Admin") {
    $userID = $_SESSION['logedUser']['ID'];
    $name =$_SESSION['logedUser']['Name'];
} else {
    header("Location: ../index.html");
    exit();
}
?>

<style>
    h1 {
        font-weight: bold;
        color: #282a35;
    }

    .body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background-image: url('src/bus.png');
        background-size: cover;
        /*cover or contain, or 100% 100% */
        background-position: center;
        background-repeat: no-repeat;
    }

    .errMsg {
        color: red;
        font-size: 13px;
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


    .social-btn {
        margin-inline: 2px;
        width: 50%;
        height: 40px;
        text-align: center;
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

    .forgte-btn .btn-login {
        height: 40px;
    }


    .clss-94 {
        width: 5rem;
    }

    .contact-info {
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
        height: 40px;
        padding: 0.2rem;
        cursor: pointer;
        font-weight: 600;
        background-color: #1ebba3;
        color: white;
        font-weight: 700;
    }
</style>

<!-- Sign In Model -->
<div class="modal fade" id="SignInModal" tabindex="-1" aria-labelledby="SignInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="container pb-5">
                <div class="row d-flex align-items-center justify-content-center h-100">
                    <div class="container px-4">
                        <form>
                            <h1 class="mt-4">Sign In</h1>
                            <div class="d-flex justify-content-end my-4 me-md-2">
                                <div class="row"> <label>Don't have an account?<a href="" class="create" id="SignUpLink"> Sign Up</a></label> </div>
                            </div>
                            <!--|Log in with google & facebook|-->

                            <div class="d-flex justify-content-between">

                                <!--|Google|-->

                                <button class="social-btn"><span>Google</span> <img src="src/google.png"> </button>

                                <!--|Facebook|-->

                                <button class="social-btn"><span>Facebook</span> <img src="src/facebook.png"> </button>

                            </div>
                            <span class="d-flex justify-content-center text-secondary mt-4">OR</span>
                            <div class="d-flex justify-content-center">
                                <div class="w-100">
                                    <!-- Email or Contact No-->
                                    <input type="text" name="username" id="username" class="form-control form-control-md mt-4 mx-auto" placeholder="Email or Contact No" />
                                    <span class="errMsg" id="username_err"></span>
                                    <!-- Password input -->
                                    <input type="password" name="password" id="password" class="form-control form-control-md mt-4  mx-auto" placeholder="Password" />
                                    <span class="errMsg" id="password_err"></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-4 mb-3" id="bottem-btns">
                                <!--|forget password|-->
                                <a href="forgotPassword.php" class="forgte-btn"><input type="button" class="bottum-btns  text-secondary" value="Forget Password?"></a>
                                <!-- Submit button -->
                                <input type="button" class="bottum-btns btn-login" id="Login" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Sign Up Model -->
<div class="modal fade" id="SignUpModal" tabindex="-1" aria-labelledby="SignInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="container pb-5">
                <div class="row d-flex align-items-center justify-content-center h-100">


                    <div class="container px-4">
                        <form>
                            <h1 class="mt-3">Sign In</h1>
                            <div class="d-flex justify-content-end my-2 me-md-2">
                                <div class="row"> <label>Have an account?<a href="" class="create" id="SignInLink"> Sign in</a></label> </div>
                            </div>


                            <!--|Log in with google & facebook|-->

                            <div class="d-flex justify-content-between">

                                <!--|Google|-->

                                <button class="social-btn"><span>Google</span> <img src="src/google.png"> </button>

                                <!--|Facebook|-->

                                <button class="social-btn"><span>Facebook</span> <img src="src/facebook.png"> </button>

                            </div>
                            <span class="d-flex justify-content-center text-secondary mt-2">OR</span>
                            <div class="d-flex justify-content-center">
                                <div class="w-100">
                                    <!-- name input -->
                                    <input type="text" name="name" id="name" class="form-control form-control-md my-2 mx-auto" placeholder="Name" />
                                    <span class="errMsg" id="name_err"></span>

                                    <!-- Email-->
                                    <input type="email" name="email" id="email" class="form-control form-control-md mb-2 mx-auto" placeholder="Email" />
                                    <span class="errMsg" id="email_err"></span>

                                    <!-- Password input -->
                                    <input type="password" name="password" id="password" class="form-control form-control-md mb-2 mx-auto" placeholder="Password" />

                                    <!-- confirm-Password input -->
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-md mb-2 mx-auto" placeholder="Confirm Password" />
                                    <span class="errMsg" id="password_err"></span>

                                    <!-- Contact input -->
                                    <div class="contact-info">
                                        <input type="text" class="form-control form-control-md clss-94 mb-2 mx-auto" value="+94" readonly />
                                        <input type="tel" maxlength="9" name="contactNo" id="contactNo" class="form-control form-control-md mb-2 mx-auto" placeholder="Contact-No" />
                                    </div>
                                    <span class="errMsg" id="contactNo_err"></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3" id="bottem-btns">
                                <!-- Submit button -->
                                <input type="button" class="btn-signUp" value="Sign Up" id="SignUp">
                            </div>
                        </form>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>



<script>
    // switch between Sign In modal and Sign Up modal
    document.getElementById('SignUpLink').addEventListener('click', function(event) {
        event.preventDefault();
        $('#SignInModal').modal('hide');
        $('#SignUpModal').modal('show');
    });

    document.getElementById('SignInLink').addEventListener('click', function(event) {
        event.preventDefault();
        $('#SignUpModal').modal('hide');
        $('#SignInModal').modal('show');
    });



    $(document).ready(function() {
        //SignUp Validation
        $('#SignUp').on('click', function(event) {
            //alert("click");
            event.preventDefault(); // Prevent the form from submitting normally
            // Clear previous error messages
            $('.errMsg').text('');

            var isValid = true;

            var name = $('#name').val().trim();
            var email = $('#email').val().trim();
            var password = $('#password').val().trim();
            var confirm_password = $('#confirm_password').val().trim();
            var contactNo = $('#contactNo').val().trim();

            //Simple validation
            if (name === '') {
                $('#name_err').text('First Name is required');
                isValid = false;
                return;
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === '') {
                $('#email_err').text('Email is required');
                isValid = false;
                return;
            } else if (!emailRegex.test(email)) {
                $('#email_err').text('Please enter a valid email address.');
                isValid = false;
                return;
            }
            if (password === '') {
                $('#password_err').text('Password is required');
                isValid = false;
                return;
            } else if (password !== confirm_password) {
                $('#password_err').text('Passwords do not match');
                isValid = false;
                return;
            }
            if (contactNo === '') {
                $('#contactNo_err').text('ContactNo is required');
                isValid = false;
                return;
            } else if (contactNo.length !== 10) {
                $('#contactNo_err').text('ContactNo number must be exactly 10 digits');
                isValid = false;
                return;
            }

            if (isValid == true) {
                alert(isValid);
            }

        });

        //LogIn Validation
        $('#Login').on('click', function(event) {
            //alert("click");
            event.preventDefault(); // Prevent the form from submitting normally
            // Clear previous error messages
            $('.errMsg').text('');

            var isValid = true;

            var username = $('#username').val().trim();
            var password = $('#password').val().trim();

            //Simple validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var contactNoRegex = /^\d{10}$/;

            if (username === '') {
                $('#username_err').text('Email or Contact No is required');
                isValid = false;
                return;
            } else if (!emailRegex.test(username) && !contactNoRegex.test(username)){
                $('#username_err').text('Please enter a valid email or Contact No address.');
                isValid = false;
                return;
            }
            if (password === '') {
                $('#password_err').text('Password is required');
                isValid = false;
                return;
            }


            if (isValid == true) {
                alert(isValid);
            }

        });

    })
</script>