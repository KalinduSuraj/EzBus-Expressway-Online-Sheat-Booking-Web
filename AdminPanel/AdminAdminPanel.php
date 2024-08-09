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
            /* Light green background */
            color: #155724;
            /* Dark green text */
        }

        .toast-header-error {
            background-color: #f8d7da;
            /* Light red background */
            color: #721c24;
            /* Dark red text */
        }

        .has-error .form-control {
            border-color: red;
        }

        .custom-modal-header {
            background-color: red;

            color: #f8d7da;

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
        #AddAdminModal {
            overflow-y: auto;
            scrollbar-width: none;
        }
    </style>
    <title></title>
</head>

<body class="body">
    <main class="">
        <h1 class="title mb-10">ADMIN LOGIN DETAILS</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Users / Admin</a></li>
        </ul>
    </main>
    <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddAdminModal" id="AddAdminModelButton">
            <i class="bi bi-plus-lg"></i><span>Add New Admin</span>
        </a>
        <!-- <a href="#" onclick="document.getElementById('Delete').style.display='block'" class="btn btn-danger" data-toggle="modal">
            <i class="bi bi-trash"></i><span>Delete Admin</span>
        </a> -->
    </div>
    <div class="mt-5">
        <table class="table table-hover table-striped " border="1.5" id="AdminViewTable">
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
            <tbody class="AdminData">

                <!-- 
                View Admin Data
             -->

            </tbody>
    </div>

    <!-- Toast container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts will be appended here -->
    </div>



    <!-- Add Admin Form Modal -->
    <div class="modal fade" id="AddAdminModal" tabindex="-1" aria-labelledby="AddAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;" id="AddAdminForm">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddAdminModalLabel">Add New Admin</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Admin</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center">
                                <b>
                                    <label class="form-label">Admin ID: </label>
                                    <label class="form-label" id="ShowAdminID"><!-- Show New AdminID --></label>
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
                        <button type="button" class="btn btn-success" id="AddAdmin">Add Admin</button>
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
                    <h5 class="modal-title" id="DeleteLabel">Delete Admin</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to delete this Admin?</p>
                    <div class="ml-5">
                        <b>

                            <label id="adminID"></label><br>
                            <label id="adminName"></label>
                        </b>
                    </div><br>
                    <p class="text-danger p-0 mb-0"><b><small>This action cannot be undone.</small></b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#AddAdminModelButton').on('click', function(event) {
                GetAdminID();
            });

            GetAdminData();
            $('#AddAdmin').on('click', function(event) {
                // alert("click");
                event.preventDefault(); // Prevent the form from submitting normally
                var first_name = $('#first_name').val().trim();
                var last_name = $('#last_name').val().trim();
                var email = $('#email').val().trim();
                var contact = $('#contact').val().trim();
                var new_password = $('#new_password').val().trim();
                var confirm_password = $('#confirm_password').val().trim();

                var isValid = AddAdminValidation(first_name, last_name, email, contact, new_password, confirm_password); // validte Add Admin Form
                if (isValid == true) {
                    var name = first_name + " " + last_name;
                    var result = AddAdmin(name, email, contact, new_password);
                } else {
                    alert("Check Your Details");
                }

            });

            // Handle the confirm delete button click
            $('#confirmDelete').on('click', function() {
                var adminID = $(this).data('adminid');
                DeleteAdmin(adminID);
            });

        })
        // clear errMsg Function
        function clearErr() {
            $('.errMsg').text('');
        }

        //Add Admin Validation Function
        function AddAdminValidation(first_name, last_name, email, contact, new_password, confirm_password) {
            // Clear previous error messages
            clearErr();

            var isValid = true;
            try {
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
            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }
        }

        //Add Admin Data
        function AddAdmin(name, email, contact, new_password) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Admin.php
                data: {
                    action: 'addAdmin',
                    'Name': name,
                    'Email': email,
                    'Contact': contact,
                    'Password': new_password,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        //alert("Admin added successfully");

                        $('#AddAdminModal').modal('hide');
                        Clear();
                        GetAdminData(); // Refresh the admin list
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message || "Failed to add admin", 'error');
                        if (response.message === "Email already exists.") {
                            $('#email_err').text('Email already exists');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding admin: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        // Function to show Bootstrap toast
        function showToast(title, message, type) {
            const borderClass = type === 'success' ? 'toast-success' : 'toast-error'; //asing the boder color as msg type
            const headerClass = type === 'success' ? 'toast-header-success' : 'toast-header-error';
            const toastHTML = `
                <div class="toast ${borderClass}" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header ${headerClass}">
                        <img src="..." class="rounded me-2" alt="...">
                        <strong class="me-auto">${title}</strong>
                        <small class="text-muted">Just now</small>
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

        // Get Admin Data
        function GetAdminData() {
            $('.AdminData').empty(); // Clear Admin Data View

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getAdminData'
                },
                success: function(response) {
                    $.each(response, function(key, admin) {
                        $('.AdminData').append(
                            '<tr data-adminid="' + admin['AdminID'] + '" data-adminname="' + admin['Name'] + '">' +
                            '<th scope="row">' + admin['AdminID'] + '</th>' +
                            '<td>' + admin['Name'] + '</td>' +
                            '<td>' + admin['Email'] + '</td>' +
                            '<td>' + admin['Contact'] + '</td>' +
                            '<td>' + admin['Password'] + '</td>' +
                            '<td>' + admin['Creator'] + '</td>' +
                            '<td class="ms-auto d-flex gap-2">' +
                            '<a href="#" class="edit-btn"><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0"></i></a>' +
                            '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0"></i></a>' +
                            '</td>' +
                            '</tr>'
                        );
                    });

                    // Attach click event handler to Edit buttons
                    $('.edit-btn').on('click', function(e) {
                        e.preventDefault();
                        var adminID = $(this).closest('tr').data('adminid');
                        EditAdmin(adminID);
                    });

                    // Attach click event handler to delete buttons
                    $('.delete-btn').on('click', function(e) {
                        e.preventDefault();
                        var $row = $(this).closest('tr');
                        var adminID = $row.data('adminid');
                        var adminName = $row.data('adminname');

                        // Update modal content and show the modal
                        $('#adminID').text('\tID    : ' + adminID);
                        $('#adminName').text('\tName  : ' + adminName);
                        $('#confirmDelete').data('adminid', adminID);
                        $('#Delete').modal('show'); // Use Bootstrap's method to show the modal
                    });


                },
                error: function(xhr, status, error) {
                    console.error("Error fetching admin data: " + status + " - " + error);
                }
            });
        }

        // Edit Admin Function
        function EditAdmin(AdminID) {
            alert("Edit " + AdminID);
        }

        // Delete Admin Function
        function DeleteAdmin(AdminID) {
            //alert("Delete " + AdminID);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Admin.php
                data: {
                    action: 'deleteAdmin',
                    'AdminID': AdminID,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("ID sent:\n", response);

                    if (response.success) {
                        //alert("Admin delete successfully");
                        GetAdminData(); // Refresh the admin list
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message || "Failed to Delete admin", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Delete admin: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
            $('#Delete').modal('hide');
        }

        // Fetch the new Admin ID
        function GetAdminID() {

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getNextAdminID'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.newAdminID);
                    if (response.success) {
                        // Update the Admin ID in the modal
                        $('#ShowAdminID').text(response.newAdminID);
                    } else {
                        showToast('Error', response.message || "Failed to fetch new Admin ID", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching new Admin ID: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        //Clear Add Admin Form
        function Clear() {
            $('#first_name').val('');
            $('#last_name').val('');
            $('#email').val('');
            $('#contact').val('');
            $('#new_password').val('');
            $('#confirm_password').val('');
        }
    </script>
</body>

</html>