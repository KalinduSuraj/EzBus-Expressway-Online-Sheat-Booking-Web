<?php
session_start(); // Start the session

// Check if the user is logged in and is a Conductor
if (isset($_SESSION['logedUser'])&& $_SESSION['logedUser']['UserType']==="Conductor") {
    $userID = $_SESSION['logedUser']['ConductorID'];
    $name =$_SESSION['logedUser']['Name'];
} else {
    header("Location: ../index.html");
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
    <title>Conductor Dashboard</title>
    <style>
        main .title {
            font-size: 22px;
            font-weight: 600;
        }

        body {
            padding-top: 60px;
        }
    </style>
</head>

<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                <span class="navbar-brand">Hi, <span ><?php echo $name; ?></span></span>
                <button class="navbar-toggler" type="button" id="toggle-btn" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="ConductorHome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Ticket.php">Ticket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ConductorSchedulePanel.php">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logout" data-toggle="modal" data-target="#logoutModal"><i class="bi bi-box-arrow-right"></i> <span class="d-lg-none">Log out</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container mt-1">
            <h1 class="title mb-10">Home</h1>
            <hr>
        </div>
        <div class="container mt-5">
            <div class="card text-center">
                <div class="card-header">
                    Conductor Details
                </div>
                <div class="card-body">
                    <div id="ticketDetails" class="ms-2">
                        <div class="row mb-1">
                            <div class="col"><label class="form-label">Conductor ID</label></div><span> - </span>
                            <div class="col"><label class="form-label"><span id="showConductorID">[Conductor ID]</span></label></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col"><label class="form-label">Name</label></div><span> - </span>
                            <div class="col"><label class="form-label"><span id="showName">[Name]</span></label></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col"><label class="form-label">Contact No.</label></div><span> - </span>
                            <div class="col"><label class="form-label"><span id="showContact">[Contact Number]</span></label></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col"><label class="form-label">Email</label></div><span> - </span>
                            <div class="col"><label class="form-label"><span id="showEmail">[Email]</span></label></div>
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer text-body-secondary">
                    
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

            setConductorProfile('<?php echo $userID; ?>')
            // Hide the navbar when a nav link is clicked
            $('.navbar-nav a').on('click', function() {
                $('.navbar-collapse').collapse('hide');
            });

            // Logout confirmation handling
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
                            // Uncomment the following line to redirect to login page after successful logout
                            window.location.href = '../EzBusLogin.php';
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
        });


        function setConductorProfile(ID) {
            console.log("Id is: "+ID);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'getConductorDetails',
                    'ID': ID,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);

                    $.each(response, function(key, conductor) {
                        // console.log(Bus['BusID']);

                        $("#showConductorID").text(conductor['ConductorID']);
                        $("#showName").text(conductor['Name']);
                        $("#showContact").text(conductor['Contact']);
                        $("#showEmail").text(conductor['Email']);
                       

                    });



                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Bus data: " + status + " - " + error);
                }
            });
        }

    </script>
</body>

</html>