<?php
session_start(); // Start the session

// Check if the user is logged in and is a Conductor
if (isset($_SESSION['logedUser'])&& $_SESSION['logedUser']['UserType']==="Counter") {
    $userID = $_SESSION['logedUser']['CounterID'];
    $name =$_SESSION['logedUser']['Name'];
} else {
    header("Location: ./EzBusLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<button type="button" class="btn btn-primary mt-2 mb-2" id="newBooking" >New Booking</button>
    
<script>
    
    $('#newBooking').on('click', function() {
                window.location.href = './selectroot.php';
            });
</script>
</body>
</html>