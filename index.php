<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Style Sheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend Deca:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Livvic:wght@100;700&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lohit Tamil:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Viga:wght@400&display=swap" />


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Bootstrap Bundle JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        
    </style>
    <title>EzBus</title>
</head>
<!------------------------------------------------------------------------------>

<body data-spy="scroll" data-target="#navbarResponsive" >
    <!-- Star Home Section -->
    <div id="Home">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top ">
            <div class="container">
                <a class="navbar-logo " href="index.php"><img src="src/" alt="Logo"></a> <!-- Add logo -->
                <button class="navbar-toggler justify-content-end" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto ">
                        <li class="nav-item">
                            <a class="nav-link " href="#Home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#Booking">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#About">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#Contact">Contact</a>
                        </li>
                    </ul>
                </div>
                <a class="text-decoration-none text-light" href=""><button class="SignIn-btn text-light" type="button" id="SignIn" >Sign In</button></a>
            </div>
        </nav>
        <!-- End Navigation -->

    </div>
    <!-- End Home Section -->

    <!-- Star Booking Section -->
    <div id="Booking" class="offset">

    </div>
    <!-- End Booking Section -->

    <!-- Star About Section -->
    <div id="About" class="offset">

    </div>
    <!-- End About Section -->

    <!-- Star Contact Section -->
    <div id="Contact" class="offset">

    </div>
    <!-- End Contact Section -->



    <!-- Placeholder for the Signin modal -->
    <div id="SigninmodalContainer"></div>


    <script>
    $(document).ready(function() {
      $('#SignIn').click(function(event) {
        // alert("SignIn");
        event.preventDefault();
        $('#SigninmodalContainer').load('SignInSignUpModel.php', function() {
          $('#SignInModal').modal('show');
        });
      });
    });
  </script>
</body>

</html>