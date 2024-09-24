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
    <title>Conductor Dashboard</title>
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
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="ConductorNotificationPanel.php">Notification</a>
                    </li> -->
                </ul>
            </div>
        </nav>

        <div class="container mt-1">
            <h1 class="title mb-10">Schedule</h1>
            <ul class="list-unstyled breadcrumbs d-flex gap-2">
                <li><a href="ConductorHome.php">Home</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Schedule</a></li>
            </ul>
            <hr>
        </div>
    </main>


    <div id="msg"><!-- Show Msg --></div>

    <!-- Schedule Table -->
    <div class="table-responsive mt-3 container">
        <table class="table table-hover table-striped" id="ConductorScheduleViewTable">
            <thead>
                <tr class="table-success">
                    <th scope="col">Time</th>
                    <th scope="col">Route</th>
                    <th scope="col">Bus No</th>
                    <!-- <th scope="col"></th> -->
                </tr>
            </thead>
            <tbody class="ScheduleData">
                <!-- Rows with data attributes will be dynamically added here -->
            </tbody>
        </table>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="scheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row mb-1">
                        <div class="col-5">
                            <strong>Schedule ID</strong>
                        </div>
                        <div class="col-7">
                            <strong> : </strong><span id="modalScheduleID"></span>
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
            var ConductorID ='<?php echo $userID; ?>';
            GetScheduleData(ConductorID);

            $('.ScheduleData').on('click', 'tr', function() {
                // Retrieve the data attributes from the clicked row
                var scheduleID = $(this).data('scheduleid');
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


            // Hide the navbar when a nav link is clicked
            $('.navbar-nav a').on('click', function() {
                $('.navbar-collapse').collapse('hide');
            });

            
        });


        $('.navbar-nav a').on('click', function() {
            $('.navbar-collapse').collapse('hide');
        });

        $('#notify').on('click', function() {

            var msg = " Notify Successful";

            $('#scheduleModal').modal('hide');

            $('#msg').text("");
            $('#msg').append(
                '<div class="alert alert-primary alert-dismissible fade show p-1" role="alert">' +
                '<strong>' + msg + '</strong> ' +
                '<button type="button" class="btn-close pt-1" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>'
            )
        });

        $('#complete').on('click', function() {

            var scheduleID = $('#modalScheduleID').text();
            var type = "0";
            //alert("Delete " + AdminID);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'ChangeStatusSchedule',
                    'ScheduleID': scheduleID,
                    'Type': type,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("ID sent:\n Response : ", response);

                    if (response.success) {

                        $('#scheduleModal').modal('hide');
                        $('#msg').text("");
                        $('#msg').append(
                            '<div class="alert alert-success alert-dismissible fade show p-1" role="alert">' +
                            '<strong> Completed </strong> ' +
                            '<button type="button" class="btn-close pt-1" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>'
                        )

                        var ConductorID = "C001"
                        GetScheduleData(ConductorID);
                    } else {
                        $('#scheduleModal').modal('hide');
                        $('#msg').text("");
                        $('#msg').append(
                            '<div class="alert alert-danger alert-dismissible fade show p-1" role="alert">' +
                            '<strong> Complete Feailed </strong> ' +
                            '<button type="button" class="btn-close pt-1" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>'
                        )

                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Complet Schedule: " + status + " - " + error);

                }
            });



        });

        function GetScheduleData(ID) {
            $('.ScheduleData').empty();

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'getConductorScheduleData',
                    'ID': ID,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.ScheduleData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, schedule) {
                            // console.log(Bus['BusID']);

                            let row = '<tr data-scheduleid="' + schedule['ScheduleID'] + '" data-date="' + schedule['Date'] + '" data-time="' + schedule['Formatted_time'] + '" data-routeid="' + schedule['RouteID'] + '" data-fromcity="' + schedule['FromCity'] + '" data-tocity="' + schedule['ToCity'] + '" data-busid="' + schedule['BusID'] + '" data-busno="' + schedule['BusNumber'] + '" data-status="' + schedule['status'] + '">' +
                                '<th scope="row">' + schedule['Formatted_time'] + '</th>' +
                                '<td>' + schedule['FromCity'] + ' - ' + schedule['ToCity'] + '</td>' +
                                '<td>' + schedule['BusNumber'] + '</td>' +
                                // '<td class="ms-auto d-flex gap-2">' +
                                // '<a href="#"  ><i class="bx bx-detail bx-flip-vertical btn btn-sm btn-outline-success " data-bs-toggle="tooltip" data-bs-placement="top" title="View" ></i>' +
                                // '</td>' +
                                '</tr>';

                            $('.ScheduleData').append(row);

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
    </script>
</body>

</html>