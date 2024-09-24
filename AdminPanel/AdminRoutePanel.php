
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
        <h1 class="title mb-10">ROUTE</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="RouteView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Route</a></li>
        </ul>
    </main>

    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddRouteModal" id="AddRouteModelButton">
                <i class="bi bi-plus-lg"></i><span>Add Route</span>
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
        <table class="table table-hover table-striped " border="1.5" id="RouteViewTable">
            <thead>
                <tr class="table-success ">
                    <th scope="col" width="22%">#</th>
                    <th scope="col" width="22%">From</th>
                    <th scope="col" width="22%">To</th>
                    <th scope="col" width="22%">Ticket Price</th>
                    <th> <!-- Action --></th>
                </tr>
            </thead>
            <tbody class="RouteData">

                <!-- 
                View Route Data
             -->

            </tbody>
    </div>

    <!-- Toast container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts will be appended here -->
    </div>

    <!-- Add Route Form -->
    <div class="modal fade" id="AddRouteModal" tabindex="-1" aria-labelledby="AddRouteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddRouteModalLabel">Add New Route</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Route</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Route ID : </label>
                                    <label class="form-label" id="ShowRouteID"><!-- Show Route ID --></label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">From :</label>
                                <input type="text" class="form-control" name="from" id="from" placeholder="Galle">
                                <span class="errMsg" id="from_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">To :</label>
                                <input type="text" class="form-control" name="to" id="to" placeholder="Kadawatha">
                                <span class="errMsg" id="to_err"></span>
                            </div>
                        </div>
                        <div class="col"> 
                            <span class="errMsg" id="route_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Ticket Price</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="100.00">
                            <span class="errMsg" id="price_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="AddFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddRoute">Add Route</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Route Form -->
    <div class="modal fade" id="EditRouteModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="EditRouteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="EditRouteModalLabel">Update New Route</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to Update a new Route</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Route ID : </label>
                                    <label class="form-label" id="EditFormRouteID"><!-- Show Route ID --></label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">From :</label>
                                <input type="text" class="form-control" name="U_from" id="U_from" placeholder="Galle" disabled>
                                <span class="errMsg" id="U_from_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">To :</label>
                                <input type="text" class="form-control" name="U_to" id="U_to" placeholder="Kadawatha" disabled>
                                <span class="errMsg" id="U_to_err"></span>
                            </div>
                        </div>
                        <div class="col"> 
                            <span class="errMsg" id="U_route_err"></span>
                        </div>
                        <div class="col">
                            <label class="form-label">Ticket Price</label>
                            <input type="text" class="form-control" name="U_price" id="U_price" placeholder="100.00">
                            <span class="errMsg" id="U_price_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="EditFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="UpdateRoute">Update Route</button>
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
                    <h5 class="modal-title" id="DeleteLabel">Deactive Route</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to deactive this Route?</p>
                    <div class="ml-5">
                        <b>

                            <label id="RouteID"></label><br>
                            <label id="From"></label><br>
                            <label id="To"></label>

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
                    <h5 class="modal-title" id="ActiveLabel">Active Route</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to Active this Route ?</p>
                    <div class="ml-5">
                        <b>

                            <label id="ActiveRouteID"></label><br>
                            <label id="ActiveFrom"></label><br>
                            <label id="ActiveTo"></label>

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
            // console.log(type);
            GetRouteData(type);
        });

        $('#activeStatus').change(function() {
            var type = $('#activeStatus').val().trim();
            GetRouteData(type);
        });

        $('#txtSearch').keyup(function() {
            var type = $('#activeStatus').val().trim();
            var txtSearch = $('#txtSearch').val().trim();
            //alert(type + txtSearch)
            Search(type, txtSearch);
        });

        $('#AddRouteModelButton').on('click', function(event) {
            SetRouteID();
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

        $('#AddRoute').on('click', function(event) {
            // alert("click");
            event.preventDefault(); // Prevent the form from submitting normally

            var from = $('#from').val().trim();
            var to = $('#to').val().trim();
            var price = $('#price').val().trim();

            var isValid = AddRouteValidation(from, to, price)
            if (isValid == true) {
                //alert(isValid);
                AddRoute(from, to, price);
            } else {
                console.log("Check Your Inputs");
            }

        });

        // click in Update Route button 
        $('#UpdateRoute').on('click', function() {
            // alert("click");
            event.preventDefault();

            var routeID = $('#EditFormRouteID').text();
            var U_price = $('#U_price').val().trim();

            var isValid = UpdateRouteValidation(U_price);
            if (isValid == true) {
                console.log(routeID);
                EditRoute(routeID, U_price);
            } else {
                console.log("Check Your Details");
            }
        });

        $('#confirmDelete').on('click', function(event) {
            var routeID = $(this).data('routeid');
            var status = 0;
            ChangeStatus(routeID, status);
            $('#Delete').modal('hide');
        })

        // click in confirm Active button
        $('#confirmActive').on('click', function() {
            var routeID = $(this).data('routeid');
            var status = 1;
            ChangeStatus(routeID, status);
            $('#ActiveModel').modal('hide');
        });

        //Add Route Validation Function
        function AddRouteValidation(from, to, price) {
            // Clear previous error messages
            $('.errMsg').text('');
            var isValid = true;
            try {
                //Simple validation
                if (from === '') {
                    $('#from_err').text('Required');
                    isValid = false;

                }
                if (to === '') {
                    $('#to_err').text('Required');
                    isValid = false;

                }
                if (price == '') {
                    $('#price_err').text('Enter Ticket Price');
                    isValid = false;

                } else if (price <= 0) {
                    $('#price_err').text('Enter Valide Ticket Price');
                    isValid = false;

                }
            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }

        }

        //Add Route Validation Function
        function UpdateRouteValidation(U_price) {
            $('.errMsg').text('');
            var isValid = true;
            try {
                if (U_price == '') {
                    $('#U_price_err').text('Enter Ticket Price');
                    isValid = false;

                } else if (U_price <= 0) {
                    $('#U_price_err').text('Enter Valide Ticket Price');
                    isValid = false;

                }
            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }

        }

        //Add Route Data
        function AddRoute(from, to, price) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'addRoute',
                    'From': from,
                    'To': to,
                    'Price': price,
                    'AdminID':<?php echo $userID; ?>,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);
                    // console.log("response.success:\n", response.success);

                    if (response.success) {
                        $('#AddRouteModal').modal('hide');
                        //Clear Form
                        $('.form-control').val('');
                        GetRouteData($('#activeStatus').val().trim());
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message, 'error');
                        if (response.message === "Route already exists.") {
                            $('#route_err').text('Route already exists');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding Route: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        function ChangeStatus(routeID, status) {
            //alert("Delete " + RouteID);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'ChangeStatusRoute',
                    'RouteID': routeID,
                    'Status': status,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("ID sent:\n Response : ", response);
                    if (response.success) {
                        //alert("Route delete successfully");
                        GetRouteData($('#activeStatus').val().trim()); // Refresh the Route list
                        showToast('Success', response.message, 'success');
                    } else {
                        if ($status == 0) {
                            showToast('Error', response.message || "Failed to Deactivate Route", 'error');
                        } else {
                            showToast('Error', response.message || "Failed to Activate Route", 'error');
                        }

                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Deactivate Route: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });

        }

        function GetRouteData(type) {
            $('.RouteData').empty();
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getRouteData',
                    'Type': type,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.RouteData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, route) {
                            // console.log(Route['RouteID']);

                            let row = '<tr data-routeid="' + route['RouteID'] + '" data-from="' + route['FromCity'] + '" data-to="' + route['ToCity'] + '" data-price="' + route['Price'] + '">' +
                                '<th scope="row">' + route['RouteID'] + '</th>' +
                                '<td>' + route['FromCity'] + '</td>' +
                                '<td>' + route['ToCity'] + '</td>' +
                                '<td>' + route['Price'] + '</td>';

                            if (route['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (route['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            $('.RouteData').append(row);

                        });

                        // Attach click event handler to Edit buttons
                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var routeID = $row.data('routeid');
                            var from = $row.data('from');
                            var to = $row.data('to');
                            var price = $row.data('price');

                            // console.log(routeID ,from,to,price);

                            $('#EditRouteModal').modal('show');
                            // Update modal content and show the modal
                            $('#EditFormRouteID').text(routeID);
                            $('#U_from').val(from);
                            $('#U_to').val(to);
                            $('#U_price').val(price);

                        });

                        // Attach click event handler to delete buttons
                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var routeID = $row.data('routeid');
                            var from = $row.data('from');
                            var to = $row.data('to');

                            // Delete modal content and show the modal
                            $('#RouteID').text('\tID    : ' + routeID);
                            $('#From').text('\tFrom  : ' + from);
                            $('#To').text('\tTo  : ' + to);

                            $('#confirmDelete').data('routeid', routeID);
                            $('#Delete').modal('show');


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var routeID = $row.data('routeid');
                            var from = $row.data('from');
                            var to = $row.data('to');

                            // Update modal content and show the modal
                            $('#ActiveRouteID').text('\tID    : ' + RouteID);
                            $('#ActiveFrom').text('\tFrom  : ' + from);
                            $('#ActiveTo').text('\tTo  : ' + to);

                            $('#confirmActive').data('routeid', routeID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching route data: " + status + " - " + error);
                    console.log(xhr.responseText);
                }
            });
        }

        function Search(type, txtSearch) {
            $('.RouteData').empty(); //Clear Conductor Data View

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'SearchRoute',
                    'Type': type,
                    'txtSearch': txtSearch,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data received:\n", response);
                    if (response.message) {
                        $('.RouteData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, route) {
                            // console.log(Route['RouteID']);

                            let row = '<tr data-routeid="' + route['RouteID'] + '" data-from="' + route['FromCity'] + '" data-to="' + route['ToCity'] + '" data-price="' + route['Price'] + '">' +
                                '<th scope="row">' + route['RouteID'] + '</th>' +
                                '<td>' + route['FromCity'] + '</td>' +
                                '<td>' + route['ToCity'] + '</td>' +
                                '<td>' + route['Price'] + '</td>';

                            if (route['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }
                            if (route['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            $('.RouteData').append(row);

                        });

                        // Attach click event handler to Edit buttons
                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var routeID = $row.data('routeid');
                            var from = $row.data('from');
                            var to = $row.data('to');
                            var price = $row.data('price');

                            // console.log(routeID ,from,to,price);

                            $('#EditRouteModal').modal('show');
                            // Update modal content and show the modal
                            $('#EditFormRouteID').text(routeID);
                            $('#U_from').val(from);
                            $('#U_to').val(to);
                            $('#U_price').val(price);

                        });

                        // Attach click event handler to delete buttons
                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var routeID = $row.data('routeid');
                            var from = $row.data('from');
                            var to = $row.data('to');

                            // Delete modal content and show the modal
                            $('#RouteID').text('\tID    : ' + routeID);
                            $('#From').text('\tFrom  : ' + from);
                            $('#To').text('\tTo  : ' + to);

                            $('#confirmDelete').data('routeid', routeID);
                            $('#Delete').modal('show');


                        });

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var routeID = $row.data('routeid');
                            var from = $row.data('from');
                            var to = $row.data('to');

                            // Update modal content and show the modal
                            $('#ActiveRouteID').text('\tID    : ' + RouteID);
                            $('#ActiveFrom').text('\tFrom  : ' + from);
                            $('#ActiveTo').text('\tTo  : ' + to);

                            $('#confirmActive').data('routeid', routeID);
                            $('#ActiveModel').modal('show');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching route data: " + status + " - " + error);
                }
            });
        }

        // Fetch the new Route ID
        function SetRouteID() {

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getNextRouteID'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.newRouteID);
                    if (response.success) {
                        // Update the Route ID in the modal
                        $('#ShowRouteID').text(response.newRouteID);
                    } else {
                        showToast('Error', response.message || "Failed to fetch new Route ID", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching new Route ID: " + status + " - " + error);
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

        function EditRoute(routeID, U_price) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'updateRoute',
                    'RouteID': routeID,
                    'Price': U_price,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        //alert("Route Update successfully");

                        $('#EditRouteModal').modal('hide');
                        GetRouteData($('#activeStatus').val().trim()); // Refresh the Route list
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message || "Failed to Update Route", 'error');
                        if (response.message === "Route already exists.") {
                            $('#U_route_err').text('Route already exists');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Updateing Route: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }
    </script>
</body>

</html>