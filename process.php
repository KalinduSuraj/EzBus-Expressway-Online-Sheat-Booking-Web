<?php
require_once __DIR__ . "/BackEnd/User.php";
require_once __DIR__ . "/BackEnd/Admin.php";
require_once __DIR__ . "/BackEnd/Counter.php";
require_once __DIR__ . "/BackEnd/Conductor.php";

// Check if this file is called directly via AJAX For Get Admin Data
 if (isset($_GET['action']) && $_GET['action'] == 'getAdminData') {
    //echo $return = "getAdminData";
    $admin=new Admin(); 
    $admin-> ViewAdmin();
    exit();
}

// Check if this file is called directly via AJAX For Get Counter Data
if (isset($_GET['action']) && $_GET['action'] == 'getCounterData') {
    //echo $return = "getCounterData";
    $counter=new Counter(); 
    $counter-> ViewCounter();
    exit();
}

// Check if this file is called directly via AJAX For Get Conductor Data
if (isset($_GET['action']) && $_GET['action'] == 'getConductorData') {
    //echo $return = "getConductorData";
    $conductor=new Conductor(); 
    $conductor-> ViewConductor();
    exit();
}