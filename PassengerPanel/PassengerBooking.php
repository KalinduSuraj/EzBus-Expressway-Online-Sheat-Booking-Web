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
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Bootstrap Bundle JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title> Booking </title>
    <style>
        main .title {
            font-size: 22px;
            font-weight: 600;
        }

        main .breadcrumbs li,
        main .breadcrumbs li a {
            font-size: 12px;
        }

        main .breadcrumbs li a {
            color: var(--blue);
        }

        main .breadcrumbs li a.active,
        main .breadcrumbs li a.divider {
            color: var(--dark-grey);
            pointer-events: none;
        }

        body {
            padding-top: 60px;
            /* To prevent content from being hidden behind the navbar */
        }
    </style>
</head>

<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">
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
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="PassengerNotificationPanel.php">Notification</a>
                    </li> -->
                </ul>
            </div>
        </nav>

        <div class="container mt-1">
            <h1 class="title mb-10">Booking</h1>
            <ul class="list-unstyled breadcrumbs d-flex gap-2">
                <li><a href="PassengerHome.php">Home</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Schedule</a></li>
            </ul>
            <hr>
        </div>
    </main>


    <div id="msg"><!-- Show Msg --></div>
    <!-- Booking Table -->
    <div class="table-responsive mt-3 container">
        <button type="button" class="btn btn-primary mt-2 mb-2" id="newBooking" >New Booking</button>
        <table class="table table-hover table-striped" id="ConductorBookingViewTable">
            <thead>
                <tr class="table-success">
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Route</th>
                    <th scope="col">Bus No</th>
                    <th scope="col">Seat No</th>
                    <!-- <th scope="col"></th> -->
                </tr>
            </thead>
            <tbody class="BookingData">
                <!-- Rows with data attributes will be dynamically added here -->
            </tbody>
        </table>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="bookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-5">
                            <strong>Booking ID</strong>
                        </div>
                        <div class="col-7">
                            <strong> : </strong><span id="modalBookingID"></span>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-5">
                            <strong>Time</strong>
                        </div>
                        <div class="col-7">
                            <strong> : </strong><span id="modalTime"></span>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-5">
                            <strong>Route</strong>
                        </div>
                        <div class="col-7">
                            <strong> : </strong><span id="modalRoute"></span>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-5">
                            <strong>Bus Number</strong>
                        </div>
                        <div class="col-7">
                            <strong> : </strong><span id="modalBusNo"></span>
                        </div>
                    </div>




                </div>
                <div class="modal-footer" id="modelFoter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="notify">Notify</button>
                    <button type="button" class="btn btn-success" id="complete">Complete</button>
                </div>
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
            var ID = <?php echo json_encode($userID); ?>; // Use json_encode for safety
            GetBookingData(ID);

            $('.BookingData').on('click', 'tr', function() {
                // Retrieve the data attributes from the clicked row
                var scheduleID = $(this).data('bookingid');
                var time = $(this).data('time');
                var route = $(this).data('fromcity') + ' - ' + $(this).data('tocity');
                var busNo = $(this).data('busno');
                if ($(this).data('status') == 1) {
                    $('#modalScheduleID').text(scheduleID);
                    $('#modalTime').text(time);
                    $('#modalRoute').text(route);
                    $('#modalBusNo').text(busNo);

                    // Show the modal
                    $('#scheduleModal').modal('show');
                }

            });


            $('.navbar-nav a').on('click', function() {
                $('.navbar-collapse').collapse('hide');
            });

            $('#newBooking').on('click', function() {
                window.location.href = '../selectroot.php';
            });

            
        });


        $('.navbar-nav a').on('click', function() {
            $('.navbar-collapse').collapse('hide');
        });

        function GetBookingData(ID) {
            $('.BookingData').empty();

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'getPassengerBookingData',
                    'ID': ID,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.BookingData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, booking) {
                            // console.log(Bus['BusID']);

                            let row = '<tr data-bookingid="' + booking['BookingID'] + '" data-date="' + booking['Date'] + '" data-time="' + booking['Formatted_time'] + '" data-routeid="' + booking['RouteID'] + '" data-fromcity="' + booking['FromCity'] + '" data-tocity="' + booking['ToCity'] + '" data-busid="' + booking['BusID'] + '" data-busno="' + booking['BusNumber'] + '" data-status="' + booking['status'] + '">' +
                                '<th scope="row">' + booking['BookingID'] + '</th>' +
                                '<td>' + booking['Date'] + '</td>' +
                                '<td>' + booking['Formatted_time'] + '</td>' +
                                '<td>' + booking['FromCity'] + ' - ' + booking['ToCity'] + '</td>' +
                                '<td>' + booking['BusNumber'] + '</td>' +
                                '<td>' + booking['SeatNo'] + '</td>' +
                                '</tr>';

                            $('.BookingData').append(row);

                        });


                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Bus data: " + status + " - " + error);
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
                            // Uncomment the following line to redirect to login page after successful logout
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