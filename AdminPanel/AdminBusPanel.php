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

        html {
            overflow-x: hidden;
        }

        body {
            background: var(--grey);

        }

        a {
            text-decoration: none;
        }

        .errMsg {
            color: red;
            font-size: 13px;
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
        <h1 class="title mb-10">BUS </h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Bus</a></li>
        </ul>
    </main>
    
    <div class="row g-3 col-sm-6 p-0  ">
        <div class="col-auto">
        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#AddBusModal">
            <i class="bi bi-plus-lg"></i><span>Add New Bus</span>
        </a>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control form-control-sm" id="txtSearch" placeholder="Search">
        </div>
        <div class="col-auto">
            <input type="button" class="btn btn-primary btn-sm" id="txtSearch"  value="Search">
        </div>
    </div>


    <!-- Add Bus Form -->
    <div class="modal fade" id="AddBusModal" tabindex="-1" aria-labelledby="AddBusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" style="width: 100%; min-width: 300px;">
                    <div class="modal-header flex-column align-items-center mb-0">
                        <h5 class="modal-title" id="AddBusModalLabel">Add New Bus & Driver Details</h5>
                        <p class="text-muted text-center mb-3">Complete the form below to add a new Bus</p>
                        <div class="row mb-0 w-100 pb-0">
                            <!-- Bus Id -->
                            <div class="col text-center">
                                <b>
                                    <label class="form-label">Bus ID : </label>
                                    <label class="form-label" id="ShowBusID">B</label>
                                </b>
                            </div>

                        </div>
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="col">
                            <label class="form-label">Bus Number:</label>
                            <input type="text" class="form-control" name="BusNo" id="BusNo" placeholder="NC-0000">
                            <span class="errMsg" id="BusNo_err"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Of Sheets:</label>
                            <input type="text" class="form-control" name="NoOfSheets" id="NoOfSheets" placeholder="52">
                            <span class="errMsg" id="NoOfSheets_err"></span>
                        </div>
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-outline-danger text-dark" data-bs-dismiss="modal" onclick="clearErr()">Cancel</button>
                        <button type="button" class="btn btn-success" id="AddBus">Add Bus</button>
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
                    <h5 class="modal-title">Delete Bus</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Records</p>
                    <p class="text-warning"><small>this action Cannot be Undone,</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('Delete').style.display='none'" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('Delete').style.display='none'" id="DeleteBus">Delete</button>
                </div>
            </div>


        </div>
    </div>

    <script>
        function clearErr(){
            $('.errMsg').text('');
        }
        $(document).ready(function() {
            $('#AddBus').on('click', function(event) {
                //alert("click")
                event.preventDefault(); // Prevent the form from submitting normally
                // Clear previous error messages
                clearErr();

                var isValid = true;

                var BusNo = $('#BusNo').val().trim();
                var NoOfSheets = $('#NoOfSheets').val().trim();
                var DriverName = $('#DriverName').val().trim();
                var contact = $('#contact').val().trim();


                //Simple validation
                if (BusNo === '') {
                    $('#BusNo_err').text('Bus No is required');
                    isValid = false;
                    return;
                }
                if (NoOfSheets === '') {
                    $('#NoOfSheets_err').text('No Of Sheets is required');
                    isValid = false;
                    return;
                } else if( NoOfSheets==0 ){
                    $('#NoOfSheets_err').text("No Of Sheets Can't be a  0");
                    isValid = false;
                    return;
                }

                if (DriverName === '') {
                    $('#DriverName_err').text('Driver Name is required');
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


                if (isValid == true) {
                    alert(isValid);
                }

            });

            $('#DeleteBus').on('click', function(event) {
                alert("Delete")
            })
        })
    </script>

</body>

</html>