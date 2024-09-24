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
        #AddAdminModal {
            overflow-y: auto;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="body">
    <main class="">
        <h1 class="title mb-10 mt-0">ADMIN LOGIN DETAILS</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Users / Admin</a></li>
        </ul>
    </main>

    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddAdminModal" id="AddAdminModelButton">
                <i class="bi bi-plus-lg"></i><span>Add New Admin</span>
            </a>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control form-control-sm" id="txtSearch" placeholder="Search">
        </div>
        <!-- <div class="col-auto">
             <input type="button" class="btn btn-primary btn-sm" id="txtSearch" value="Search"> 
        </div> -->
        <div class="col-auto">
            <select name="activeStatus" id="activeStatus" class="form-select form-select-sm ">

                <option value="1" default>Active</option>
                <option value="0">Deactive</option>

            </select>
        </div>
    </div>

    <!-- Data View Table -->
    <div class="mt-3">
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
        </table>
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
                        <div class="row mb-1">
                            <div class="col">
                                <label class="form-label">First Name:</label>
                                <input type="text" class="form-control form-control-sm" name="first_name" id="first_name" placeholder="Kalindu">
                                <span class="errMsg" id="first_name_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Last Name:</label>
                                <input type="text" class="form-control form-control-sm" name="last_name" id="last_name" placeholder="Suraj">
                                <span class="errMsg" id="last_name_err"></span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="name@example.com">
                            <span class="errMsg" id="email_err"></span>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Contact No:</label>
                            <input type="text" class="form-control form-control-sm" name="contact" id="contact" placeholder="07X XXXX XXX">
                            <span class="errMsg" id="contact_err"></span>
                        </div>
                        <div class="mb-1">
                            <label class="form-label"> Password:</label>
                            <input type="text" class="form-control form-control-sm mb-2" name="password" id="password" placeholder="Password" disabled>
                            <span class="errMsg" id="password_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" id="AddFormCancel">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddAdmin">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Admin Form Modal -->
    <div class="modal fade" id="EditAdminModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down ">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-center mb-0">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    <h5 class="modal-title" id="EditAdminModalLabel">Update Admin Details</h5>
                    <div class="row mb-0 w-100 pb-0">
                        <div class="col text-center">
                            <b>
                                <label class="form-label">Admin ID: </label>
                                <label class="form-label" id="EditFormAdminID"><!-- Show AdminID --></label>
                            </b>
                        </div>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="col">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control form-control-sm" name="U_name" id="U_name" placeholder="Kalindu Suraj" >
                        <span class="errMsg" id="U_name_err"></span>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control form-control-sm" name="U_email" id="U_email" placeholder="name@example.com">
                        <span class="errMsg" id="U_email_err"></span>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Contact No:</label>
                        <input type="text" class="form-control form-control-sm" name="U_contact" id="U_contact" placeholder="07X XXXX XXX">
                        <span class="errMsg" id="U_contact_err"></span>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Update Password:</label>
                        <input type="text" class="form-control form-control-sm " name="U_password" id="U_password" placeholder="Update Password">
                        <span class="errMsg" id="U_password_err"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="EditFormCancel">Cancel</button>
                    <button type="button" class="btn btn-primary" id="UpdateAdmin">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="Delete" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="DeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title" id="DeleteLabel">Deactive Admin</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to deactive this Admin?</p>
                    <div class="ml-5">
                        <b>

                            <label id="adminID"></label><br>
                            <label id="adminName"></label>
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
                    <h5 class="modal-title" id="ActiveLabel">Active Admin</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to Active this Admin?</p>
                    <div class="ml-5">
                        <b>

                            <label id="ActiveadminID"></label><br>
                            <label id="ActiveadminName"></label>
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
            //var type = $('#activeStatus').val().trim();
            GetAdminData($('#activeStatus').val().trim());
        })

        $('#activeStatus').change(function() {
            var type = $('#activeStatus').val().trim();
            GetAdminData(type);
        });

        $('#txtSearch').keyup(function() {

            var type = $('#activeStatus').val().trim();
            var txtSearch = $('#txtSearch').val().trim();
            // alert(type + txtSearch)
            Search(type, txtSearch);
        });

        $('#AddAdminModelButton').on('click', function(event) {
            GetAdminID();
            var text = generatePassword();
            $('#password').val(text);

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

        // click in Add Admin Model
        $('#AddAdmin').on('click', function(event) {
            // alert("click");
            event.preventDefault(); // Prevent the form from submitting normally

            var first_name = $('#first_name').val().trim();
            var last_name = $('#last_name').val().trim();
            var email = $('#email').val().trim();
            var contact = $('#contact').val().trim();
            var password = $('#password').val().trim();

            var isValid = AddAdminValidation(first_name, last_name, email, contact, password); // validte Add Admin Form
            if (isValid == true) {
                var name = first_name + " " + last_name;
                var result = AddAdmin(name, email, contact, password);
            } else {
                console.log("Check Your Details");
            }

        });

        // click in Update Admin button 
        $('#UpdateAdmin').on('click', function() {
            // alert("click");
            event.preventDefault();
            var adminID = $('#EditFormAdminID').text();
            var U_name = $('#U_name').val().trim();
            var U_email = $('#U_email').val().trim();
            var U_contact = $('#U_contact').val().trim();
            var U_password = $('#U_password').val().trim();

            var isValid = UpdateAdminValidation(U_name, U_email, U_contact, U_password);
            if (isValid == true) {
                EditAdmin(adminID,U_name, U_email, U_contact, U_password);
            } else {
                console.log("Check Your Details");
            }
        });

        // click in confirm delete button 
        $('#confirmDelete').on('click', function() {
            var adminID = $(this).data('adminid');
            var status = 0;
            ChangeStatus(adminID, status);
            $('#Delete').modal('hide');
            //GetAdminData($('#activeStatus').val().trim());
        });

        // click in confirm Active button
        $('#confirmActive').on('click', function() {
            var adminID = $(this).data('adminid');
            var status = 1;
            ChangeStatus(adminID, status);
            $('#ActiveModel').modal('hide');
        });

        //Generate First Password
        function generatePassword() {
            var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&_+";
            var password = "";
            for (var i = 0; i < 10; i++) {
                var randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            return password;
        }

        //Add Admin Validation Function
        function AddAdminValidation(first_name, last_name, email, contact, password) {
            // Clear previous error messages
            $('.errMsg').text('');

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

                if (password === '') {
                    $('#password_err').text('Password is required');
                    isValid = false;
                    return;
                }

            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }
        }

        //Add Admin Validation Function
        function UpdateAdminValidation(U_name, U_email, U_contact, U_password) {
            // Clear previous error messages
            $('.errMsg').text('');

            var isValid = true;
            try {
                if(U_name === ''){
                    $('#U_name_err').text('Full Name is required');
                    isValid = false;
                    return;
                }

                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (U_email === '') {
                    $('#U_email_err').text('Email is required');
                    isValid = false;
                    return;
                } else if (!emailRegex.test(U_email)) {
                    $('#U_email_err').text('Please enter a valid email address.');
                    isValid = false;
                    return;
                }

                if (U_contact === '') {
                    $('#U_contact_err').text('Contact is required');
                    isValid = false;
                    return;
                } else if (U_contact.length !== 10) {
                    $('#U_contact_err').text('Contact number must be exactly 10 digits');
                    isValid = false;
                    return;
                }

                if (U_password === '') {
                    $('#U_password_err').text('Password is required');
                    isValid = false;
                    return;
                }
                return isValid;
            } catch (err) {
                alert("Somthing Went Wrong........\n" + err);
            } finally {
                return isValid;
            }
        }

        //Add Admin Data
        function AddAdmin(name, email, contact, password) {
            console.log('<?php echo $userID ?>')
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'addAdmin',
                    'Name': name,
                    'Email': email,
                    'Contact': contact,
                    'Password': password,
                    'AdminID':"<?php echo $userID ?>",
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        //alert("Admin added successfully");

                        $('#AddAdminModal').modal('hide');
                        //Clear Add Admin Form
                        $('#first_name').val('');
                        $('#last_name').val('');
                        $('#email').val('');
                        $('#contact').val('');
                        $('#password').val('');

                        GetAdminData($('#activeStatus').val().trim()); // Refresh the admin list
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
                delay: 10000
            }).show();
        }

        // Get Admin Data
        function GetAdminData(type) {
            //alert(type);
            $('.AdminData').empty(); // Clear Admin Data View
            const hiddenPassword = '*'.repeat(10);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                dataType: "json",
                data: {
                    action: 'getAdminData',
                    'Type': type,
                },
                success: function(response) {
                    console.log("Data sent:\n", response);
                    if (response.message) {
                        
                        $('.AdminData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, admin) {
                            // Start building the table row
                            let row = '<tr data-adminid="' + admin['AdminID'] + '" data-adminname="' + admin['Name'] + '" data-adminemail="' + admin['Email'] + '" data-admincontact="' + admin['Contact'] + '" data-adminpassword="' + admin['Password'] + '">' +
                                '<th scope="row">' + admin['AdminID'] + '</th>' +
                                '<td>' + admin['Name'] + '</td>' +
                                '<td>' + admin['Email'] + '</td>' +
                                '<td>' + admin['Contact'] + '</td>' +
                                '<td>' +
                                '<span class="hidden-password">' + hiddenPassword + '</span>' +
                                '<span class="actual-password d-none">' + admin['Password'] + '</span>' +
                                '<a href="#" class="toggle-password ms-2"><i class="bi bi-eye-slash"></i></a>' +
                                '</td>' +
                                '<td>' + admin['Creator'] + '</td>';

                            // Conditionally add buttons based on AdminID and status
                            if (admin['AdminID'] !== "A000" && admin['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }

                            // Another condition for status
                            if (admin['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            // Append the built row to the table
                            $('.AdminData').append(row);
                        });

                        // Attach click event handler to Edit buttons
                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var adminID = $row.data('adminid');
                            var adminName = $row.data('adminname');
                            var email = $row.data('adminemail');
                            var contact = $row.data('admincontact');
                            var password = $row.data('adminpassword');
                            var creator = $row.data('admincreator');
                            if (adminID == "A000") {
                                showToast('Error', "Can't Edit \"A000\" Admin", 'error');
                            } else {
                                $('#EditAdminModal').modal('show');
                                // Update modal content and show the modal
                                $('#EditFormAdminID').text(adminID);
                                $('#U_name').val(adminName);
                                $('#U_email').val(email);
                                $('#U_contact').val(contact);
                                $('#U_password').val(password);

                            }
                        });

                        // Attach click event handler to delete buttons
                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var adminID = $row.data('adminid');
                            var adminName = $row.data('adminname');
                            if (adminID == "A000") {
                                showToast('Error', "Can't Delete \"A000\" Admin", 'error');
                            } else {
                                // Update modal content and show the modal
                                $('#adminID').text('\tID    : ' + adminID);
                                $('#adminName').text('\tName  : ' + adminName);

                                $('#confirmDelete').data('adminid', adminID);
                                $('#Delete').modal('show'); // Use Bootstrap's method to show the modal
                            }

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

                        $('.active-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var adminID = $row.data('adminid');
                            var adminName = $row.data('adminname');

                            // Update modal content and show the modal
                            $('#ActiveadminID').text('\tID    : ' + adminID);
                            $('#ActiveadminName').text('\tName  : ' + adminName);

                            $('#confirmActive').data('adminid', adminID);
                            $('#ActiveModel').modal('show');

                        });
                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching admin data: " + status + " - " + error);
                }
            });
        }

        //Get Search Data
        function Search(type, txtSearch) {
            $('.AdminData').empty(); // Clear Admin Data View
            const hiddenPassword = '*'.repeat(10);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                dataType: "json",
                data: {
                    action: 'SearchAdmin',
                    'Type': type,
                    'txtSearch': txtSearch,
                },
                success: function(response) {
                    // console.log("Data sent:\n", response);

                    if (response.message) {
                        // Handle "No Record Found"
                        $('.AdminData').append('<tr><td colspan="6" class="text-center fw-bold ">' + response.message + '</td></tr>');
                    } else {
                        $.each(response, function(key, admin) {
                            // Start building the table row
                            let row = '<tr data-adminid="' + admin['AdminID'] + '" data-adminname="' + admin['Name'] + '" data-adminemail="' + admin['Email'] + '" data-admincontact="' + admin['Contact'] + '" data-adminpassword="' + admin['Password'] + '">' +
                                '<th scope="row">' + admin['AdminID'] + '</th>' +
                                '<td>' + admin['Name'] + '</td>' +
                                '<td>' + admin['Email'] + '</td>' +
                                '<td>' + admin['Contact'] + '</td>' +
                                '<td>' +
                                '<span class="hidden-password">' + hiddenPassword + '</span>' +
                                '<span class="actual-password d-none">' + admin['Password'] + '</span>' +
                                '<a href="#" class="toggle-password ms-2"><i class="bi bi-eye-slash"></i></a>' +
                                '</td>' +
                                '<td>' + admin['Creator'] + '</td>';

                            // Conditionally add buttons based on AdminID and status
                            if (admin['AdminID'] !== "A000" && admin['status'] == 1) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="edit-btn"  ><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="View & Edit"></i></a>' +
                                    '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactive this User"></i></a>' +
                                    '</td>';
                            }

                            // Another condition for status
                            if (admin['status'] == 0) {
                                row += '<td class="ms-auto d-flex gap-2">' +
                                    '<a href="#" class="active-btn btn btn-sm btn-outline-success pt-0 pb-0 g-2"><i class="bi bi-check2-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Active this User">Active</i></a>' +
                                    '</td>';
                            }
                            // Close the table row
                            row += '</tr>';

                            // Append the built row to the table
                            $('.AdminData').append(row);
                        });

                        // Attach click event handler to Edit buttons
                        $('.edit-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var adminID = $row.data('adminid');
                            var adminName = $row.data('adminname');
                            var email = $row.data('adminemail');
                            var contact = $row.data('admincontact');
                            var password = $row.data('adminpassword');
                            var creator = $row.data('admincreator');
                            if (adminID == "A000") {
                                showToast('Error', "Can't Edit \"A000\" Admin", 'error');
                            } else {
                                $('#EditAdminModal').modal('show');
                                // Update modal content and show the modal
                                $('#EditFormAdminID').text(adminID);
                                $('#U_name').val(adminName);
                                $('#U_email').val(email);
                                $('#U_contact').val(contact);
                                $('#U_password').val(password);

                            }
                        });

                        // Attach click event handler to delete buttons
                        $('.delete-btn').on('click', function(e) {
                            e.preventDefault();
                            var $row = $(this).closest('tr');

                            var adminID = $row.data('adminid');
                            var adminName = $row.data('adminname');
                            if (adminID == "A000") {
                                showToast('Error', "Can't Delete \"A000\" Admin", 'error');
                            } else {
                                // Update modal content and show the modal
                                $('#adminID').text('\tID    : ' + adminID);
                                $('#adminName').text('\tName  : ' + adminName);

                                $('#confirmDelete').data('adminid', adminID);
                                $('#Delete').modal('show'); // Use Bootstrap's method to show the modal
                            }

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

                        $('.active-btn').on('click', function(e) {

                        });
                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching admin data: " + status + " - " + error);
                }
            });
        }

        // Edit Admin Function
        function EditAdmin(adminID, U_name, U_email, U_contact, U_password) {
            // alert("Edit " + AdminID);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Admin.php
                data: {
                    action: 'updateAdmin',
                    'AdminID': adminID,
                    'Name':U_name,
                    'Email': U_email,
                    'Contact': U_contact,
                    'Password': U_password,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("Data sent:\n", response);

                    if (response.success) {
                        //alert("Admin Update successfully");

                        $('#EditAdminModal').modal('hide');
                        GetAdminData($('#activeStatus').val().trim()); // Refresh the admin list
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message || "Failed to Update admin", 'error');
                        if (response.message === "Email already exists.") {
                            $('#U_email_err').text('Email already exists');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Updateing admin: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }

        // Deactive Admin Function
        function ChangeStatus(AdminID, status) {
            //alert("Delete " + AdminID);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'ChangeStatusAdmin',
                    'AdminID': AdminID,
                    'Status': status,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("ID sent:\n Response : ", response);

                    if (response.success) {
                        //alert("Admin delete successfully");
                        GetAdminData($('#activeStatus').val().trim()); // Refresh the admin list
                        showToast('Success', response.message, 'success');
                    } else {
                        if ($status == 0) {
                            showToast('Error', response.message || "Failed to Deactivate admin", 'error');
                        } else {
                            showToast('Error', response.message || "Failed to Activate admin", 'error');
                        }

                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Deactivate admin: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
            
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
    </script>
</body>

</html>