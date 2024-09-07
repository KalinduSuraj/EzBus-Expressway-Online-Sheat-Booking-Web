<?php
require_once __DIR__ . "/BackEnd/User.php";
require_once __DIR__ . "/BackEnd/Admin.php";
require_once __DIR__ . "/BackEnd/Counter.php";
require_once __DIR__ . "/BackEnd/Conductor.php";
require_once __DIR__ . "/BackEnd/Driver.php";

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

/*----------------------------------------------------------------------------------------------------------------*/
// Get Admin Data
if (isset($_GET['action']) && $_GET['action'] == 'getAdminData') {
    //echo $return = "getAdminData";
    $admin=new Admin(); 
    $admin-> ViewAdmin();
    exit();
}
// Get Admin next ID
if ($_GET['action'] == 'getNextAdminID') {
    $admin = new Admin();
    $newAdminID = $admin->generateNewAdminID();
    echo json_encode(['success' => true, 'newAdminID' => $newAdminID]);
}
// Add Admin Data
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

// Update Admin Data
if (isset($_POST['action']) && $_POST['action'] == 'updateAdmin') {
    $adminID = $_POST['AdminID'];
    $U_email = $_POST['Email'];
    $U_contact = $_POST['Contact'];
    $U_Password = $_POST['Password'];

    $admin = new Admin();
    try {
        $result = $admin->Update($adminID, $U_email, $U_contact, $U_Password);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Admin updateed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// delete Admin Data
if (isset($_POST['action']) && $_POST['action'] == 'deleteAdmin') {
    $adminID = $_POST['AdminID'];

    $admin = new Admin();
    try {
        $result = $admin->Delete($adminID);

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
// Get Counter Data
if (isset($_GET['action']) && $_GET['action'] == 'getCounterData') {
    //echo $return = "getCounterData";
    $counter=new Counter(); 
    $counter-> ViewCounter();
    exit();
}
// Get Counter next ID
if ($_GET['action'] == 'getNextCounterID') {
    $counter = new Counter();
    $newCounterID = $counter->generateNewCounterID();
    echo json_encode(['success' => true, 'newCounterID' => $newCounterID]);
}
// Add Counter Data
if (isset($_POST['action']) && $_POST['action'] == 'addCounter') {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $location =$_POST['Location'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];

    $counter = new Counter();
    try {
        $result = $counter->register($name, $password, $contact, $email,$location);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Admin Counter successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}
// delete Counter Data
if (isset($_POST['action']) && $_POST['action'] == 'deleteCounter') {
    $counterID = $_POST['CounterID'];

    $Counter = new Counter();
    try {
        $result = $Counter->Delete($counterID);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Counter Deleteed successfully']);
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
// Get Conductor Data
if (isset($_GET['action']) && $_GET['action'] == 'getConductorData') {
    //echo $return = "getConductorData";
    $conductor=new Conductor(); 
    $conductor-> ViewConductor();
    exit();
}
// Add Conductor Data
if (isset($_POST['action']) && $_POST['action'] == 'addConductor') {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];

    $condutor = new Conductor();
    try {
        $result = $conductor->register($name, $password, $contact, $email);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Conductor added successfully']);
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
// Add Driver Data
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