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
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --grey: #F1F0F6;
            --dark-grey: #8d8d8d;
            --light: #fff;
            --dark: #000;
            --green: #81d43a;
            --light-green: #e3ffcb;
            --blue: #1775F1;
            --light-blue: #d0e4ff;
            --dark-blue: #0c5fcd;
            --red: #fc3b56;
        }

        .search-results {
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
        }

        .search-item {
            padding: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .search-item:hover {
            background-color: #f0f0f0;
        }

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

        html {
            overflow-x: hidden;
        }

        body {
            background: var(--grey);

        }

        a {
            text-decoration: none;
        }

        .errMsg {
            color: red;
            font-size: 13px;
        }

        /* Main */
        main {
            padding: 5px 20px 20px 20px;
            width: 100%;
        }

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

        /* Main */
    </style>
    <title></title>
</head>

<body>
    <main class="">
        <h1 class="title mb-10">BOOKING </h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Booking</a></li>
        </ul>
    </main>

    <div class="row g-3 col-sm-6 p-0  ">

        <div class="col-auto">
            <input type="text" class="form-control form-control-sm" id="txtSearch" placeholder="Search">
        </div>
        <div class="col-auto">
            <select name="activeStatus" id="activeStatus" class="form-select form-select-sm ">

                <option value="All" default>All</option>
                <option value="Booked">Booked</option>
                <option value="Conform">Conform</option>
                <option value="Canceled">Canceled</option>

            </select>
        </div>
    </div>

    <!-- Data View Table -->
    <div class="mt-3">
        <table class="table table-hover table-striped " border="1.5" id="BookingViewTable">
            <thead>
                <tr class="table-success ">
                    <th scope="col">Booking ID</th>
                    <th scope="col">Booked Time</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Route</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Bus No:</th>
                    <th scope="col">Allocator</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody class="BookingData">

                <!-- 
        View Passenger Data
     -->

            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            GetBookingData($('#activeStatus').val().trim());
        })

        $('#activeStatus').change(function() {
            var type = $('#activeStatus').val().trim();
            GetBookingData(type);
        });

        $('#txtSearch').keyup(function() {

            var type = $('#activeStatus').val().trim();
            var txtSearch = $('#txtSearch').val().trim();
            // alert(type + txtSearch)
            Search(type, txtSearch);
        });

        function GetBookingData(type) {
            // alert(type);
            $('.BookingData').empty();
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                dataType: "json",
                data: {
                    action: 'getBookingData',
                    'Type': type,
                },
                success: function(response) {
                    console.log("Data sent:\n", response);
                    if (response.message) {

                        $('.BookingData').append('<tr><td colspan="9" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, booking) {
                            // Start building the table row
                            let row = '<tr >' +
                                '<th scope="row">' + booking['BookingID'] + '</th>' +
                                '<td>' + booking['BookedTime'] + '</td>' +
                                '<td>' + booking['Name'] + '</td>' +
                                '<td>' + booking['Contact'] + '</td>' +
                                '<td>' + booking['FromCity'] + '-' + booking['ToCity'] + '</td>' +
                                '<td>' + booking['Date'] + '</td>' +
                                '<td>' + booking['Formatted_time'] + '</td>' +
                                '<td>' + booking['BusNumber'] + '</td>';

                            if (booking['PassengerID'] !== null) {
                                row += '<td>' + booking['PassengerID'] + '</td>';
                            } else if (booking['CounterID'] !== null) {
                                row += '<td>' + booking['CounterID'] + '</td>';
                            }
                            // row += '<td>' + booking['BookingStatus'] + '</td>';

                            if (booking['BookingStatus'] === "Booked") {
                                row += '<td><span class="badge rounded-pill text-bg-info">Booked</span></td>';
                            } else if (booking['BookingStatus'] === "Conform") {
                                row += '<td><span class="badge rounded-pill text-bg-success text-dark">Conform</span></td>';
                            } else if (booking['BookingStatus'] === "Canceled") {
                                row += '<td><span class="badge rounded-pill text-bg-danger text-dark">Canceled</span></td>';
                            }

                            row += '</tr>';

                            $('.BookingData').append(row);
                        });
                        // Toggle password visibility
                        $('.toggle-password').on('click', function(e) {
                            e.preventDefault();
                            var $this = $(this);
                            var $hiddenPassword = $this.siblings('.hidden-password');
                            var $actualPassword = $this.siblings('.actual-password');

                            if ($hiddenPassword.hasClass('d-none')) {
                                // Show hidden password and change icon
                                $hiddenPassword.removeClass('d-none');
                                $actualPassword.addClass('d-none');
                                $this.find('i').removeClass('bi-eye').addClass('bi-eye-slash');
                            } else {
                                // Show actual password and change icon
                                $hiddenPassword.addClass('d-none');
                                $actualPassword.removeClass('d-none');
                                $this.find('i').removeClass('bi-eye-slash').addClass('bi-eye');
                            }
                        });

                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching passenger data: " + status + " - " + error);
                }
            });
        }

        function Search(type, txtSearch) {
            //alert(type);
            $('.BookingData').empty(); // Clear Admin Data View
            const hiddenPassword = '*'.repeat(10);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                dataType: "json",
                data: {
                    action: 'searchPassenger',
                    'Type': type,
                    'txtSearch': txtSearch,
                },
                success: function(response) {
                    console.log("Data sent:\n", response);
                    if (response.message) {

                        $('.BookingData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, passenger) {
                            // Start building the table row
                            let row = '<tr >' +
                                '<th scope="row">' + passenger['PassengerID'] + '</th>' +
                                '<td>' + passenger['Name'] + '</td>' +
                                '<td>' + passenger['Email'] + '</td>' +
                                '<td>' + passenger['Contact'] + '</td>' +
                                '<td>' +
                                '<span class="hidden-password">' + hiddenPassword + '</span>' +
                                '<span class="actual-password d-none">' + passenger['Password'] + '</span>' +
                                '<a href="#" class="toggle-password ms-2"><i class="bi bi-eye-slash"></i></a>' +
                                '</td>' +
                                '</tr>';

                            // Append the built row to the table
                            $('.BookingData').append(row);
                        });
                        // Toggle password visibility
                        $('.toggle-password').on('click', function(e) {
                            e.preventDefault();
                            var $this = $(this);
                            var $hiddenPassword = $this.siblings('.hidden-password');
                            var $actualPassword = $this.siblings('.actual-password');

                            if ($hiddenPassword.hasClass('d-none')) {
                                // Show hidden password and change icon
                                $hiddenPassword.removeClass('d-none');
                                $actualPassword.addClass('d-none');
                                $this.find('i').removeClass('bi-eye').addClass('bi-eye-slash');
                            } else {
                                // Show actual password and change icon
                                $hiddenPassword.addClass('d-none');
                                $actualPassword.removeClass('d-none');
                                $this.find('i').removeClass('bi-eye-slash').addClass('bi-eye');
                            }
                        });

                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching passenger data: " + status + " - " + error);
                }
            });
        }
    </script>
</body>

</html>