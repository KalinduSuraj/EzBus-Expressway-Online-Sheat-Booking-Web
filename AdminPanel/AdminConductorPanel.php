<?php
require_once '../Backend/Conductor.php';
// Create an instance of the Admin class
$conductor = new Conductor();

// Get the adminID
$NewConductorID = $conductor->generateNewConductorID();
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
            font-size: 28px;
            font-weight: 600;
        }

        main .breadcrumbs li,
        main .breadcrumbs li a {
            font-size: 14px;
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
        <h1 class="title mb-10">CONDUCTOR LOGIN DETAILS</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Users / Conductor</a></li>
        </ul>
    </main>

    <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddConductorModal">
            <i class="bi bi-plus-lg"></i><span>Add New Conductor</span>
        </a>
        <!-- <a href="#" onclick="document.getElementById('Delete').style.display='block'" class="btn btn-danger" data-toggle="modal">
            <i class="bi bi-trash"></i><span>Delete Conductor</span>
        </a> -->
    </div>
    <div class="mt-5">
        <table class="table table-hover table-striped " border="1.5" id="ConductorViewTable">
            <thead>
                <tr class="table-success ">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Password</th>
                    <th scope="col">Creator</th>
                    <th width="" class=""></th>
                </tr>
            </thead>
            <tbody class="ConductorData">
                <!-- 
                View Conductor Data
             -->

            </tbody>
    </div>


    <!-- Add Conductor Form -->
    <div class="modal fade" id="AddConductorModal" tabindex="-1" aria-labelledby="AddConductorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddConductorModalLabel">Add New Conductor</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Conductor</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Conductor ID : </label>
                                    <label class="form-label" id="ShowConductorID">
                                    <?php echo htmlspecialchars($NewConductorID); ?>
                                    </label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">First Name:</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Kalindu">
                                <span class="errMsg" id="first_name_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Suraj">
                                <span class="errMsg" id="last_name_err"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                            <span class="errMsg" id="email_err"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact No:</label>
                            <input type="text" class="form-control" name="contact" id="contact" placeholder="07X XXXX XXX">
                            <span class="errMsg" id="contact_err"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Create Password:</label>
                            <input type="password" class="form-control mb-2" name="new_password" id="new_password" placeholder="Create Password">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                            <span class="errMsg" id="password_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" onclick="clearErr()">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddConductor">Add Conductor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!----delete-modal start--------->
    <div class="modal " tabindex="-1" id="Delete" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Conductor</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Records</p>
                    <p class="text-warning"><small>this action Cannot be Undone,</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('Delete').style.display='none'" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('Delete').style.display='none'" id="DeleteConductor">Delete</button>
                </div>
            </div>


        </div>
    </div>

    <script>
        
        $(document).ready(function() {

            GetConductorData() 

            $('#AddConductor').on('click', function(event) {
                // alert("click");
                event.preventDefault(); // Prevent the form from submitting normally

                AddConductorValidation();
                
            });

            $('#DeleteConductor').on('click', function(event) {
                DeleteConductor();
            })
        })
        function clearErr() {
            $('.errMsg').text('');
        }

        //Add Counter Validation Function
        function AddConductorValidation() {
            // Clear previous error messages
            clearErr();

            var isValid = true;

            var first_name = $('#first_name').val().trim();
            var last_name = $('#last_name').val().trim();
            var email = $('#email').val().trim();
            var contact = $('#contact').val().trim();
            var new_password = $('#new_password').val().trim();
            var confirm_password = $('#confirm_password').val().trim();

            //Simple validation
            if (first_name === '') {
                $('#first_name_err').text('First Name is required');
                isValid = false;
                return;
            }
            if (last_name === '') {
                $('#last_name_err').text('Last Name is required');
                isValid = false;
                return;
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === '') {
                $('#email_err').text('Email is required');
                isValid = false;
                return;
            } else if (!emailRegex.test(email)) {
                $('#email_err').text('Please enter a valid email address.');
                isValid = false;
                return;
            }

            if (contact === '') {
                $('#contact_err').text('Contact is required');
                isValid = false;
                return;
            } else if (contact.length !== 10) {
                $('#contact_err').text('Contact number must be exactly 10 digits');
                isValid = false;
                return;
            }

            if (new_password === '') {
                $('#password_err').text('Password is required');
                isValid = false;
                return;
            } else if (new_password !== confirm_password) {
                $('#password_err').text('Passwords do not match');
                isValid = false;
                return;
            }

            if (isValid == true) {
                alert(isValid);
            }
        }

        // Delete Conductor Function
        function DeleteConductor() {
            alert("Delete");
        }

        function GetConductorData() {
            $('.ConductorData').empty();//Clear Conductor Data View
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Conductor.php
                data: {
                    action: 'getConductorData'
                },
                success: function(response) {
                    // console.log("Data received:\n", response);

                    $.each(response, function(key, conductor) {
                        // console.log(conductor['ConductorID']);

                        $('.ConductorData').append(
                            '<tr class="">' +
                            '<th scope="row">' + conductor['ConductorID'] + '</th>' +
                            '<td>' + conductor['Name'] + '</td>' +
                            '<td>' + conductor['Email'] + '</td>' +
                            '<td>' + conductor['Contact'] + '</td>' +
                            '<td>' + conductor['Password'] + '</td>' +
                            '<td>' + conductor['AdminID'] + '</td>' +
                            '<td class="ms-auto d-flex gap-2">' +
                            '<a href="#"><i class="bi bi-pencil-square btn btn-sm btn-outline-success  pt-0 pb-0"></i></a>' +
                            '<a href="#"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0"></i></a>' +
                            '</td>' +
                            '</tr>'
                        )
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Conductor data: " + status + " - " + error);
                }
            });
        }
    </script>
</body>

</html>