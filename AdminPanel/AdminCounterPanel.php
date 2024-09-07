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
        <h1 class="title mb-10">COUNTER LOGIN DETAILS</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Users / Counter</a></li>
        </ul>
    </main>
    
    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddCounterModal" id="AddCounterModelButton">
                <i class="bi bi-plus-lg"></i><span>Add New Counter</span>
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
        <table class="table table-hover table-striped " border="1.5" id="CounterViewTable">
            <thead>
                <tr class="table-success ">
                    <th scope="col">#</th>
                    <th scope="col">Location</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Password</th>
                    <th scope="col">Creator</th>
                    <th width="" class=""></th>
                </tr>
            </thead>
            <tbody class="CounterData">

                <!-- 
                View Counter Data
             -->

            </tbody>
    </div>

    <!-- Toast container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts will be appended here -->
    </div>

    <!-- Add Counter Form -->
    <div class="modal fade" id="AddCounterModal" tabindex="-1" aria-labelledby="AddCounterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddCounterModalLabel">Add New Counter</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Counter</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Counter ID : </label>
                                    <label class="form-label" id="ShowCounterID"><!-- Show Counter ID --></label>
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
                            <label class="form-label">Location:</label>
                            <input type="text" class="form-control" name="location" id="location" placeholder="Galle">
                            <span class="errMsg" id="location_err"></span>
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
                        <button type="button" class="btn btn-success" id="AddCounter">Add Counter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Counter Form Modal -->
    <div class="modal fade" id="EditCounterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditCounterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down ">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-center mb-0">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    <h5 class="modal-title" id="EditCounterModalLabel">Update Counter Details</h5>
                    <div class="row mb-0 w-100 pb-0">
                        <div class="col text-center">
                            <b>
                                <label class="form-label">Counter ID: </label>
                                <label class="form-label" id="EditFormCounterID"><!-- Show CounterID --></label>
                            </b>
                        </div>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="col">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control" name="U_name" id="U_name" placeholder="Kalindu" disabled>
                        <span class="errMsg" id="U_name_err"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control" name="U_email" id="U_email" placeholder="name@example.com">
                        <span class="errMsg" id="U_email_err"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact No:</label>
                        <input type="text" class="form-control" name="U_contact" id="U_contact" placeholder="07X XXXX XXX">
                        <span class="errMsg" id="U_contact_err"></span>
                    </div>
                    <div class="col">
                        <label class="form-label">Location:</label>
                        <input type="text" class="form-control" name="U_location" id="U_location" placeholder="Galle">
                        <span class="errMsg" id="U_location_err"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Create Password:</label>
                        <input type="text" class="form-control mb-2" name="U_password" id="U_password" placeholder="Update Password">
                        <span class="errMsg" id="U_password_err"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="UpdateCounter">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="DeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title" id="DeleteLabel">Delete Counter</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <p>Are you sure you want to delete this Counter?</p>
                    <div class="ml-5">
                        <b>

                            <label id="counterID"></label><br>
                            <label id="counterName"></label>
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
            GetCounterData();
        })
        $('#AddCounterModelButton').on('click', function(event) {
            GetCounterID();
        });

        $('#AddCounter').on('click', function(event) {
            //alert("click");
            event.preventDefault(); // Prevent the form from submitting normally
            var first_name = $('#first_name').val().trim();
            var last_name = $('#last_name').val().trim();
            var email = $('#email').val().trim();
            var contact = $('#contact').val().trim();
            var new_password = $('#new_password').val().trim();
            var confirm_password = $('#confirm_password').val().trim();
            var location = $('#location').val().trim();

            var isValid = AddCounterValidation(first_name, last_name, email, contact, location, new_password, confirm_password)
            if (isValid == true) {

                var name = first_name + " " + last_name;
                var result = AddCounter(name, email, contact, location, new_password);
            } else {
                console.log("Check Your Details");
            }

        });

        $('#confirmDelete').on('click', function(event) {
            var counterID = $(this).data('counterid');
            DeleteCounter(counterID); //Delete Counter
        })

        // clear errMsg Function
        function clearErr() {
            $('.errMsg').text('');
        }

        //Add Counter Validation Function
        function AddCounterValidation(first_name, last_name, email, contact, location, new_password, confirm_password) {
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
                if (location === '') {
                    $('#location_err').text('Location is required');
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

        //Add Counter Data
        function AddCounter(name, email, contact, location, new_password) {
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Admin.php
                data: {
                    action: 'addCounter',
                    'Name': name,
                    'Email': email,
                    'Contact': contact,
                    'Password': new_password,
                    'Location': location,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Data sent:\n", response);
                    // console.log("status:", response.success);
                    if (response.success) {
                        //alert("Admin added successfully");
                        // console.log("Data sent 1");
                        $('#AddCounterModal').modal('hide');
                        //Clear Add Counter Form
                        $('#first_name').val('');
                        $('#last_name').val('');
                        $('#email').val('');
                        $('#contact').val('');
                        $('#location').val('');
                        $('#new_password').val('');
                        $('#confirm_password').val('');
                        // console.log("Data sent 2");
                        GetCounterData(); // Refresh the admin list
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message, 'error');
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

        // Delete Counter Function
        function DeleteCounter(CounterID) {
            // alert("Delete " + counterID);
            $.ajax({
                type: "POST",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Admin.php
                data: {
                    action: 'deleteCounter',
                    'CounterID': CounterID,
                },
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    console.log("ID sent:\n", response);

                    if (response.success) {
                        //alert("Counter delete successfully");
                        GetCounterData(); // Refresh the Counter list
                        showToast('Success', response.message, 'success');
                    } else {
                        showToast('Error', response.message || "Failed to Delete Counter", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error Delete Counter: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
            $('#Delete').modal('hide');
        }

        //Get Counter Data
        function GetCounterData() {
            $('.CounterData').empty(); //Clear Conductor Data View
            const hiddenPassword = '*'.repeat(8);
            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php", // Correct URL to Counter.php
                data: {
                    action: 'getCounterData'
                },
                dataType: 'json',
                success: function(response) {
                    // console.log("Data received:\n", response);

                    $.each(response, function(key, counter) {
                        // console.log(counter['CounterID']);

                        $('.CounterData').append(
                            '<tr data-counterid="' + counter['CounterID'] + '" data-counterlocation="' + counter['Location'] + '" data-countername="' + counter['Name'] + '" data-counteremail="' + counter['Email'] + '" data-countercontact="' + counter['Contact'] + '" data-counterpassword="' + counter['Password'] + '">' +
                            '<th scope="row">' + counter['CounterID'] + '</th>' +
                            '<td>' + counter['Location'] + '</td>' +
                            '<td>' + counter['Name'] + '</td>' +
                            '<td>' + counter['Email'] + '</td>' +
                            '<td>' + counter['Contact'] + '</td>' +
                            '<td>' +
                            '<span class="hidden-password">' + hiddenPassword + '</span>' +
                            '<span class="actual-password d-none">' + counter['Password'] + '</span>' +
                            '<a href="#" class="toggle-password ms-2"><i class="bi bi-eye-slash"></i></a>' +
                            '</td>' +
                            '<td>' + counter['AdminID'] + '</td>' +
                            '<td class="ms-auto d-flex gap-2">' +
                            '<a href="#" class="edit-btn"><i class="bi bi-pencil-square btn btn-sm btn-outline-success pt-0 pb-0"></i></a>' +
                            '<a href="#" class="delete-btn"><i class="bi bi-trash btn btn-sm btn-outline-danger pt-0 pb-0"></i></a>' +
                            '</td>' +
                            '</tr>'
                        )
                    });

                    // Attach click event handler to Edit buttons
                    $('.edit-btn').on('click', function(e) {
                        e.preventDefault();
                        var $row = $(this).closest('tr');

                        var counterID = $row.data('counterid');
                        var CLocation = $row.data('counterlocation');
                        var CName = $row.data('countername');
                        var CEmail = $row.data('counteremail');
                        var CContact = $row.data('countercontact');
                        var CPassword = $row.data('counterpassword');

                        // console.log(counterID, CLocation, CName, CEmail, CContact, CPassword);

                        $('#EditCounterModal').modal('show');
                        // Update modal content and show the modal
                        $('#EditFormCounterID').text(counterID);
                        $('#U_name').val(CName);
                        $('#U_location').val(CLocation);
                        $('#U_email').val(CEmail);
                        $('#U_contact').val(CContact);
                        $('#U_password').val(CPassword);

                    });

                    // Attach click event handler to delete buttons
                    $('.delete-btn').on('click', function(e) {
                        e.preventDefault();
                        var $row = $(this).closest('tr');

                        var counterID = $row.data('counterid');
                        var counterName = $row.data('countername');

                        // Delete modal content and show the modal
                        $('#counterID').text('\tID    : ' + counterID);
                        $('#counterName').text('\tName  : ' + counterName);

                        $('#confirmDelete').data('counterid', counterID);
                        $('#Delete').modal('show'); // Use Bootstrap's method to show the modal


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
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching admin data: " + status + " - " + error);
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
                delay: 5000
            }).show();
        }

        // Fetch the new Counter ID
        function GetCounterID() {

            $.ajax({
                type: "GET",
                url: "http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php",
                data: {
                    action: 'getNextCounterID'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.newCounterID);
                    if (response.success) {
                        // Update the Counter ID in the modal
                        $('#ShowCounterID').text(response.newCounterID);
                    } else {
                        showToast('Error', response.message || "Failed to fetch new Counter ID", 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching new Counter ID: " + status + " - " + error);
                    showToast('Error', "An error occurred: " + status + " - " + error, 'error');
                }
            });
        }
    </script>

</body>

</html>