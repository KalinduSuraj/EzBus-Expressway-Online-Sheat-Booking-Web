<?php
require_once __DIR__ . "/BackEnd/User.php";
require_once __DIR__ . "/BackEnd/Admin.php";
require_once __DIR__ . "/BackEnd/Counter.php";
require_once __DIR__ . "/BackEnd/Conductor.php";
require_once __DIR__ . "/BackEnd/Driver.php";

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
// Check if this file is called directly via AJAX For Get Admin Data
if ($_GET['action'] == 'getNextAdminID') {
    $admin = new Admin();
    $newAdminID = $admin->generateNewAdminID();
    echo json_encode(['success' => true, 'newAdminID' => $newAdminID]);
}
/*----------------------------------------------------------------------------------------------------------------*/
// Check if this file is called directly via AJAX For Get Admin Data
 if (isset($_GET['action']) && $_GET['action'] == 'getAdminData') {
    //echo $return = "getAdminData";
    $admin=new Admin(); 
    $admin-> ViewAdmin();
    exit();
}
// Check if this file is called directly via AJAX For Add Admin Data
if (isset($_POST['action']) && $_POST['action'] == 'addAdmin') {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];

    $admin = new Admin();
    try {
        $result = $admin->register($name, $password, $contact, $email);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Admin added successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}
// Check if this file is called directly via AJAX For delete Admin Data
if (isset($_POST['action']) && $_POST['action'] == 'deleteAdmin') {
    $adminID = $_POST['AdminID'];

    $admin = new Admin();
    try {
        $result = $admin->delete($adminID);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Admin Deleteed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

/*----------------------------------------------------------------------------------------------------------------*/
// Check if this file is called directly via AJAX For Get Counter Data
if (isset($_GET['action']) && $_GET['action'] == 'getCounterData') {
    //echo $return = "getCounterData";
    $counter=new Counter(); 
    $counter-> ViewCounter();
    exit();
}
// Check if this file is called directly via AJAX For Add Counter Data
if (isset($_POST['action']) && $_POST['action'] == 'addCounter') {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];

    $counter = new Counter();
    $result = $counter->register($name, $password, $contact, $email);

    if ($result) {
        echo "Counter added successfully";
    } else {
        echo "Failed to add Counter";
    }

    exit();
}
/*----------------------------------------------------------------------------------------------------------------*/
// Check if this file is called directly via AJAX For Get Conductor Data
if (isset($_GET['action']) && $_GET['action'] == 'getConductorData') {
    //echo $return = "getConductorData";
    $conductor=new Conductor(); 
    $conductor-> ViewConductor();
    exit();
}
/*----------------------------------------------------------------------------------------------------------------*/
// Check if this file is called directly via AJAX For Add Driver Data
if (isset($_POST['action']) && $_POST['action'] == 'addDriver') {
    $name = $_POST['Name'];
    $contact = $_POST['Contact'];

    $driver = new Driver();
    $result = $driver->AddDriver($name, $contact);

    if ($result) {
        echo "Driver added successfully";
    } else {
        echo "Failed to add Driver";
    }

    exit();
}