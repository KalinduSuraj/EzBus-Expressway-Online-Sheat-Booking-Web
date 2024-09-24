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
        <h1 class="title mb-10">DRIVER</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Users / Driver</a></li>
        </ul>
    </main>

    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddDriverModal" id="AddDriverModelButton">
                <i class="bi bi-plus-lg"></i><span>Add New Driver</span>
            </a>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control form-control-sm" id="txtSearch" placeholder="Search">
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
                    <th scope="col">Name</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Contact</th>
                    <th scope="col">AdminID</th>
                    <th width="" class=""></th>
                </tr>
            </thead>
            <tbody class="DriverData">

                <!-- View Driver Data -->

            </tbody>
    </div>

    <!-- Toast container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts will be appended here -->
    </div>

    <!-- Add Driver Form -->
    <div class="modal fade" id="AddDriverModal" tabindex="-1" aria-labelledby="AddDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddDriverModalLabel">Add New Driver</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Driver</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Driver ID : </label>
                                    <label class="form-label" id="ShowDriverID"><!-- Show Next DriverID --></label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <label class="form-label">Driver Name:</label>
                            <input type="text" class="form-control" name="driverName" id="driverName" placeholder="Kalindu">
                            <span class="errMsg" id="driverName_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Driver NIC:</label>
                            <input type="text" class="form-control" name="Nic" id="Nic" placeholder="XXXXXXXXXX">
                            <span class="errMsg" id="Nic_err"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Driver Contact No :</label>
                            <input type="text" class="form-control" name="contact" id="contact" placeholder="07X XXXX XXX">
                            <span class="errMsg" id="contact_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="AddFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddDriver">Add Driver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Edit Driver Form -->
     <div class="modal fade" id="EditDriverModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="EditDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="EditDriverModalLabel">Update New Driver</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to Update a Driver</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Driver ID : </label>
                                    <label class="form-label" id="EditFormDriverID"><!-- Show Next DriverID --></label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <label class="form-label">Driver Name:</label>
                            <input type="text" class="form-control" name="U_Name" id="U_Name" placeholder="Kalindu">
                            <span class="errMsg" id="U_Name_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Driver NIC:</label>
                            <input type="text" class="form-control" name="U_Nic" id="U_Nic" placeholder="XXXXXXXXXX">
                            <span class="errMsg" id="U_Nic_err"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Driver Contact No :</label>
                            <input type="text" class="form-control" name="U_contact" id="U_contact" placeholder="07X XXXX XXX">
                            <span class="errMsg" id="U_contact_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="EditFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="UpdateDriver">Update Driver</button>
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
                    <h5 class="modal-title" id="DeleteLabel">Deactive Driver</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to deactive this Driver?</p>
                    <div class="ml-5">
                        <b>

                            <label id="DriverID"></label><br>
                            <label id="DriverName"></label>
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
                    <h5 class="modal-title" id="ActiveLabel">Active Driver</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to Active this Driver ?</p>
                    <div class="ml-5">
                        <b>

                            <label id="ActiveDriverID"></label><br>
                            <label id="ActiveDriverName"></label>
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
        $(document).ready(function() {
            var type = $('#activeStatus').val().trim();
            GetDriverData(type);

        })

        $('#activeStatus').change(function() {
            var type = $('#activeStatus').val().trim();
            GetDriverData(type);
        });

        $('#txtSearch').keyup(function() {
            var type = $('#activeStatus').val().trim();
            var txtSearch = $('#txtSearch').val().trim();
            //alert(type + txtSearch)
            Search(type, txtSearch);
        });

        $('#AddDriverModelButton').on('click', function(event) {
            SetDriverID();
        });

        $('#AddFormCancel' ).on('click', function(event) {
            event.preventDefault(); 
            $('.errMsg').text('');
            $('.form-control').val('');

        });

        $('#EditFormCancel').on('click', function(event) {
            event.preventDefault(); 
            $('.errMsg').text('');
            $('.form-control').val('');

        });

        $('#AddDriver').on('click', function(event) {
            // alert("click");
            event.preventDefault(); // Prevent the form from submitting normally

            var driverName = $('#driverName').val().trim();
            var nic = $('#Nic').val().trim();
            var contact = $('#contact').val().trim();

            var isValid = AddDriverValidation(driverName, nic, contact)
            if (isValid == true) {
                //alert(isValid);
                AddDriver(driverName, nic, contact);
            } else {
                console.log("Check Your Inputs");
            }

        });
        // click in Update Driver button 
        $('#UpdateDriver').on('click', function() {
            // alert("click");
            event.preventDefault();
            var driverID = $('#EditFormDriverID').text();
            var U_name = $('#U_Name').val().trim();
            var U_Nic = $('#U_Nic').val().trim();
            var U_contact = $('#U_contact').val().trim();

            var isValid = UpdateDriverValidation(U_name, U_Nic, U_contact);
            if (isValid == true) {
                EditDriver(driverID, U_name, U_Nic, U_contact);
            } else {
                console.log("Check Your Details");
            }
        });

        $('#confirmDelete').on('click', function(event) {
            var driverID = $(this).data('driverid');
            var status = 0;
            ChangeStatus(driverID, status);
            $('#Delete').modal('hide');
        })

        // click in confirm Active button
        $('#confirmActive').on('click', function() {
            var driverID = $(this).data('driverid');
            var status = 1;
            ChangeStatus(driverID, status);
            $('#ActiveModel').modal('hide');
        });

        //Add Driver Validation Function
        function AddDriverValidation(driverName, nic, contact) {
            // Clear previous error messages
            $('.errMsg').text('');

            var isValid = true;
            try {
                //Simple validation
                if (driverName === '') {
                    $('#driverName_err').text('Name is required');
                    isValid = false;

                }

                let nicPattern = /^(\d{9}[vV]|\d{12})$/; // 9 digits + 'V' or 'v', or exactly 12 digits
                if (nic === '') {
                    $('#Nic_err').text('NIC is required');
                    isValid = false;

                } else if (!nicPattern.test(nic)) {
                    $('#Nic_err').text('NIC must be 12 digits or 9 digits followed by V');
                    isValid = false;
                }
                if (contact === '') {
                    $('#contact_err').text('Contact is required');
                    isValid = false;

                } else if (contact.length !== 10) {
                    $('#contact_err').text('Contact number must be exactly 10 digits');
                    isValid = false;

                }
            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }

        }

        //Add Driver Validation Function
        function UpdateDriverValidation(driverName, nic, contact) {
            // Clear previous error messages
            $('.errMsg').text('');

            var isValid = true;
            try {
                //Simple validation
                if (driverName === '') {
                    $('#U_Name_err').text('Name is required');
                    isValid = false;

                }

                let nicPattern = /^(\d{9}[vV]|\d{12})$/; // 9 digits + 'V' or 'v', or exactly 12 digits
                if (nic === '') {
                    $('#U_Nic_err').text('NIC is required');
                    isValid = false;

                } else if (!nicPattern.test(nic)) {
                    $('#U_Nic_err').text('NIC must be 12 digits or 9 digits followed by V');
                    isValid = false;
                }
                if (contact === '') {
                    $('#U_contact_err').text('Contact is required');
                    isValid = false;

                } else if (contact.length !== 10) {
                    $('#U_contact_err').text('Contact number must be exactly 10 digits');
                    isValid = false;

                }
            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }

        }

        //Add Driver Data
        function AddDriver(driverName, nic, contact) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Driver.php
                data: {
                    action: 'addDriver',
                    'Name': driverName,
                    'NIC': nic,
                    'Contact': contact,
                    'AdminID':<?php echo $userID; ?>,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        $('#AddDriverModal').modal('hide');
                        //Clear Form
                        $('.form-control').val('');
                        GetDriverData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message, 'error');
                        if (response.message === "NIC already exists.") {
                            $('#U_nic_err').text('NIC already exists');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding Driver: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        function ChangeStatus(driverID, status) {
            //alert("Delete " + DriverID);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'ChangeStatusDriver',
                    'DriverID': driverID,
                    'Status': status,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("ID sent:\n Response : ", response);
                    if (response.success) {
                        //alert("Driver delete successfully");
                        GetDriverData($('#activeStatus').val().trim()); // Refresh the Driver list
                        showToast('Success', response.message, 'success');
                    } else {
                        if ($status == 0) {
                            showToast('Error', response.message || "Failed to Deactivate Driver", 'error');
                        } else {
                            showToast('Error', response.message || "Failed to Activate Driver", 'error');
                        }

                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Deactivate Driver: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });

        }

        function GetDriverData(type) {
            $('.DriverData').empty(); //Clear Conductor Data View

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Driver.php
                data: {
                    action: 'getDriverData',
                    'Type': type,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.DriverData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, driver) {
                            // console.log(Driver['DriverID']);

                            let row = '<tr data-driverid="' + driver['DriverID'] + '" data-drivername="' + driver['Name'] + '" data-drivernic="' + driver['NIC'] + '" data-drivercontact="' + driver['Contact'] + '">' +
                                '<th scope="row">' + driver['DriverID'] + '</th>' +
                                '<td>' + driver['Name'] + '</td>' +
                                '<td>' + driver['NIC'] + '</td>' +
                                '<td>' + driver['Contact'] + '</td>' +
                                '<td>' + driver['AdminID'] + '</td>';

                            if (driver['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (driver['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            $('.DriverData').append(row);

                        });

                        // Attach click event handler to Edit buttons
                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var driverID = $row.data('driverid');
                            var DName = $row.data('drivername');
                            var DNic = $row.data('drivernic');
                            var DContact = $row.data('drivercontact');

                            // console.log(driverID ,DName,DNic,DContact);

                            $('#EditDriverModal').modal('show');
                            // Update modal content and show the modal
                            $('#EditFormDriverID').text(driverID);
                            $('#U_Name').val(DName);
                            $('#U_Nic').val(DNic);
                            $('#U_contact').val(DContact);

                        });

                        // Attach click event handler to delete buttons
                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var driverID = $row.data('driverid');
                            var driverName = $row.data('drivername');

                            // Delete modal content and show the modal
                            $('#DriverID').text('\tID    : ' + driverID);
                            $('#DriverName').text('\tName  : ' + driverName);

                            $('#confirmDelete').data('driverid', driverID);
                            $('#Delete').modal('show'); // Use Bootstrap's method to show the modal


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var driverID = $row.data('driverid');
                            var driverName = $row.data('drivername');

                            // Update modal content and show the modal
                            $('#ActiveDriverID').text('\tID    : ' + driverID);
                            $('#ActiveDriverName').text('\tName  : ' + driverName);

                            $('#confirmActive').data('driverid', driverID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching driver data: " + status + " - " + error);
                }
            });
        }

        function Search(type,txtSearch) {
            $('.DriverData').empty(); //Clear Conductor Data View

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Driver.php
                data: {
                    action: 'SearchDriver',
                    'Type': type,
                    'txtSearch': txtSearch,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.DriverData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, driver) {
                            // console.log(Driver['DriverID']);

                            let row = '<tr data-driverid="' + driver['DriverID'] + '" data-drivername="' + driver['Name'] + '" data-drivernic="' + driver['NIC'] + '" data-drivercontact="' + driver['Contact'] + '">' +
                                '<th scope="row">' + driver['DriverID'] + '</th>' +
                                '<td>' + driver['Name'] + '</td>' +
                                '<td>' + driver['NIC'] + '</td>' +
                                '<td>' + driver['Contact'] + '</td>' +
                                '<td>' + driver['AdminID'] + '</td>';

                            if (driver['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (driver['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            $('.DriverData').append(row);

                        });

                        // Attach click event handler to Edit buttons
                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var driverID = $row.data('driverid');
                            var DName = $row.data('drivername');
                            var DNic = $row.data('drivernic');
                            var DContact = $row.data('drivercontact');

                            // console.log(driverID ,DName,DNic,DContact);

                            $('#EditDriverModal').modal('show');
                            // Update modal content and show the modal
                            $('#EditFormDriverID').text(driverID);
                            $('#U_Name').val(DName);
                            $('#U_Nic').val(DNic);
                            $('#U_contact').val(DContact);

                        });

                        // Attach click event handler to delete buttons
                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var driverID = $row.data('driverid');
                            var driverName = $row.data('drivername');

                            // Delete modal content and show the modal
                            $('#DriverID').text('\tID    : ' + driverID);
                            $('#DriverName').text('\tName  : ' + driverName);

                            $('#confirmDelete').data('driverid', driverID);
                            $('#Delete').modal('show'); // Use Bootstrap's method to show the modal


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var driverID = $row.data('driverid');
                            var driverName = $row.data('drivername');

                            // Update modal content and show the modal
                            $('#ActiveDriverID').text('\tID    : ' + driverID);
                            $('#ActiveDriverName').text('\tName  : ' + driverName);

                            $('#confirmActive').data('driverid', driverID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching driver data: " + status + " - " + error);
                }
            });
        }

        // Fetch the new Driver ID
        function SetDriverID() {

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getNextDriverID'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.newDriverID);
                    if (response.success) {
                        // Update the Driver ID in the modal
                        $('#ShowDriverID').text(response.newDriverID);
                    } else {
                        showToast('Error', response.message || "Failed to fetch new Driver ID", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching new Driver ID: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        // Function to show Bootstrap toast
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

        function EditDriver(driverID, U_name, U_Nic, U_contact){
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'updateDriver',
                    'DriverID': driverID,
                    'Name': U_name,
                    'NIC': U_Nic,
                    'Contact': U_contact,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        //alert("Driver Update successfully");

                        $('#EditDriverModal').modal('hide');
                        GetDriverData($('#activeStatus').val().trim()); // Refresh the Driver list
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message || "Failed to Update Driver", 'error');
                        if (response.message === "NIC already exists") {
                            $('#U_nic_err').text('NIC already exists');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Updateing Driver: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }
    </script>

</body>

</html>