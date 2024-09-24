<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for eye icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .errMsg {
            color: red;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow">
            <div class="card-body">
                <p class="card-title text-center h2">Admin Login</p>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="userid" class="form-label">User ID</label>
                        <input type="text" class="form-control" id="userid" placeholder="Enter your user ID" required>
                        <span class="errMsg" id="userid_err"></span>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                        <span id="togglePassword" class="position-absolute" style="right: 15px; top: 38px; cursor: pointer;">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </span>
                        <span class="errMsg" id="password_err"></span>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" id="loginBtn">Login</button>
                    </div>
                </form>
                <p class="text-center mt-3">
                    <a href="#" class="text-decoration-none" id="forgotPasswordBtn">Forgot password?</a>
                </p>
                <div id="alertContainer" class="mt-3"></div>
            </div>
        </div>
    </div>

    <div id="loadingspiner">

    </div>

    <!-- Modal -->
    <div class="modal fade" id="changePWModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changePWModelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePWModelLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for changing password -->
                    <form id="changePasswordForm">
                        <div class="mb-3 position-relative">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">
                            <!-- Eye icon -->
                            <span id="toggleNewPassword" class="position-absolute" style="right: 15px; top: 35px; cursor: pointer;">
                                <i class="bi bi-eye-slash" id="eyeIconNewPW"></i>
                            </span>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                            <!-- Eye icon -->
                            <span id="toggleConfirmPassword" class="position-absolute" style="right: 15px; top: 35px; cursor: pointer;">
                                <i class="bi bi-eye-slash" id="eyeIconConformPW"></i>
                            </span>
                        </div>
                    </form>
                    <!-- Error message area -->
                    <div id="passwordError" class="text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="changePasswordBtn">Change Password</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle New Password visibility
        $('#toggleNewPassword').on('click', function() {
            let newPW = $('#newPassword'); // Updated the ID to match the HTML
            let eyeIconNewPW = $('#eyeIconNewPW'); // No change here

            if (newPW.attr('type') === 'password') {
                newPW.attr('type', 'text');
                eyeIconNewPW.removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                newPW.attr('type', 'password');
                eyeIconNewPW.removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });

        $('#toggleConfirmPassword').on('click', function() {
            let confirmPW = $('#confirmPassword'); // Updated the ID to match the HTML
            let eyeIconConformPW = $('#eyeIconConformPW'); // No change here

            if (confirmPW.attr('type') === 'password') {
                confirmPW.attr('type', 'text');
                eyeIconConformPW.removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                confirmPW.attr('type', 'password');
                eyeIconConformPW.removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });








        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const eyeIcon = $('#eyeIcon');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text'); // Change type to text
                eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye'); // Change icon to eye-slash
            } else {
                passwordField.attr('type', 'password'); // Change type back to password
                eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash'); // Change icon back to eye
            }
        });

        $(document).ready(function() {
            $('#userid').val("");
            $('#password').val("");

            $(".form-control").val("")
        });

        $("#forgotPasswordBtn").on('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            $("#alertContainer").text("");
            $("#alertContainer").append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            You Can't Change Password.<p class='mb-1'>Please contact Admin.</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`)
        });


        // Regular expressions for the exact ID formats
        var patternA = /^A\d{3}$/; // For A001
        var patternCOU = /^COU-\d{3}$/; // For COU-001
        var patternC = /^C\d{3}$/; // For C001


        $("#loginBtn").on('click', function(event) {
            event.preventDefault();
            var UserID = $('#userid').val().trim();
            var Password = $('#password').val().trim();

            // console.log(UserID,Password);

            var IsValid = false;
            IsValid = LoginValidation(UserID, Password);
            if (IsValid) {
                var UserType = "";
                if (patternA.test(UserID)) {
                    UserType = "Admin";
                } else if (patternCOU.test(UserID)) {
                    UserType = "Counter";
                } else if (patternC.test(UserID)) {
                    UserType = "Conductor";
                }
                if (UserType !== "") {
                    Login(UserID, Password, UserType);
                    $('#changePasswordBtn').data('id', UserID);
                }
            }

        });

        function LoginValidation(UserID, Password) {
            var isValid = true;

            // Clear previous error messages
            $('.errMsg').text('');

            // UserID validation
            if (UserID === "") {
                isValid = false;
                $('#userid_err').text('User ID is required');
            } else if (!patternA.test(UserID) && !patternCOU.test(UserID) && !patternC.test(UserID)) {
                isValid = false;
                $('#userid_err').text('User ID is incorrect. It should match A001, COU-001, or C001 format');
            }

            // Password validation
            if (Password === "") {
                isValid = false;
                $('#password_err').text('Password is required');
            }

            return isValid;
        }

        function Login(UserID, password, UserType) {
            console.log(UserID, password, UserType);

            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'EzBusLogin',
                    'ID': UserID,
                    'Password': password,
                    'UserType': UserType,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {

                        var UserID = response['user']['UserID'];
                        var UserType = response['user']['UserType'];
                        var PasswordStatus = response['user']['PasswordStatus'];
                        var location = "";

                        if (PasswordStatus == 1) {
                            $('#changePWModel').modal('show');
                            

                        } else {
                            showSpiner();
                            console.log(UserType);
                            switch (UserType) {
                                case "Admin":
                                    location = 'AdminView.php';
                                    console.log("Admin logged in");
                                    // Perform actions specific to Admin
                                    break;
                                case "Counter":
                                    location = 'CounterView.php';
                                    console.log("Counter logged in");
                                    // Perform actions specific to Counter
                                    break;
                                case "Conductor":
                                    location = 'ConductorPanel/ConductorHome.php';
                                    console.log("Conductor logged in");
                                    // Perform actions specific to Conductor
                                    break;
                                default:
                                    location = "signin.php";
                                    console.log("signin.php");
                            }


                            setTimeout(function() {
                                window.location.href = location; // Redirect after 1 second
                                hideSpiner();
                            }, 2000);
                        }

                    } else {
                        $("#alertContainer").text("");
                        $("#alertContainer").append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <p class='mb-1'>'${response.message}'</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`)
                        // showToast('Error', response.message, 'error');

                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Administor Sign In: " + status + " - " + error);
                    // showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });



        }

        $('#changePasswordBtn').on('click', function() {
            let newPassword = $('#newPassword').val().trim();
            let confirmPassword = $('#confirmPassword').val().trim();

            // Clear previous error messages
            $('.errMsg').text('');

            // Validate passwords
            let isValid = true;

            if (newPassword === "") {
                isValid = false;
                $('#newPassword_err').text('New password is required');
            }

            if (confirmPassword === "") {
                isValid = false;
                $('#confirmPassword_err').text('Please confirm your new password');
            } else if (newPassword !== confirmPassword) {
                isValid = false;
                $('#confirmPassword_err').text('Passwords do not match');
            }

            // If validation passes, submit the password change
            if (isValid) {
                var ID = $('#changePasswordBtn').data('id');

                changePassword(ID, newPassword);
            }
        });

        function changePassword(id, newPassword) {
            console.log(id, newPassword);

            var UserType = "";
            if (patternA.test(id)) {
                UserType = "Admin";
            } else if (patternCOU.test(id)) {
                UserType = "Counter";
            } else if (patternC.test(id)) {
                UserType = "Conductor";
            }
            console.log(UserType);

            if (UserType !== "") {
                console.log(UserType);
                $.ajax({
                    type: "POST",
                    url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                    data: {
                        action: 'changeloginPW',
                        'ID': id,
                        'Password': newPassword,
                        'UserType': UserType
                    },
                    success: function(response) {
                        console.log(response);
                        try {
                            response = JSON.parse(response); // Try parsing only if response is JSON
                            console.log("Password change response:", response);
                            if (response.success) {
                                // alert("Password changed");
                                $('#changePWModel').modal('hide');
                                Login(id, newPassword, UserType)

                            } else {
                                alert(response.message);
                            }
                        } catch (error) {
                            console.error("Error parsing response:", error);
                            alert("An error occurred while changing password.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", status, error);
                        alert("An error occurred while changing password.");
                    }
                });
            }
        }



        function showSpiner() {
            $("#loadingspiner").append(`<div id="loading" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.5); z-index: 9999; justify-content: center; align-items: center; display: flex;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`)
        }

        function hideSpiner() {
            $("#loadingspiner").text("");
        }
    </script>
</body>

</html>