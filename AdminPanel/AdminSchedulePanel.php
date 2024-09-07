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
        <h1 class="title mb-10">SCHEDULE</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="ScheduleView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Schedule</a></li>
        </ul>
    </main>
    

    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddScheduleModal">
                <i class="bi bi-plus-lg"></i><span>Add Schedule</span>
            </a>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control" id="txtSearch" placeholder="Search">
        </div>
        <div class="col-auto">
            <input type="button" class="btn btn-primary" id="txtSearch" value="Search">
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
                        <div class="mb-3">
                            <div class="col">
                                <label class="form-label">Route :</label>
                                <select type="text" class="selectpicker form-control" name="routeid" id="routeid" data-live-search="true">
                                    <option value="0">- Select Route -</option>
                                    <option value="R001"> R001 </option>
                                </select>
                                <!-- <input type="date" class="form-control" name="date" id="date" placeholder=""> -->
                                <span class="errMsg" id="route_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Bus :</label>
                                <select type="text" class="selectpicker form-control" name="busid" id="busid" data-live-search="true">
                                    <option value="0">- Select Bus -</option>
                                    <option value="B001"> B001 </option>

                                </select>
                                <!-- <input type="date" class="form-control" name="date" id="date" placeholder=""> -->
                                <span class="errMsg" id="bus_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Date :</label>
                                <input type="date" class="form-control" name="date" id="date" placeholder="">
                                <span class="errMsg" id="date_err"></span>
                            </div>
                            <div class="col">
                                <label class="form-label">Time :</label>
                                <input type="time" class="form-control" name="time" id="time" value="00:00">
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
                    <h5 class="modal-title">Delete Employees</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Records</p>
                    <p class="text-warning"><small>this action Cannot be Undone,</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('Delete').style.display='none'" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('Delete').style.display='none'" id="DeleteSchedule">Delete</button>
                </div>
            </div>


        </div>
    </div>
    <script>
        $(document).ready(function() {
            //Set Date Limit For Schedule
            setDateLimit();

            $('#AddSchedule').click(function(e) {
                e.preventDefault();

            });

            $('#DeleteSchedule').on('click', function(event) {
                alert("Delete")
            })
        })

        //Set Date Limit Function
        function setDateLimit() {
            // Get today's date
            const today = new Date();

            // Format date as YYYY-MM-DD
            const minDate = today.toISOString().split('T')[0];

            // Calculate date 7 days from today
            const futureDate = new Date();
            futureDate.setDate(today.getDate() + 7);
            const maxDate = futureDate.toISOString().split('T')[0];

            // Set the min and max attributes of the date input
            const dateInput = document.getElementById('date');
            dateInput.setAttribute('min', minDate);
            dateInput.setAttribute('max', maxDate);
        }
    </script>

</body>

</html>