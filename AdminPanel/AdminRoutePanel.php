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
        <h1 class="title mb-10">ROUTE</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="RouteView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Route</a></li>
        </ul>
    </main>
    <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddRouteModal">
            <i class="bi bi-plus-lg"></i><span>Add Route</span>
        </a>
        <a href="#" onclick="document.getElementById('Delete').style.display='block'" class="btn btn-danger" data-toggle="modal">
            <i class="bi bi-trash"></i><span>Delete Routes</span>
        </a>
    </div>
    <!-- 
        View Route
     -->
    <br>
    <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddScheduleModal">
            <i class="bi bi-plus-lg"></i><span>Add Schedule</span>
        </a>

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
                                    <label class="form-label" id="ShowRouteID">R00</label>
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
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddRoute">Add Route</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Schedule Form -->
    <div class="modal fade" id="AddScheduleModal" tabindex="-1" aria-labelledby="AddScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddScheduleModalLabel">Add New Schedule</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Schedule</p>
                        <div class="row mb-0 w-100 pb-0">
                            <div class="col text-center ">
                                <b>
                                    <label class="form-label">Schedule ID : </label>
                                    <label class="form-label" id="ShowScheduleID">S00</label>
                                </b>
                            </div>
                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <b>
                                    <label class="form-label">Route ID : </label>
                                    <label class="form-label" id="ShowRouteID">R00</label>
                                </b>
                        <div class="mb-3">
                            <div class="col">
                                <label class="form-label">Date :</label>
                                <input type="date" class="form-control" name="date" id="date" placeholder="">
                                <span class="errMsg" id="date_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Time :</label>
                                <input type="time" class="form-control" name="time" id="time" placeholder="">
                                <span class="errMsg" id="time_err"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" onclick="clearErr()">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddSchedule">Add Schedule</button>
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
                    <h5 class="modal-title">Delete Routes</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Records</p>
                    <p class="text-warning"><small>this action Cannot be Undone,</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('Delete').style.display='none'" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('Delete').style.display='none'" id="DeleteRoute">Delete</button>
                </div>
            </div>


        </div>
    </div>
    <script>
        function clearErr() {
            $('.errMsg').text('');
        }

        $(document).ready(function() {
            $('#AddRoute').on('click', function(event) {
                // alert("click");
                event.preventDefault(); // Prevent the form from submitting normally
                // Clear previous error messages
                clearErr();

                var isValid = true;

                var from = $('#from').val().trim();
                var to = $('#to').val().trim();


                //Simple validation
                if (from === '') {
                    $('#from_err').text('Required');
                    isValid = false;
                    return;
                }
                if (to === '') {
                    $('#to_err').text('Required');
                    isValid = false;
                    return;
                }

                if (isValid == true) {
                    alert(isValid);
                }

            });


            $('#AddSchedule').on('click', function(event) {
                // alert("click");
                event.preventDefault(); // Prevent the form from submitting normally
                // Clear previous error messages
                clearErr();

                var isValid = true;

                var date = $('#date').val().trim();
                var time = $('#time').val().trim();

                //Simple validation
                if (date === '') {
                    $('#date_err').text('Date is Required');
                    isValid = false;
                    return;
                }
                if (time === '') {
                    $('#time_err').text('Time is Required');
                    isValid = false;
                    return;
                }


                if (isValid == true) {
                    alert(isValid);
                }

            });

            $('#DeleteRoute').on('click', function(event) {
                alert("Delete")
            })
        })
    </script>
</body>

</html>