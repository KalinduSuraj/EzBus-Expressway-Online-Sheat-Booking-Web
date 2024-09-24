<?php
session_start(); // Start the session

// Check if the user is logged in and is a Conductor
if (isset($_SESSION['logedUser'])&& $_SESSION['logedUser']['UserType']==="Admin") {
    $userID = $_SESSION['logedUser']['AdminID'];
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
        <h1 class="title mb-10">BUS </h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Bus</a></li>
        </ul>
    </main>

    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddBusModal" id="AddBusModelButton">
                <i class="bi bi-plus-lg"></i><span>Add New Bus</span>
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
                    <th scope="col">Bus No</th>
                    <th scope="col">No Of Seat</th>
                    <th scope="col">Driver</th>
                    <th scope="col">Conductor</th>
                    <th scope="col">AdminID</th>
                    <th width="" class=""></th>
                </tr>
            </thead>
            <tbody class="BusData">

                <!-- View Driver Data -->

            </tbody>
    </div>

    <!-- Toast container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts will be appended here -->
    </div>

    <!-- Add Bus Form -->
    <div class="modal fade" id="AddBusModal" tabindex="-1" aria-labelledby="AddBusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddBusModalLabel">Add New Bus & Driver Details</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Bus</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center">
                                <b>
                                    <label class="form-label">Bus ID : </label>
                                    <label class="form-label" id="ShowBusID"><!-- Show Bus ID --></label>
                                </b>
                            </div>

                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="col">
                            <label class="form-label">Bus Number:</label>
                            <input type="text" class="form-control" name="BusNo" id="BusNo" placeholder="NC-0000">
                            <span class="errMsg" id="BusNo_err"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Of Seat:</label>
                            <!-- <input type="text" class="form-control" name="NoOfSeat" id="NoOfSeat" placeholder="52"> -->
                            <select name="NoOfSeat" id="NoOfSeat" class="form-select form-select-sm ">
                                <option value="0" default>- select -</option>
                                <option value="45">45</option>
                                <option value="49">49</option>
                            </select>
                            <span class="errMsg" id="NoOfSeat_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Driver ID:</label>
                            <!-- <div class="dropdown">
                                <input type="text" id="Driver" class="form-control " data-bs-toggle="dropdown" aria-expanded="false" placeholder="Kalindu Suraj">
                                <ul class="dropdown-menu dropdown-menu-light form-control DriverDetails" aria-labelledby="Driver">
                                    
                                    <li class="dropdown-item">D001 - Kalindu Suraj</li>
                                    <li class="dropdown-item">D001 - Kalindu Suraj</li>
                                    <li class="dropdown-item">D001 - Kalindu Suraj</li> 
                                    
                                </ul>
                            </div> -->

                            <div class="dropdown">
                                <input type="text" id="driverInput" class="form-control" autocomplete="off" placeholder="Type driver name or ID" data-bs-toggle="dropdown">
                                <ul id="driverDropdown" class="dropdown-menu w-100">
                                    <!-- Show Driver -->
                                </ul>
                            </div>
                            <span class="errMsg" id="Driver_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Conductor ID:</label>
                            <div class="dropdown">
                                <input type="text" id="conductorInput" class="form-control" autocomplete="off" placeholder="Type conductor name or ID" data-bs-toggle="dropdown">
                                <ul id="conductorDropdown" class="dropdown-menu w-100">
                                    <!-- Show conductor -->
                                </ul>
                            </div>
                            <span class="errMsg" id="Conductor_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="AddFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddBus">Add Bus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Bus Form -->
    <div class="modal fade" id="EditBusModal" tabindex="-1" aria-labelledby="EditBusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="EditBusModalLabel">Update Bus & Driver Details</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to Update Bus</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center">
                                <b>
                                    <label class="form-label">Bus ID : </label>
                                    <label class="form-label" id="EditFormBusID"><!-- Show BusID --></label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="col">
                            <label class="form-label">Bus Number:</label>
                            <input type="text" class="form-control" name="U_BusNo" id="U_BusNo" placeholder="NC-0000" disabled>
                            <span class="errMsg" id="U_BusNo_err"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Of Seat:</label>
                            <select name="U_NoOfSeat" id="U_NoOfSeat" class="form-select form-select-sm ">
                                <option value="0" default>- select -</option>
                                <option value="45">45</option>
                                <option value="49">49</option>
                            </select>
                            <span class="errMsg" id="U_NoOfSeat_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Driver ID:</label>
                            <div class="dropdown">
                                <input type="text" id="U_driverInput" class="form-control" autocomplete="off" placeholder="Type driver name or ID" data-bs-toggle="dropdown">
                                <ul id="U_driverDropdown" class="dropdown-menu w-100">
                                    <!-- Show Driver -->
                                </ul>
                            </div>
                            <span class="errMsg" id="U_Driver_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Conductor ID:</label>
                            <div class="dropdown">
                                <input type="text" id="U_conductorInput" class="form-control" autocomplete="off" placeholder="Type conductor name or ID" data-bs-toggle="dropdown">
                                <ul id="U_conductorDropdown" class="dropdown-menu w-100">
                                    <!-- Show conductor -->
                                </ul>
                            </div>
                            <span class="errMsg" id="U_Driver_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="EditFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="UpdateBus">Update Bus</button>
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
                    <h5 class="modal-title" id="DeleteLabel">Deactive Bus</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to deactive this Bus?</p>
                    <div class="ml-5">
                        <b>

                            <label id="BusID"></label><br>
                            <label id="BusNumber"></label>
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
                    <h5 class="modal-title" id="ActiveLabel">Active Bus</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to Active this Bus ?</p>
                    <div class="ml-5">
                        <b>

                            <label id="ActiveBusID"></label><br>
                            <label id="ActiveBusNumber"></label>
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
        $('#driverInput').on('keyup', function() {
            // alert("keyup");
            $('#driverDropdown').empty();
            var Driver = $('#driverInput').val().trim();
            // console.log(Driver);
            if (Driver.length > 0) {
                GetDriverDetails(Driver, 'Add');
            }
        });

        $('#conductorInput').on('keyup', function() {
            // alert("keyup");
            $('#conductorDropdown').empty();
            var conductor = $('#conductorInput').val().trim();
            // console.log(conductor);
            if (conductor.length > 0) {
                GetConductorDetails(conductor, 'Add');
            }
        });

        $('#driverDropdown').on('click', '.dropdown-item', function() {
            var driverID = $(this).data('driverid');
            $('#driverInput').val(driverID);
            $('#driverDropdown').dropdown('hide');
        });

        $('#conductorDropdown').on('click', '.dropdown-item', function() {
            var conductorID = $(this).data('conductorid');
            $('#conductorInput').val(conductorID);
            $('#conductorDropdown').dropdown('hide');
        });

        $('#U_driverInput').on('keyup', function() {
            // alert("keyup");
            $('#driverDropdown').empty();
            var Driver = $('#U_driverInput').val().trim();
            // console.log(Driver);
            if (Driver.length > 0) {
                GetDriverDetails(Driver, 'Edit');
            }
        });

        $('#U_conductorInput').on('keyup', function() {
            // alert("keyup");
            $('#U_conductorDropdown').empty();
            var conductor = $('#U_conductorInput').val().trim();
            // console.log(conductor);
            if (conductor.length > 0) {
                GetConductorDetails(conductor, 'Edit');
            }
        });

        $('#U_driverDropdown').on('click', '.dropdown-item', function() {
            var driverID = $(this).data('driverid');
            $('#U_driverInput').val(driverID);
            $('#U_driverDropdown').dropdown('hide');
        });

        $('#U_conductorDropdown').on('click', '.dropdown-item', function() {
            var conductorID = $(this).data('conductorid');
            $('#U_conductorInput').val(conductorID);
            $('#U_conductorDropdown').dropdown('hide');
        });

        $(document).ready(function() {
            var type = $('#activeStatus').val().trim();
            GetBusData(type);
        })

        $('#activeStatus').change(function() {
            var type = $('#activeStatus').val().trim();
            GetBusData(type);
        });

        $('#txtSearch').keyup(function() {
            var type = $('#activeStatus').val().trim();
            var txtSearch = $('#txtSearch').val().trim();
            //alert(type + txtSearch)
            Search(type, txtSearch);
        });

        $('#AddBusModelButton').on('click', function(event) {
            // console.log("Click");
            SetBusID();

        });

        $('#AddFormCancel').on('click', function(event) {
            event.preventDefault();
            $('.errMsg').text('');
            $('.form-control').val('');

        });

        $('#EditFormCancel').on('click', function(event) {
            event.preventDefault();
            $('.errMsg').text('');
            $('.form-control').val('');

        });

        $('#AddBus').on('click', function(event) {
            //alert("click")
            event.preventDefault();

            var isValid = true;

            var BusNo = $('#BusNo').val().trim();
            var NoOfSeat = $('#NoOfSeat').val().trim();
            var DriverID = $('#driverInput').val().trim();
            var ConsuctorID = $('#conductorInput').val().trim();

            var IsValid = AddBusValidation(BusNo, NoOfSeat, DriverID, ConsuctorID);
            if (IsValid == true) {
                //alert(isValid);
                AddBus(BusNo, NoOfSeat, DriverID, ConsuctorID);
            } else {
                console.log("Check Your Inputs");
            }
        });

        $('#UpdateBus').on('click', function(event) {
            //alert("click")
            event.preventDefault();

            var isValid = true;

            var BusID = $('#EditFormBusID').text();
            var U_NoOfSeat = $('#U_NoOfSeat').val().trim();
            var U_DriverID = $('#U_driverInput').val().trim();
            var U_ConsuctorID = $('#U_conductorInput').val().trim();

            var IsValid = UpdateBusValidation( U_NoOfSeat, U_DriverID, U_ConsuctorID);
            if (IsValid == true) {
                //alert(isValid);
                UpdateBus(BusID, U_NoOfSeat, U_DriverID, U_ConsuctorID);
            } else {
                console.log("Check Your Inputs");
            }
        });

        $('#confirmDelete').on('click', function(event) {
            var busID = $(this).data('busid');
            var status = 0;
            ChangeStatus(busID, status);
            $('#Delete').modal('hide');

        })

        $('#confirmActive').on('click', function(event) {
            var busID = $(this).data('busid');
            var status = 1;
            ChangeStatus(busID, status);
            $('#ActiveModel').modal('hide');

        });

        function GetDriverDetails(txtDriver, Form) {
            $('#driverDropdown').empty();
            console.log("Data :\n", txtDriver);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'GetFreeDriver',
                    'txtSearch': txtDriver,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Response:\n", response);
                    let list = '';
                    if (!response.message) {

                        // $.each(response, function(key, driver) {
                        //     console.log("\nDriver:", driver); 
                        //     list += '<li class="dropdown-item" data-driverid="' + driver.DriverID + '">' +
                        //         driver.DriverID + ' - ' + driver.Name + '</li>';
                        // });
                        for (let i = 0; i < Math.min(5, response.length); i++) {
                            let driver = response[i];

                            list += '<li class="dropdown-item';

                            if (driver.AsignStatus === 1) {
                                list += ' disabled';
                            }

                            list += '" data-driverid="' + driver.DriverID + '">' + driver.DriverID + ' - ' + driver.Name;

                            if (driver.AsignStatus === 1) {
                                list += ' (Asigned)';
                            }
                            list += '</li>';
                        }


                    } else {
                        list += '<li class="dropdown-item disabled">' + response.message + '</li>';
                    }

                    if (Form === 'Add') {
                        $('#driverDropdown').empty().append(list);
                        $('#driverDropdown').dropdown('show');
                    } else if (Form === 'Edit') {
                        $('#U_driverDropdown').empty().append(list);
                        $('#U_driverDropdown').dropdown('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching driver data: " + status + " - " + error);
                }
            });
        }

        function GetConductorDetails(txtconductor, Form) {
            $('#conductorDropdown').empty();
            console.log("Data :\n", txtconductor);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to conductor.php
                data: {
                    action: 'GetFreeConductor',
                    'txtSearch': txtconductor,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Response:\n", response);
                    let list = '';
                    if (!response.message) {
                        for (let i = 0; i < Math.min(5, response.length); i++) {
                            let conductor = response[i];

                            list += '<li class="dropdown-item';

                            if (conductor.AsignStatus === 1) {
                                list += ' disabled';
                            }

                            list += '" data-conductorid="' + conductor.ConductorID + '">' + conductor.ConductorID + ' - ' + conductor.Name;

                            if (conductor.AsignStatus === 1) {
                                list += ' (Asigned)';
                            }
                            list += '</li>';
                        }
                    } else {
                        list += '<li class="dropdown-item disabled">' + response.message + '</li>';
                    }

                    if (Form === 'Add') {
                        $('#conductorDropdown').empty().append(list);
                        $('#conductorDropdown').dropdown('show');
                    } else if (Form === 'Edit') {
                        $('#U_conductorDropdown').empty().append(list);
                        $('#U_conductorDropdown').dropdown('show');
                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching conductor data: " + status + " - " + error);
                }
            });
        }

        function AddBusValidation(BusNo, NoOfSeat, DriverID, ConsuctorID) {
            $('.errMsg').text('');
            var IsValid = true;
            //Simple validation
            if (BusNo === '') {
                $('#BusNo_err').text('Bus No is required');
                IsValid = false;
            }
            if (NoOfSeat === '0') {
                $('#NoOfSeat_err').text('Select the No Of Sheets ');
                IsValid = false;
            }
            if (DriverID === '') {
                $('#Driver_err').text('Driver ID is required');
                IsValid = false;
            }
            if (ConsuctorID === '') {
                $('#Conductor_err').text('Conductor ID is required');
                IsValid = false;
            }
            // console.log(NoOfSeat,IsValid);
            return IsValid;
        }

        function UpdateBusValidation( NoOfSeat, DriverID, ConsuctorID){
            $('.errMsg').text('');
            var IsValid = true;

            if (NoOfSeat === '0') {
                $('#U_NoOfSeat_err').text('Select the No Of Sheets ');
                IsValid = false;
            }
            if (DriverID === '') {
                $('#U_Driver_err').text('Driver ID is required');
                IsValid = false;
            }
            if (ConsuctorID === '') {
                $('#U_Conductor_err').text('Conductor ID is required');
                IsValid = false;
            }
            // console.log(NoOfSeat,IsValid);
            return IsValid;
        }

        function AddBus(BusNo, NoOfSeat, DriverID, ConsuctorID) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", 
                data: {
                    action: 'addBus',
                    'BusNumber': BusNo,
                    'NoOfSeat': NoOfSeat,
                    'DriverID': DriverID,
                    'ConductorID': ConsuctorID,
                    'AdminID' :<?php echo $userID; ?>,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        $('#AddBusModal').modal('hide');
                        //Clear Form
                        $('.form-control').val('');
                        GetBusData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message, 'error');
                        if (response.message === "Can't Find This Driver.") {
                            $('#Driver_err').text("Can't Find This Driver.");
                        } 
                        if (response.message === "This Driver already asign.") {
                            $('#Driver_err').text("This Driver already asign.");
                        } 
                        if (response.message === "Can't Find This Conductor.") {
                            $('#Conductor_err').text("Can't Find This Conductor.");
                        }
                        if (response.message === "This Conductor already asign.") {
                            $('#Conductor_err').text("This Conductor already asign.");
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding Bus: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        function UpdateBus(BusNo, U_NoOfSeat, U_DriverID, U_ConductorID) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Driver.php
                data: {
                    action: 'updateBus',
                    'BusID': BusNo,
                    'U_NoOfSeat': U_NoOfSeat,
                    'U_DriverID': U_DriverID,
                    'U_ConductorID': U_ConductorID,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        $('#EditBusModal').modal('hide');
                        //Clear Form
                        $('.form-control').val('');
                        GetBusData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message, 'error');
                        if (response.message === "Can't Find This Driver.") {
                            $('#U_Driver_err').text("Can't Find This Driver.");
                        } 
                        if (response.message === "This Driver already asign.") {
                            $('#U_Driver_err').text("This Driver already asign.");
                        } 
                        if (response.message === "Can't Find This Conductor.") {
                            $('#U_Conductor_err').text("Can't Find This Conductor.");
                        }
                        if (response.message === "This Conductor already asign.") {
                            $('#U_Conductor_err').text("This Conductor already asign.");
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding Bus: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        function ChangeStatus(busID, status) {
            console.log(busID, status)
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'ChangeStatusBus',
                    'BusID': busID,
                    'Status': status,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("ID sent:\n Response : ", response);
                    if (response.success) {
                        GetBusData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        if (status === "0") {
                            showToast('Error', response.message || "Failed to Deactivate Bus", 'error');
                        } else {
                            showToast('Error', response.message || "Failed to Activate Bus", 'error');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Change Bus Status : " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        function GetBusData(type) {
            $('.BusData').empty(); 
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'getBusData',
                    'Type': type,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.BusData').append('<tr><td colspan="7" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, bus) {
                            // console.log(Bus['BusID']);

                            let row = '<tr data-busid="' + bus['BusID'] + '" data-busnumber="' + bus['BusNumber'] + '" data-busnoofseat="' + bus['NoOfSeat'] + '" data-busdriverid="' + bus['DriverID'] + '" data-busconductorid="' + bus['ConductorID'] + '">' +
                                '<th scope="row">' + bus['BusID'] + '</th>' +
                                '<td>' + bus['BusNumber'] + '</td>' +
                                '<td>' + bus['NoOfSeat'] + '</td>' +
                                '<td>' + bus['DriverID'] + ' - ' + bus['DriverName'] + '</td>' +
                                '<td>' + bus['ConductorID'] + ' - ' + bus['ConductorName'] + '</td>' +
                                '<td>' + bus['AdminID'] + '</td>';

                            if (bus['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (bus['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            $('.BusData').append(row);

                        });

                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var BusID = $row.data('busid');
                            var BusNumber = $row.data('busnumber');
                            var NoOfSeat = $row.data('busnoofseat');
                            var DriverID = $row.data('busdriverid');
                            var ConductorID = $row.data('busconductorid');

                            // console.log(BusID ,DName,DNic,DContact);

                            $('#EditBusModal').modal('show');
                            // Update modal content and show the modal
                            $('#EditFormBusID').text(BusID);
                            $('#U_BusNo').val(BusNumber);
                            $('#U_NoOfSeat').val(NoOfSeat);
                            $('#U_driverInput').val(DriverID);
                            $('#U_conductorInput').val(ConductorID);

                        });

                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var BusID = $row.data('busid');
                            var BusNumber = $row.data('busnumber');

                            // Delete modal content and show the modal
                            $('#BusID').text('\tID    : ' + BusID);
                            $('#BusNumber').text('\tName  : ' + BusNumber);

                            $('#confirmDelete').data('busid', BusID);
                            $('#Delete').modal('show'); // Use Bootstrap's method to show the modal


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var BusID = $row.data('busid');
                            var BusNumber = $row.data('busnumber');

                            // Update modal content and show the modal
                            $('#ActiveBusID').text('\tID    : ' + BusID);
                            $('#ActiveBusNumber').text('\tName  : ' + BusNumber);

                            $('#confirmActive').data('busid', BusID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Bus data: " + status + " - " + error);
                }
            });
        }

        function Search(type,txtSearch) {
            $('.BusData').empty(); //Clear Conductor Data View

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Bus.php
                data: {
                    action: 'SearchBus',
                    'Type': type,
                    'txtSearch':txtSearch,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.BusData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, bus) {
                            // console.log(Bus['BusID']);

                            let row = '<tr data-busid="' + bus['BusID'] + '" data-busnumber="' + bus['BusNumber'] + '" data-busnoofseat="' + bus['NoOfSeat'] + '" data-busdriverid="' + bus['DriverID'] + '" data-busconductorid="' + bus['ConductorID'] + '">' +
                                '<th scope="row">' + bus['BusID'] + '</th>' +
                                '<td>' + bus['BusNumber'] + '</td>' +
                                '<td>' + bus['NoOfSeat'] + '</td>' +
                                '<td>' + bus['DriverID'] + ' - ' + bus['DriverName'] + '</td>' +
                                '<td>' + bus['ConductorID'] + ' - ' + bus['ConductorName'] + '</td>' +
                                '<td>' + bus['AdminID'] + '</td>';

                            if (bus['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (bus['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            $('.BusData').append(row);

                        });

                        // Attach click event handler to Edit buttons
                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var BusID = $row.data('busid');
                            var BusNumber = $row.data('busnumber');
                            var NoOfSeat = $row.data('busnoofseat');
                            var DriverID = $row.data('busdriverid');
                            var ConductorID = $row.data('busconductorid');

                            // console.log(BusID ,DName,DNic,DContact);

                            $('#EditBusModal').modal('show');
                            // Update modal content and show the modal
                            $('#EditFormBusID').text(BusID);
                            $('#U_BusNo').val(BusNumber);
                            $('#U_NoOfSeat').val(NoOfSeat);
                            $('#U_driverInput').val(DriverID);
                            $('#U_conductorInput').val(ConductorID);

                        });

                        // Attach click event handler to delete buttons
                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var BusID = $row.data('busid');
                            var BusNumber = $row.data('busnumber');

                            // Delete modal content and show the modal
                            $('#BusID').text('\tID    : ' + BusID);
                            $('#BusNumber').text('\tName  : ' + BusNumber);

                            $('#confirmDelete').data('busid', BusID);
                            $('#Delete').modal('show'); // Use Bootstrap's method to show the modal


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var BusID = $row.data('Busid');
                            var BusNumber = $row.data('busnumber');

                            // Update modal content and show the modal
                            $('#ActiveBusID').text('\tID    : ' + BusID);
                            $('#ActiveBusNumber').text('\tName  : ' + BusNumber);

                            $('#confirmActive').data('Busid', BusID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Bus data: " + status + " - " + error);
                }
            });
        }

        function SetBusID() {

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getNextBusID'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.newBusID);
                    if (response.success) {
                        // Update the Bus ID in the modal
                        $('#ShowBusID').text(response.newBusID);
                    } else {
                        showToast('Error', response.message || "Failed to fetch new Bus ID", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching new Bus ID: " + status + " - " + error);
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