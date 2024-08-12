<?php
require_once '../../vendor/autoload.php';
require_once '../../Backend/User.php';
require_once '../../Backend/Passenger.php';
session_start(); // Start a session to manage state

// Create an instance of the User class
$user = new Passenger();

// Call the method to handle Google login
$user->GoogleAuthentication('login');

