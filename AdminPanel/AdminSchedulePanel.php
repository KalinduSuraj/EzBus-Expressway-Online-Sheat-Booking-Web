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
        <h1 class="title mb-10">SCHEDULE</h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="ScheduleView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Schedule</a></li>
        </ul>
    </main>
    <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
        <a href="#" onclick="document.getElementById('Delete').style.display='block'" class="btn btn-danger" data-toggle="modal">
            <i class="bi bi-trash"></i><span>Delete Schedule</span>
        </a>
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
            $('#DeleteSchedule').on('click', function(event) {
                alert("Delete")
            })
        })
    </script>

</body>

</html>