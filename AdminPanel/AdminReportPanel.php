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

        .search-results {
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
        }

        .search-item {
            padding: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .search-item:hover {
            background-color: #f0f0f0;
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
    </style>
    <title></title>
</head>

<body>
    <main class="">
        <h1 class="title mb-10">REPORT </h1>
        <ul class="list-unstyled breadcrumbs d-flex gap-2">
            <li><a href="AdminView.php">Home</a></li> <!-- ## -->
            <li class="divider">/</li> <!-- ## -->
            <li><a href="#" class="active">Report</a></li>
        </ul>
    </main>




    <!-- Toast container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts will be appended here -->
    </div>

    <script>





        function showToast(title, message, type) {
            const borderClass = type === 'success' ? 'toast-success' : 'toast-error';
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
    </script>
</body>

</html>