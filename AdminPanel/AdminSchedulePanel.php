<?php
session_start(); // Start the session

// Check if the user is logged in and is a Conductor
if (isset($_SESSION['logedUser']) && $_SESSION['logedUser']['UserType'] === "Admin") {
    $userID = $_SESSION['logedUser']['AdminID'];
    $name = $_SESSION['logedUser']['Name'];
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

        .errMsg {
            color: red;
            font-size: 13px;
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
        <h1 class="title mb-10">SCHEDULE</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="ScheduleView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Schedule</a></li>
        </ul>
    </main>


    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddScheduleModal" id="AddScheduleModalButton">
                <i class="bi bi-plus-lg"></i><span>Add Schedule</span>
            </a>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control form-control-sm" id="txtSearch" placeholder="Search Bus No.">
        </div>
        <div class="col-auto">
            <select name="activeStatus" id="activeStatus" class="form-select form-select-sm ">
                <option value="1" default>Active</option>
                <option value="0">Deactive</option>
            </select>
        </div>
    </div>
    <div class="mt-3">
        <table class="table table-hover table-striped " border="1.5" id="AdminViewTable">
            <thead>
                <tr class="table-success ">
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Route</th>
                    <th scope="col">Bus Number</th>
                    <th scope="col">AdminID</th>
                    <th width="" class=""></th>
                </tr>
            </thead>
            <tbody class="ScheduleData">

                <!-- View Schedule Data -->

            </tbody>
    </div>

    <!-- Toast container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts will be appended here -->
    </div>

    <!-- Add Schedule Form -->
    <div class="modal fade" id="AddScheduleModal" tabindex="-1" aria-labelledby="AddScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddScheduleModalLabel">Add New Schedule</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Schedule</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Schedule ID : </label>
                                    <label class="form-label" id="ShowScheduleID"></label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="col">
                                <label class="form-label">Route:</label>
                                <div class="dropdown">
                                    <input type="text" id="RouteInput" class="form-control" autocomplete="off" placeholder="Type Route  or ID" data-bs-toggle="dropdown">
                                    <ul id="RouteDropdown" class="dropdown-menu w-100">
                                        <!-- Show Route -->
                                    </ul>
                                </div>
                                <span class="errMsg" id="route_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Bus:</label>
                                <div class="dropdown">
                                    <input type="text" id="BusInput" class="form-control" autocomplete="off" placeholder="Type Bus No or ID" data-bs-toggle="dropdown">
                                    <ul id="BusDropdown" class="dropdown-menu w-100">
                                        <!-- Show Bus -->
                                    </ul>
                                </div>
                                <span class="errMsg" id="bus_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Date :</label>
                                <input type="date" class="form-control" name="date" id="date" placeholder="">
                                <span class="errMsg" id="date_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Time :</label>
                                <input type="time" class="form-control" name="time" id="time" value="00:00">
                                <span class="errMsg" id="time_err"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="AddFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddSchedule">Add Schedule</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Edit Schedule Form -->
    <div class="modal fade" id="EditScheduleModal" tabindex="-1" aria-labelledby="EditScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="EditScheduleModalLabel">Update Schedule</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to Update Schedule</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Schedule ID : </label>
                                    <label class="form-label" id="EditFormScheduleID"></label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="col">
                                <label class="form-label">Route:</label>
                                <div class="dropdown">
                                    <input type="text" id="U_RouteInput" class="form-control" autocomplete="off" placeholder="Type Route  or ID" data-bs-toggle="dropdown">
                                    <ul id="U_RouteDropdown" class="dropdown-menu w-100">
                                        <!-- Show Route -->
                                    </ul>
                                </div>
                                <span class="errMsg" id="U_route_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Bus:</label>
                                <div class="dropdown">
                                    <input type="text" id="U_BusInput" class="form-control" autocomplete="off" placeholder="Type Bus No or ID" data-bs-toggle="dropdown">
                                    <ul id="U_BusDropdown" class="dropdown-menu w-100">
                                        <!-- Show Bus -->
                                    </ul>
                                </div>
                                <span class="errMsg" id="U_bus_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Date :</label>
                                <input type="date" class="form-control" name="U_date" id="U_date" placeholder="">
                                <span class="errMsg" id="U_date_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Time :</label>
                                <input type="time" class="form-control" name="U_time" id="U_time" value="00:00">
                                <span class="errMsg" id="U_time_err"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="EditFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="UpdateSchedule">Update Schedule</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="DeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title" id="DeleteLabel">Deactive Schedule</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to deactive this Schedule?</p>
                    <div class="ml-5">
                        <b>

                            <label id="ScheduleID"></label><br>
                            <label id="Routeinfo"></label><br>
                            <label id="BusNo"></label>
                        </b>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Deactive</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Modal -->
    <div class="modal fade" id="ActiveModel" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="ActiveLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header custom-modal-header-active">
                    <h5 class="modal-title" id="ActiveLabel">Active Schedule</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to Active this Schedule ?</p>
                    <div class="ml-5">
                        <b>

                            <label id="ActiveScheduleID"></label><br>
                            <label id="ActiveRouteinfo"></label><br>
                            <label id="ActiveBusNo"></label>
                        </b>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmActive">Active</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#RouteInput').on('keyup', function() {
            // alert("keyup");
            $('#RouteDropdown').empty();
            var route = $('#RouteInput').val().trim();
            // console.log(route);
            if (route.length > 0) {
                GetRouteDetails(route, 'Add');
            }
        });

        $('#RouteDropdown').on('click', '.dropdown-item', function() {
            var RouteID = $(this).data('routeid');
            $('#RouteInput').val(RouteID);
            $('#RouteDropdown').dropdown('hide');
        });

        $('#BusInput').on('keyup', function() {
            // alert("keyup");
            $('#BusDropdown').empty();
            var bus = $('#BusInput').val().trim();
            // console.log(bus);
            if (bus.length > 0) {
                GetBusDetails(bus, 'Add');
            }
        });

        $('#BusDropdown').on('click', '.dropdown-item', function() {
            var BusID = $(this).data('busid');
            $('#BusInput').val(BusID);
            $('#BusDropdown').dropdown('hide');
        });

        $('#U_RouteInput').on('keyup', function() {
            // alert("keyup");
            $('#U_RouteDropdown').empty();
            var U_route = $('#U_RouteInput').val().trim();
            // console.log(route);
            if (U_route.length > 0) {
                GetRouteDetails(U_route, 'Edit');
            }
        });

        $('#U_RouteDropdown').on('click', '.dropdown-item', function() {
            var U_RouteID = $(this).data('routeid');
            $('#U_RouteInput').val(U_RouteID);
            $('#U_RouteDropdown').dropdown('hide');
        });

        $('#U_BusInput').on('keyup', function() {
            // alert("keyup");
            $('#U_BusDropdown').empty();
            var U_Bus = $('#U_BusInput').val().trim();
            // console.log(bus);
            if (U_Bus.length > 0) {
                GetBusDetails(U_Bus, 'Edit');
            }
        });

        $('#U_BusDropdown').on('click', '.dropdown-item', function() {
            var BusID = $(this).data('busid');
            $('#U_BusInput').val(BusID);
            $('#U_BusDropdown').dropdown('hide');
        });

        $(document).ready(function() {
            setDateLimit();
            GetScheduleData($('#activeStatus').val().trim());

        })

        $('#activeStatus').change(function() {
            var type = $('#activeStatus').val().trim();
            GetScheduleData(type);
        });

        $('#txtSearch').keyup(function() {
            var type = $('#activeStatus').val().trim();
            var txtSearch = $('#txtSearch').val().trim();
            //alert(type + txtSearch)
            Search(type, txtSearch);
        });

        $('#AddScheduleModalButton').on('click', function(event) {
            SetScheduleID();
        });

        $('#AddFormCancel').on('click', function(event) {
            event.preventDefault();
            $('.errMsg').text('');
            $('.form-control').val('');
            $('#time').val('00:00');

        });

        $('#EditFormCancel').on('click', function(event) {
            event.preventDefault();
            $('.errMsg').text('');
            $('.form-control').val('');

        });

        $('#AddSchedule').on('click', function(event) {
            //alert("click")
            event.preventDefault();

            var isValid = true;

            var RouteID = $('#RouteInput').val().trim();
            var BusID = $('#BusInput').val().trim();
            var Date = $('#date').val().trim();
            var Time = $('#time').val().trim();

            var IsValid = ScheduleValidation(RouteID, BusID, Date, Time);
            if (IsValid == true) {
                //alert(isValid);
                AddSchedule(RouteID, BusID, Date, Time);
            } else {
                console.log("Check Your Inputs");
            }
        });

        $('#UpdateSchedule').on('click', function(event) {
            //alert("click")
            event.preventDefault();

            var isValid = true;

            var ScheduleID = $('#EditFormScheduleID').text();
            var U_RouteInput = $('#U_RouteInput').val().trim();
            var U_BusInput = $('#U_BusInput').val().trim();
            var U_date = $('#U_date').val().trim();
            var U_time = $('#U_time').val().trim();

            console.log(ScheduleID, U_RouteInput, U_BusInput, U_date, U_time);


            var IsValid = ScheduleValidation(U_RouteInput, U_BusInput, U_date, U_time);
            if (IsValid == true) {
                //alert(isValid);
                UpdateSchedule(ScheduleID, U_RouteInput, U_BusInput, U_date, U_time);
            } else {
                console.log("Check Your Inputs");
            }
        });

        $('#confirmDelete').on('click', function(event) {
            var ScheduleID = $(this).data('scheduleid');
            var status = 0;
            ChangeStatus(ScheduleID, status);
            $('#Delete').modal('hide');

        })

        $('#confirmActive').on('click', function(event) {
            var ScheduleID = $(this).data('scheduleid');
            var status = 1;
            ChangeStatus(ScheduleID, status);
            $('#ActiveModel').modal('hide');

        });


        function setDateLimit() {
            // Get today's date
            const today = new Date();

            const min = new Date();
            min.setDate(today.getDate() + 1)
            const minDate = min.toISOString().split('T')[0];

            const futureDate = new Date();
            futureDate.setDate(today.getDate() + 7);
            const maxDate = futureDate.toISOString().split('T')[0];

            // Set the min and max attributes of the date input
            const dateInput = document.getElementById('date');
            dateInput.setAttribute('min', minDate);
            dateInput.setAttribute('max', maxDate);
        }

        function SetScheduleID() {

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getNextScheduleID'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.newScheduleID);
                    if (response.success) {
                        $('#ShowScheduleID').text(response.newScheduleID);
                    } else {
                        showToast('Error', response.message || "Failed to fetch new Schedule ID", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching new Schedule ID: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        function GetScheduleData(type) {
            $('.ScheduleData').empty();

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'getScheduleData',
                    'Type': type,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.ScheduleData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, schedule) {
                            // console.log(Bus['BusID']);

                            let row = '<tr data-scheduleid="' + schedule['ScheduleID'] + '" data-date="' + schedule['Date'] + '" data-time="' + schedule['Formatted_time'] + '" data-routeid="' + schedule['RouteID'] + '" data-fromcity="' + schedule['FromCity'] + '" data-tocity="' + schedule['ToCity'] + '" data-busid="' + schedule['BusID'] + '" data-busno="' + schedule['BusNumber'] + '">' +
                                '<th scope="row">' + schedule['ScheduleID'] + '</th>' +
                                '<td>' + schedule['Date'] + '</td>' +
                                '<td>' + schedule['Formatted_time'] + '</td>' +
                                '<td>' + schedule['FromCity'] + ' - ' + schedule['ToCity'] + '</td>' +
                                // '<td>' + schedule['BusID'] + ' - ' + schedule['BusNumber'] + '</td>' +
                                '<td>' + schedule['BusNumber'] + '</td>' +
                                '<td>' + schedule['AdminID'] + '</td>';

                            if (schedule['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (schedule['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }

                            row += '</tr>';

                            $('.ScheduleData').append(row);

                        });

                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var ScheduleID = $row.data('scheduleid');
                            var RouteID = $row.data('routeid');
                            var BusID = $row.data('busid');
                            var Date = $row.data('date');
                            var Time = convertTo24Hour($row.data('time'));

                            $('#EditScheduleModal').modal('show');

                            $('#EditFormScheduleID').text(ScheduleID);
                            $('#U_RouteInput').val(RouteID);
                            $('#U_BusInput').val(BusID);
                            $('#U_date').val(Date);
                            $('#U_time').val(Time);

                        });

                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var ScheduleID = $row.data('scheduleid');
                            var FromCity = $row.data('fromcity')
                            var ToCity = $row.data('tocity');
                            var BusNumber = $row.data('busno');

                            // Delete modal content and show the modal
                            $('#ScheduleID').text('\tScheduleID    : ' + ScheduleID);
                            $('#Routeinfo').text('\tRoute  : ' + FromCity + ' - ' + ToCity);
                            $('#BusNo').text('\tBus No  : ' + BusNumber);

                            // console.log('\tRoute  : ' + FromCity +' - ' + ToCity );

                            $('#confirmDelete').data('scheduleid', ScheduleID);
                            $('#Delete').modal('show'); // Use Bootstrap's method to show the modal


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var ScheduleID = $row.data('scheduleid');
                            var FromCity = $row.data('fromcity')
                            var ToCity = $row.data('tocity');
                            var BusNumber = $row.data('busno');

                            $('#ActiveScheduleID').text('\tScheduleID    : ' + ScheduleID);
                            $('#ActiveRouteinfo').text('\tRoute  : ' + FromCity + ' - ' + ToCity);
                            $('#ActiveBusNo').text('\tBus No  : ' + BusNumber);

                            $('#confirmActive').data('scheduleid', ScheduleID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Bus data: " + status + " - " + error);
                }
            });
        }

        function convertTo24Hour(timeStr) {
            let [time, modifier] = timeStr.split(' '); // Split into time and AM/PM part
            let [hours, minutes] = time.split(':'); // Split hours and minutes

            if (modifier === 'PM' && hours !== '12') {
                hours = parseInt(hours, 10) + 12; // Add 12 to convert PM hours to 24-hour
            } else if (modifier === 'AM' && hours === '12') {
                hours = '00'; // 12 AM is 00 in 24-hour format
            }

            return `${hours}:${minutes}`; // Return the time in 24-hour format
        }

        function GetRouteDetails(txtRoute, Form) {
            $('#driverDropdown').empty();
            console.log("Data :\n", txtRoute);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'SearchRoute',
                    'txtSearch': txtRoute,
                    'Type': "1",
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Response:\n", response);
                    let list = '';
                    if (!response.message) {

                        for (let i = 0; i < Math.min(5, response.length); i++) {
                            let route = response[i];

                            list += '<li class="dropdown-item" data-routeid="' + route.RouteID + '">' + route.FromCity + ' - ' + route.ToCity + '  ( ' + route.RouteID + ' ) </li>';
                        }


                    } else {
                        list += '<li class="dropdown-item disabled">' + response.message + '</li>';
                    }

                    if (Form === 'Add') {
                        $('#RouteDropdown').empty().append(list);
                        $('#RouteDropdown').dropdown('show');
                    } else if (Form === 'Edit') {
                        $('#U_RouteDropdown').empty().append(list);
                        $('#U_RouteDropdown').dropdown('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Route data: " + status + " - " + error);
                }
            });
        }

        function GetBusDetails(txtBus, Form) {
            $('#driverDropdown').empty();
            console.log("Data :\n", txtBus);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'SearchBus',
                    'txtSearch': txtBus,
                    'Type': "1",
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Response:\n", response);
                    let list = '';
                    if (!response.message) {

                        for (let i = 0; i < Math.min(5, response.length); i++) {
                            let Bus = response[i];

                            list += '<li class="dropdown-item" data-Busid="' + Bus.BusID + '">' + Bus.BusNumber + '  ( ' + Bus.BusID + ' ) </li>';
                        }


                    } else {
                        list += '<li class="dropdown-item disabled">' + response.message + '</li>';
                    }

                    if (Form === 'Add') {
                        $('#BusDropdown').empty().append(list);
                        $('#BusDropdown').dropdown('show');
                    } else if (Form === 'Edit') {
                        $('#U_BusDropdown').empty().append(list);
                        $('#U_BusDropdown').dropdown('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Bus data: " + status + " - " + error);
                }
            });
        }

        function ScheduleValidation(RouteID, BusID, Date, Time) {
            $('.errMsg').text('');
            var IsValid = true;

            if (RouteID === '') {
                $('#route_err').text('Route is required');
                IsValid = false;
            }
            if (BusID === '') {
                $('#bus_err').text('Bus is required ');
                IsValid = false;
            }

            if (Date === '') {
                $('#date_err').text('Date is required');
                IsValid = false;
            }
            if (Time === '00:00') {
                $('#time_err').text('Time is required');
                IsValid = false;
            }
            // console.log(NoOfSeat,IsValid);
            return IsValid;
        }

        function AddSchedule(RouteID, BusID, Date, Time) {
            console.log(RouteID, BusID, Date, Time);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'addSchedule',
                    'RouteID': RouteID,
                    'BusID': BusID,
                    'Date': Date,
                    'Time': Time,
                    'AdminID': <?php echo $userID; ?>,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        $('#AddScheduleModal').modal('hide');
                        //Clear Form
                        $('.form-control').val('');
                        GetScheduleData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message, 'error');
                        if (response.message === "Schedule is already exists.") {
                            $('#Driver_err').text("Schedule is already exists.");
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding Schedule: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }

            });
        }

        function ChangeStatus(ScheduleID, status) {
            console.log(ScheduleID, status)
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'ChangeStatusSchedule',
                    'ScheduleID': ScheduleID,
                    'Status': status,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("ID sent:\n Response : ", response);
                    if (response.success) {
                        GetScheduleData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        if (status === "0") {
                            showToast('Error', response.message || "Failed to Deactivate Schedule", 'error');
                        } else {
                            showToast('Error', response.message || "Failed to Activate Schedule", 'error');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Change Schedule Status : " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        function Search(type, txtSearch) {
            console.log("Serach:\n", type, txtSearch);
            $('.ScheduleData').empty();

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'SearchSchedule',
                    'Type': type,
                    'txtSearch': txtSearch,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    // $('.ScheduleData').empty();

                    if (response.message) {
                        $('.ScheduleData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, schedule) {
                            // console.log(Bus['BusID']);

                            let row = '<tr data-scheduleid="' + schedule['ScheduleID'] + '" data-date="' + schedule['Date'] + '" data-time="' + schedule['Formatted_time'] + '" data-routeid="' + schedule['RouteID'] + '" data-fromcity="' + schedule['FromCity'] + '" data-tocity="' + schedule['ToCity'] + '" data-busid="' + schedule['BusID'] + '" data-busno="' + schedule['BusNumber'] + '">' +
                                '<th scope="row">' + schedule['ScheduleID'] + '</th>' +
                                '<td>' + schedule['Date'] + '</td>' +
                                '<td>' + schedule['Formatted_time'] + '</td>' +
                                '<td>' + schedule['FromCity'] + ' - ' + schedule['ToCity'] + '</td>' +
                                // '<td>' + schedule['BusID'] + ' - ' + schedule['BusNumber'] + '</td>' +
                                '<td>' + schedule['BusNumber'] + '</td>' +
                                '<td>' + schedule['AdminID'] + '</td>';

                            if (schedule['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (schedule['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }

                            row += '</tr>';

                            $('.ScheduleData').append(row);

                        });

                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var ScheduleID = $row.data('scheduleid');
                            var RouteID = $row.data('routeid');
                            var BusID = $row.data('busid');
                            var Date = $row.data('date');
                            var Time = convertTo24Hour($row.data('time'));

                            $('#EditScheduleModal').modal('show');

                            $('#EditFormScheduleID').text(ScheduleID);
                            $('#U_RouteInput').val(RouteID);
                            $('#U_BusInput').val(BusID);
                            $('#U_date').val(Date);
                            $('#U_time').val(Time);

                        });

                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var ScheduleID = $row.data('scheduleid');
                            var FromCity = $row.data('fromcity')
                            var ToCity = $row.data('tocity');
                            var BusNumber = $row.data('busno');

                            // Delete modal content and show the modal
                            $('#ScheduleID').text('\tScheduleID    : ' + ScheduleID);
                            $('#Routeinfo').text('\tRoute  : ' + FromCity + ' - ' + ToCity);
                            $('#BusNo').text('\tBus No  : ' + BusNumber);

                            // console.log('\tRoute  : ' + FromCity +' - ' + ToCity );

                            $('#confirmDelete').data('scheduleid', ScheduleID);
                            $('#Delete').modal('show'); // Use Bootstrap's method to show the modal


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var ScheduleID = $row.data('scheduleid');
                            var FromCity = $row.data('fromcity')
                            var ToCity = $row.data('tocity');
                            var BusNumber = $row.data('busno');

                            $('#ActiveScheduleID').text('\tScheduleID    : ' + ScheduleID);
                            $('#ActiveRouteinfo').text('\tRoute  : ' + FromCity + ' - ' + ToCity);
                            $('#ActiveBusNo').text('\tBus No  : ' + BusNumber);

                            $('#confirmActive').data('scheduleid', ScheduleID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Schedule data: " + status + " - " + error);
                }
            });
        }

        function UpdateSchedule(ScheduleID, U_RouteInput, U_BusInput, U_date, U_time) {
            console.log(ScheduleID, U_RouteInput, U_BusInput, U_date, U_time);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'updateSchedule',
                    'ScheduleID': ScheduleID,
                    'U_RouteID': U_RouteInput,
                    'U_BusID': U_BusInput,
                    'U_Date': U_date,
                    'U_Time': U_time,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        $('#EditScheduleModal').modal('hide');
                        //Clear Form
                        $('.form-control').val('');
                        GetScheduleData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message, 'error');
                        if (response.message === "Schedule is already exists.") {
                            $('#Driver_err').text("Schedule is already exists.");
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding Schedule: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }

            });
        }

        function showToast(title, message, type) {
            const borderClass = type === 'success' ? 'toast-success' : 'toast-error';
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
                delay: 5000
            }).show();
        }
    </script>

</body>

</html>