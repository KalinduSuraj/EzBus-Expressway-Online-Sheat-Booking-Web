<?php
session_start(); // Start the session

// Check if the user is logged in and is a Conductor
if (isset($_SESSION['logedUser'])&& $_SESSION['logedUser']['UserType']==="Passenger") {
    $userID = $_SESSION['logedUser']['PassengerID'];
    $name =$_SESSION['logedUser']['Name'];
} else {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Profile</title>
    <style>
        main .title {
            font-size: 22px;
            font-weight: 600;
        }

        body {
            padding-top: 60px;
        }

        .errMsg {
            color: red;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                <span class="navbar-brand">Hi, <span id="conductorName"><?php echo $name; ?></span></span>
                <button class="navbar-toggler" type="button" id="toggle-btn" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="PassengerBooking.php">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="PassengerProfile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logout" data-toggle="modal" data-target="#logoutModal"><i class="bi bi-box-arrow-right"></i> <span class="d-lg-none">Log out</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container mt-1">
            <h1 class="title mb-10">Profile</h1>
            <hr>
        </div>
        <div class="container">
            <div class="card text-center mb-5">
                <div class="card-header">
                    Update Passenger Details
                    <label class="form-label">Passenger ID</label>
                    <h5><label class="form-label">Passenger ID :- </label><label id="passengerID"><?php echo $userID; ?></label></h5>
                </div>
                <div class="card-body">
                <div class="card-body" id="alertContainer"></div>
                    <form id="updatePassengerForm">

                        <div class="mb-2 row">
                            <label for="passengerName" class="col-sm-4 col-form-label">Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="passengerName" required>
                                <span class="errMsg " id="passengerName_err"></span>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="passengerContact" class="col-sm-4 col-form-label">Mobile:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="passengerContact" required>
                                <span class="errMsg " id="passengerContact_err"></span>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="passengerEmail" class="col-sm-4 col-form-label">Email:</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="passengerEmail" required>
                                <span class="errMsg " id="passengerEmail_err"></span>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="passengerPassword" class="col-sm-4 col-form-label">Password:</label>
                            <div class="col-sm-8 position-relative">
                                <input type="password" class="form-control" id="passengerPassword" required>
                                <span class="errMsg" id="passengerPassword_err"></span>
                                <i class="fas fa-eye-slash toggle-password" id="togglePassword" style="position: absolute; right: 22px; top: 12px; cursor: pointer;"></i>
                            </div>
                        </div>



                    </form>
                </div>
                <div class="card-footer text-body-secondary">

                    <button type="button" class="btn btn-primary" id="UpdateBtn">Update</button>
                </div>
            </div>
        </div>






        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to log out?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                        <button type="button" class="btn btn-primary" id="confirmLogoutButton">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).click(function(e) {
            if (!$(e.target).closest('.navbar, #toggle-btn').length) {
                $('#navbarNav').removeClass('show');
            }
        });

        $(document).ready(function() {
            getUserInfo($('#passengerID').text());
            // Hide the navbar when a nav link is clicked
            $('.navbar-nav a').on('click', function() {
                $('.navbar-collapse').collapse('hide');
            });

            // Logout confirmation handling
            $('#confirmLogoutButton').on('click', function() {
                // Redirect to the login page
                window.location.href = '../EzBusLogin.php';
            });

            $('#togglePassword').on('click', function() {
                const passwordInput = $('#passengerPassword');

                // Toggle the type attribute
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    passwordInput.attr('type', 'password');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });

        $('#UpdateBtn').on('click', function() {
            event.preventDefault(); // Prevent form submission

            var passengerID = $('#passengerID').text();
            var name = $('#passengerName').val().trim();
            var contact = $('#passengerContact').val().trim();
            var email = $('#passengerEmail').val().trim();
            var password = $('#passengerPassword').val().trim();

            var isValid = updatePassengerValidation(name, email, contact, password);
            if (isValid === true) {
                EditPassenger(passengerID, name, email, contact, password);
            } else {
                console.log("Check Your Details");
            }
        });

        function updatePassengerValidation(name, email, contact, password) {
            // Clear previous error messages
            $('.errMsg').text('');

            var isValid = true;

            try {
                if (name === '') {
                    $('#passengerName_err').text('Name is required');
                    isValid = false;
                    return isValid;
                }

                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email === '') {
                    $('#passengerEmail_err').text('Email is required');
                    isValid = false;
                    return isValid;
                } else if (!emailRegex.test(email)) {
                    $('#passengerEmail_err').text('Please enter a valid email address.');
                    isValid = false;
                    return isValid;
                }

                if (contact === '') {
                    $('#passengerContact_err').text('Contact is required');
                    isValid = false;
                    return isValid;
                } else if (contact.length !== 10) {
                    $('#passengerContact_err').text('Contact number must be exactly 10 digits');
                    isValid = false;
                    return isValid;
                }

                if (password === '') {
                    $('#passengerPassword_err').text('Password is required');
                    isValid = false;
                    return isValid;
                }

            } catch (err) {
                alert("Something Went Wrong........\n" + err);
            }

            return isValid;
        }

        function EditPassenger(passengerID, name, email, contact, password) {
            
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'updatePassenger',
                    'PassengerID': passengerID,
                    'Name': name,
                    'Email': email,
                    'Contact': contact,
                    'Password': password,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Response received:", response); // Debug log
                    if (response.success) {
                        $('#alertContainer').text("");
                        var alert = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Passenger details updated successfully!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            `;
                        // Append the alert to the alertContainer
                        $('#alertContainer').prepend(alert);
                    } else {
                        if (response.message === "Email already exists.") {
                            $('#passengerEmail_err').text('Email already exists');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error updating passenger: " + status + " - " + error);
                }
            });
        }

        function getUserInfo(userID) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getUserInfo',
                    "ID": userID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Populate the fields with the response data
                        $('#passengerID').text(response.data.PassengerID);
                        $('#passengerName').val(response.data.Name);
                        $('#passengerContact').val(response.data.Contact);
                        $('#passengerEmail').val(response.data.Email);
                        $('#passengerPassword').val(response.data.Password);
                    } else {
                        console.error("Failed to fetch user info: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching user info: " + status + " - " + error);
                }
            });
        }

        $('#confirmLogoutButton').off('click').on('click', function() {
                // Send an AJAX request to perform the logout action
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php', // Your server-side logout handling file
                    data: {
                        action: 'logout'
                    },
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        if (response.success) {
                            $('#logoutModal').modal('hide');
                            console.log( response.message);
                            window.location.href = '../index.php';
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function() {
                        // Handle any errors
                        console.error('Logout failed.');
                    }
                });
            });

    </script>
</body>

</html>