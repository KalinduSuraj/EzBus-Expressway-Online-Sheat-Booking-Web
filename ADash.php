<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/custom.css">
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Bootstrap Bundle JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Profile */
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Full-width input fields */
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Set a style for all buttons */
        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        /* Extra styles for the cancel button */
        .Closebtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            padding-top: 60px;
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto;
            /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
        }

        /* The Close Button (x) */
        .close {
            position: absolute;
            right: 25px;
            top: 0;
            color: #000;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }

        /* Add Zoom Animation */
        .animate {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes animatezoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }
    </style>

    <title>Admin Dashvoard</title>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>

        <!-- Sidebar Design Start -->
        <div id="sidebar">
            <div class="sidebar-header">
                <h3><img src="" alt="Logo" class="img-fluid"><span>EzBus</span></h3>
            </div>
            <ul class="list-unstyled component m-0">
                <!-- Dashboard -->
                <li class="active">
                    <a href="#" class="dashboard"><i class="bi bi-columns-gap"></i>Dashboard</a>
                </li>
                <!-- Users -->
                <li class="dropdown">
                    <a href="#UsersMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="bi bi-person"></i>Users
                    </a>

                    <ul class=" collapse list-unstyled menu " id="UsersMenu">
                        <li><a href="#">Admin</a></li>
                        <li><a href="#">Counter</a></li>
                        <li><a href="#">Counductor</a></li>
                    </ul>

                </li>
                <!-- Route -->
                <li class="">
                    <a href="#" class=""><i class="bi bi-geo-alt"></i>Routes </a>
                </li>
                <!-- Buss -->
                <li class="">
                    <a href="#" class=""><i class="bi bi-bus-front-fill"></i></i>Buses </a>
                </li>
                <!-- Reports -->
                <li class="">
                    <a href="#" class=""><i class="bi bi-file-earmark-text"></i></i>Reports </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar Design Start -->

        <!-- Page Content Start -->
        <div id="content">
            <!-- top navbar start -->
            <div class="top-navbar">
                <div class="xd-topbar">
                    <div class="row">
                        <div class="col-2 col-md-1 col-lg-2 order-2 order-md-1 align-self-center">
                            <div class="xp-menubar">
                                <i class="bi bi-list"></i>
                            </div>
                        </div>

                        <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
                            <div class="xp-profilebar text-right">
                                <nav class="navbar p-0">
                                    <ul class="nav navbar-nav flex-row d-flex justify-content-end">
                                        <li>
                                            <a class="btn " data-bs-toggle="collapse" href="#collapseExample"  aria-expanded="false" aria-controls="collapseExample">
                                            <img src="src/profile .png" alt="DP" style="width: 35px; height:35px; border-radius:50%;" />
                                            </a>
                                            <div class="collapse" id="collapseExample">
                                                <ul class="">
                                                <li>
                                                    <a href="#" onclick="document.getElementById('ViewProfile').style.display='block'">
                                                        <i class="bi bi-person-circle"></i>Profile
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="bi bi-box-arrow-left"></i>Logout</a>
                                                </li>
                                                </ul>
                                            </div>

                                        </li>

                                        <!-- 
                                        <li class="dropdown nav-item">
                                            <a href="#ProfileMenu" class="nav-link" data-bs-toggle="dropdown">
                                                <img src="src/profile .png" alt="DP" style="width: 35px; height:35px; border-radius:50%;" />
                                                
                                            </a>
                                            <ul class="dropdown-menu small-menu" id="ProfileMenu">
                                                <li>
                                                    <a href="#" onclick="document.getElementById('ViewProfile').style.display='block'">
                                                        <i class="bi bi-person-circle"></i>Profile
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="bi bi-box-arrow-left"></i>Logout</a>
                                                </li>
                                            </ul>
                                        </li>
                                         -->


                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="xp-breadcrumbbar text-center">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>

            </div>
            <!-- top navbar end -->

            <!------main-content-start----------->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrapper">

                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                                        <h2 class="ml-lg-2">Manage Employees</h2>
                                    </div>
                                    <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                                        <a href="#" onclick="document.getElementById('AddAdmin').style.display='block'" class="btn btn-success" data-toggle="modal">
                                            <i class="bi bi-plus-lg"></i><span>Add New Employees</span>
                                        </a>
                                        <a href="#" onclick="document.getElementById('Delete').style.display='block'" class="btn btn-danger" data-toggle="modal">
                                            <i class="bi bi-trash"></i><span>Delete Employees</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><span class="custom-checkbox">
                                                <input type="checkbox" id="selectAll">
                                                <label for="selectAll"></label></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!----footer-design------------->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="footer-in">
                        <p class="mb-0">&copy 2024 EzBus. All Rights Reserved.</p>
                    </div>
                </div>
            </footer>

        </div>
        <!-- Page Content Close -->

    </div>

    <!-- View Profile -->
    <div id="ViewProfile" class="modal">

        <form class="modal-content animate" action="" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('ViewProfile').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" class="form-control form-control-md" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" class="form-control form-control-md" name="psw" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" class="form-control form-control-md" name="psw" required>


            </div>

            <div class="container d-flex" style="background-color:#f1f1f1">
                <div class="container d-flex" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('ViewProfile').style.display='none'" class="btn btn-danger btn-sm btn-block  Closebtn">Close</button>
                </div>
                <div class="container d-flex" style="background-color:#f1f1f1">
                    <button type="submit" class="btn btn-primary btn-sm btn-block btn-signUp">Edit</button>
                </div>
                <div class="container d-flex" style="background-color:#f1f1f1">
                    <button type="submit" class="btn btn-success btn-sm btn-block btn-signUp">Save</button>
                </div>
            </div>

        </form>
    </div>
    <!-- Add Admin Form -->
    <div id="AddAdmin" class="modal">

        <form class="modal-content animate" action="" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('AddAdmin').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" class="form-control form-control-md" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" class="form-control form-control-md" name="psw" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" class="form-control form-control-md" name="psw" required>


            </div>

            <div class="container d-flex" style="background-color:#f1f1f1">
                <div class="container d-flex" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('AddAdmin').style.display='none'" class="btn btn-danger btn-sm btn-block  Closebtn">Close</button>
                </div>
                <div class="container d-flex" style="background-color:#f1f1f1">
                    <button type="submit" class="btn btn-primary btn-sm btn-block btn-signUp">Edit</button>
                </div>
                <div class="container d-flex" style="background-color:#f1f1f1">
                    <button type="submit" class="btn btn-success btn-sm btn-block btn-signUp">Save</button>
                </div>
            </div>

        </form>
    </div>

    <!----delete-modal start--------->
    <div class="modal " tabindex="-1" id="Delete" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Employees</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Records</p>
                    <p class="text-warning"><small>this action Cannot be Undone,</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('Delete').style.display='none'" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('Delete').style.display='none'">Delete</button>
                </div>
            </div>


        </div>
    </div>



    <script>
        /*
        // Get the modal
        var modal = document.getElementById('ViewProfile');

        // When the user clicks anywhere outside of the modal, close it
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        */
    </script>

</body>

</html>