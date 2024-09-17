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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

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
        .overflow {
            overflow-y: auto;
            scrollbar-width: none;
        }
    </style>
    <title></title>
</head>

<body class="">
    <main class="">
        <h1 class="title mb-10">PROFILE</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Profile</a></li>
        </ul>
    </main>

    <div class="container overflow">
        <form action="" method="post" style="width: 100%; min-width: 300px;">
            <div class="modal-header flex-column align-items-center">

                <div class="row  w-100 ">
                    <b>
                        <div class="col text-center">
                            <label class="form-label mx-2">Admin ID : </label>
                            <label class="form-label" id="ShowAdminID">A001</label>
                        </div>
                    </b>

                </div>
            </div>

            <div class="modal-body ">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Full Name:</label>
                        <input type="text" class="form-control form-control-md" name="full_name" id="full_name" placeholder="Kalindu Suraj">
                        <span class="errMsg" id="full_name_err"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control form-control-md" name="email" id="email" placeholder="name@example.com">
                    <span class="errMsg" id="email_err"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact No :</label>
                    <input type="text" class="form-control form-control-md" name="contact" id="contact" placeholder="07X XXXX XXX">
                    <span class="errMsg" id="contact_err"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password :</label>
                    <input type="password" class="form-control form-control-md" name="password" id="password" placeholder="Password">
                    <span class="errMsg" id="password_err"></span>

                </div>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="editButton">Edit</button>
                <button type="button" class="btn btn-success" id="updateButton">Update</button>
            </div>
        </form>
    </div>

    <script>
        function clearErr() {
            $('.errMsg').text('');
        }

        $(document).ready(function() {

            document.getElementById("full_name").disable = true;

            $('#updateButton').on('click', function(event) {
                alert("click");
                event.preventDefault(); // Prevent the form from submitting normally
                // Clear previous error messages
                clearErr();

                var isValid = true;

                var full_name = $('#full_name').val().trim();
                var email = $('#email').val().trim();
                var contact = $('#contact').val().trim();
                var password = $('#password').val().trim();

                //Simple validation
                if (full_name === '') {
                    $('#full_name_err').text('Name is required');
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

                if (isValid == true) {
                    alert(isValid);
                }

            });

            $('#editButton').on('click', function(event) {
                alert("click");
                document.getElementById("full_name").disable = false;

            })

        })
    </script>
</body>

</html>