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
            padding: 24px 20px 20px 20px;
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
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddDriverModal">
                <i class="bi bi-plus-lg"></i><span>Add New Driver</span>
            </a>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control" id="txtSearch" placeholder="Search">
        </div>
        <div class="col-auto">
            <input type="button" class="btn btn-primary" id="txtSearch" value="Search">
        </div>
    </div>
    <div class="mt-5">
        <table class="table table-hover table-striped " border="1.5" id="AdminViewTable">
            <thead>
                <tr class="table-success ">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact</th>
                    <th width="" class=""></th>
                </tr>
            </thead>
            <tbody class="DriverData">

                <!-- 
                View Driver Data
             -->

            </tbody>
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
                        <div class="mb-3">
                            <label class="form-label">Driver Contact No :</label>
                            <input type="text" class="form-control" name="contact" id="contact" placeholder="07X XXXX XXX">
                            <span class="errMsg" id="contact_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" onclick="clearErr()">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddDriver">Add Driver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!----delete-modal start--------->
    <div class="modal" tabindex="-1" id="Delete" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title">Delete Drivers</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Records</p>
                    <p class="text-warning"><small>this action Cannot be Undone,</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('Delete').style.display='none'" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('Delete').style.display='none'" id="DeleteDriver">Delete</button>
                </div>
            </div>


        </div>
    </div>

    <script>
        $(document).ready(function() {

            GetDriverData();



            $('#AddDriver').on('click', function(event) {
                // alert("click");
                event.preventDefault(); // Prevent the form from submitting normally

                var driverName = $('#driverName').val().trim();
                var contact = $('#contact').val().trim();

                var isValid = AddDriverValidation(driverName, contact)
                if (isValid == true) {
                    //alert(isValid);
                    var result = AddDriver(driverName, contact);
                    if (result) {
                        alert("Driver added successfully");
                    } else {
                        alert("Driver not added ");
                    }
                } else {

                }

            });

            $('#DeleteDriver').on('click', function(event) {
                DeleteDriver(); //Delete Driver
            })


        })
        // clear errMsg Function
        function clearErr() {
            $('.errMsg').text('');
        }

        //Add Driver Validation Function
        function AddDriverValidation(driverName, contact) {
            // Clear previous error messages
            clearErr();

            var isValid = true;
            try {
                //Simple validation
                if (driverName === '') {
                    $('#driverName_err').text('Name is required');
                    isValid = false;
                    return;
                }
                if (contact === '') {
                    $('#contact_err').text('Contact is required');
                    isValid = false;
                    return;
                }
            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }

        }

        //Add Driver Data
        function AddDriver(driverName, contact) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Driver.php
                data: {
                    action: 'addDriver',
                    'Name': name,
                    'Contact': contact,
                },
                success: function(response) {
                    console.log("Data sent:\n", response);

                    $('#AddDriverModal').modal('hide');
                    GetDriverData(); // Refresh the Driver list
                },
                error: function(xhr, status, error) {
                    console.error("Error adding Driver: " + status + " - " + error);
                }
            });
        }

        // Delete Driver Function
        function DeleteDriver() {
            alert("Delete");
        }

        function GetDriverData() {
            $('.DriverData').empty(); //Clear Conductor Data View

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Driver.php
                data: {
                    action: 'getDriverData'
                },
                success: function(response) {
                    // console.log("Data received:\n", response);

                    $.each(response, function(key, driver) {
                        // console.log(Driver['DriverID']);

                        $('.DriverData').append(
                            '<tr class="">' +
                            '<th scope="row">' + driver['DriverID'] + '</th>' +
                            '<td>' + driver['Location'] + '</td>' +
                            '<td>' + driver['Name'] + '</td>' +
                            '<td>' + driver['Email'] + '</td>' +
                            '<td>' + driver['Contact'] + '</td>' +
                            '<td>' + driver['Password'] + '</td>' +
                            '<td>' + driver['AdminID'] + '</td>' +
                            '<td class="ms-auto d-flex gap-2">' +
                            '<a href="#"><i class="bi bi-pencil-square btn btn-sm btn-outline-success  pt-0 pb-0"></i></a>' +
                            '<a href="#"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0"></i></a>' +
                            '</td>' +
                            '</tr>'
                        )
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching driver data: " + status + " - " + error);
                }
            });
        }
    </script>

</body>

</html>