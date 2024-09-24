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

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Bootstrap Bundle JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- HTML5 QR Code -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Ticket</title>
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

    <main class="container">
        <h1 class="title mb-1">Ticket</h1>
        <ul class="list-unstyled breadcrumbs d-flex flex-wrap gap-2">
            <li><a href="ConductorHome.php">Home</a></li>
            <li class="divider">/</li>
            <li><a href="#" class="active">Ticket</a></li>
        </ul>
        <hr>
    </main>

    <div class="container" id="body">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="searchID" placeholder="Booking ID" aria-label="Booking ID">
            <button class="btn btn-outline-secondary" type="button" id="QrScan" data-bs-toggle="modal" data-bs-target="#qrScannerModal"><i class="bi bi-qr-code-scan"></i></button>
            <button class="btn btn-outline-secondary" type="button" id="Search"><i class="bi bi-search"></i></button>
        </div>

        <div id="ticketDetails" class="mt-5 ms-2 ">
            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Booking ID</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showBookingID">[Booking ID]</span></label>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Passenger Name</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showName">[Passenger Name]</span></label>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Contact No.</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showContact">[Contact Number]</span></label>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Route</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showRoute">[Route]</span></label>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Date</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showDate">[Date]</span></label>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Time</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showTime">[Time]</span></label>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Bus No</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showBusNo">[Bus Number]</span></label>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col">
                    <label class="form-label">Seat No</label>
                </div>
                <div class="col">
                    <label class="form-label">: <span id="showSeatNo">[Seat Number]</span></label>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="active-btn btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#ActiveModel" id="accept">
                    <i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept this Ticket">Accept</i>
                </a>
            </div>


        </div>

        <div id="msg">

        </div>

        <!-- Accept Modal -->
        <div class="modal fade" id="ActiveModel" tabindex="-1" aria-labelledby="ActiveLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ActiveLabel">Accept Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <b>
                                <span>Booking ID : <label id="AcceptID"></label></span><br>
                                <span>Passenger : <label id="AcceptName"></label></span><br>


                            </b>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="confirmActive" data-bookingid="">Accept</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Scanner Modal -->
        <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrScannerLabel">QR Scanner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex justify-content-center align-items-center">
                        <div id="qr-reader" style="width: 100%; height: 300px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let html5QrCode;

        $(document).click(function(e) {
            if (!$(e.target).closest('.navbar, #toggle-btn').length) {
                $('#navbarNav').removeClass('show');
            }
        });

        $(document).ready(function() {
            $('#accept').hide();
            $('[data-bs-toggle="tooltip"]').tooltip();



            // Hide the navbar when a nav link is clicked
            $('.navbar-nav a').on('click', function() {
                $('.navbar-collapse').collapse('hide');
            });

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


        $('.navbar-nav a').on('click', function() {
            $('.navbar-collapse').collapse('hide');
        });

        // Turn off camera when the modal is closed
        $('#qrScannerModal').on('hidden.bs.modal', function() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    console.log("Camera stopped successfully.");
                }).catch(err => {
                    console.error("Failed to stop camera:", err);
                });
            }
        });

        // QR Scan Button
        $('#QrScan').on('click', function() {
            html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start({
                    facingMode: "environment"
                }, // Use back camera
                {
                    fps: 10, // Optional: frame per second for the qr code scanning
                    qrbox: 250 // Optional: specify the size of the QR scanning box
                },
                qrCodeMessage => {
                    // Parse the scanned data which is in JSON format
                    let qrData = JSON.parse(qrCodeMessage);

                    // Extract the data
                    let bookingID = qrData[0];
                    let name = qrData[1];
                    let contact = qrData[2];
                    let route = `${qrData[3]} - ${qrData[4]}`;
                    let date = qrData[5];
                    let time = qrData[6];
                    let busNo = qrData[7];
                    let seatNo = qrData[8];

                    // Display extracted values (you can assign them to your desired elements or variables)

                    searchTicket(bookingID);



                    // $('#showBookingID').text(bookingID);
                    // $('#showName').text(name);
                    // $('#showContact').text(contact);
                    // $('#showRoute').text(route);
                    // $('#showDate').text(date);
                    // $('#showTime').text(time);
                    // $('#showBusNo').text(busNo);
                    // $('#showSeatNo').text(seatNo);

                    // $('#accept').show();

                    // $('#AcceptID').text(bookingID);
                    // $('#AcceptName').text(name);
                    // $('#confirmActive').data('bookingid', bookingID);

                    console.log(`Booking ID: ${bookingID}`);
                    console.log(`Name: ${name}`);
                    console.log(`Contact: ${contact}`);
                    console.log(`Route: ${route}`);
                    console.log(`Date: ${date}`);
                    console.log(`Time: ${time}`);
                    console.log(`Bus No: ${busNo}`);
                    console.log(`Seat No: ${seatNo}`);

                    html5QrCode.stop();
                    $('#qrScannerModal').modal('hide');
                },
                errorMessage => {
                    console.error(`QR Code scanning error: ${errorMessage}`);
                }
            ).catch(err => {
                console.error(`Error in starting QR scanner: ${err}`);
            });
        });

        $('#Search').on('click', function() {
            var searchID = $('#searchID').val();
            // alert(searchID);
            if (searchID.length > 0) {
                searchTicket(searchID);
            }
            $('#searchID').val("");
        });

        $('#confirmActive').on('click', function() {
            var bookingid = $(this).data('bookingid');
            console.log(bookingid);

            if (bookingid.length > 0) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                    data: {
                        action: 'ConformTicket',

                        'BookingID': bookingid,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log("Data received:\n", response);
                        if (response) {
                            $('#msg').text("");
                            $('#msg').append(
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                '<strong>Ticket Accepted ...</strong> ' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>'
                            )
                        } else {
                            $('#msg').text("");
                            $('#msg').append(
                                '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                                '<strong>Feaild To Accept Ticket ...</strong> ' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>'
                            )
                        }


                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching Schedule data: " + status + " - " + error);
                    }
                });
            }
            $('#searchID').val("");


            $('#ActiveModel').modal('hide');
            ResetData();
        });

        function searchTicket(searchID) {
            ResetData();
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'getTicketDetails',

                    'txtSearch': searchID,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('#msg').append(
                            '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                            '<strong>' + response.message + '</strong> ' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>'
                        )

                    } else if (response) {
                        $('#msg').text("");
                        $.each(response, function(key, ticket) {

                            $('#showBookingID').text(ticket['BookingID']);
                            $('#showName').text(ticket['Name']);
                            $('#showContact').text(ticket['Contact']);
                            $('#showRoute').text(ticket['FromCity'] + ' - ' + ticket['ToCity']);
                            $('#showDate').text(ticket['Date']);
                            $('#showTime').text(ticket['Formatted_time']);
                            $('#showBusNo').text(ticket['BusNumber']);
                            $('#showSeatNo').text(ticket['SeatNo']);

                            $('#accept').show();

                            $('#AcceptID').text(ticket['BookingID']);
                            $('#AcceptName').text(ticket['Name']);
                            $('#confirmActive').data('bookingid', ticket['BookingID']);
                        });
                    }


                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Schedule data: " + status + " - " + error);
                }
            });
        }

        function ResetData() {

            $('#showBookingID').text("[Booking ID]");
            $('#showName').text("[Passenger Name]");
            $('#showContact').text("[Contact Number]");
            $('#showRoute').text("[Route]");
            $('#showDate').text("[Date]");
            $('#showTime').text("[Time]");
            $('#showBusNo').text("[Bus Number]");
            $('#showSeatNo').text("[Seat Number]");

            $('#accept').hide();

            $('#AcceptID').text(null);
            $('#AcceptName').text(null);
            $('#confirmActive').data('bookingid', null);

        }
    </script>

</body>

</html>