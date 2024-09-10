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
    $type = $_GET['Type'];
    $admin=new Admin(); 
    $admin-> ViewAdmin($type);
    exit();
}

// Search Admin Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchAdmin') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $admin=new Admin(); 
    $admin-> Search($type,$txtSearch);
    exit();
}

// Get Admin next ID
if (isset($_GET['action']) && $_GET['action'] == 'getNextAdminID') {
    
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
    $U_name = $_POST['Name'];
    $U_email = $_POST['Email'];
    $U_contact = $_POST['Contact'];
    $U_Password = $_POST['Password'];

    $admin = new Admin();
    try {
        $result = $admin->Update($adminID,$U_name, $U_email, $U_contact, $U_Password);

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

// Deactive Admin Data
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusAdmin') {
    
    $adminID = $_POST['AdminID'];
    $status = $_POST['Status'];
    $admin = new Admin();
    try {
        $result = $admin->ChangeStatusAdmin($adminID,$status);
        if ($result) {
            if($status == 0){
                echo json_encode(['success' => true, 'message' => 'Admin Deactivate successfully']);
            }else{
                echo json_encode(['success' => true, 'message' => 'Admin Activate successfully']);
            }
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

/*----------------------------------------------------------------------------------------------------------------*/
// Get Counter Data
if (isset($_GET['action']) && $_GET['action'] == 'getCounterData') {
    
    //echo $return = "getCounterData";
    $type = $_GET['Type'];
    $counter=new Counter(); 
    $counter-> ViewCounter($type);
    exit();
}

// Search Counter Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchCounter') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $counter=new Counter(); 
    $counter-> Search($type,$txtSearch);
    exit();
}

// Get Counter next ID
if (isset($_GET['action']) && $_GET['action'] == 'getNextCounterID') {
    
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
            echo json_encode(['success' => true, 'message' => ' Counter Added successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Update Counter Data
if (isset($_POST['action']) && $_POST['action'] == 'updateCounter') {
    
    $counterID = $_POST['CounterID'];
    $U_name = $_POST['Name'];
    $U_email = $_POST['Email'];
    $U_location = $_POST['Location'];
    $U_contact = $_POST['Contact'];

    $U_Password = $_POST['Password'];

    $counter = new Counter();
    try {
        $result = $counter->Update($counterID,$U_name, $U_email, $U_contact,$U_location, $U_Password);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Counter updateed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Deactive Counter Data
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusCounter') {
    
    $counterID = $_POST['CounterID'];
    $status = $_POST['Status'];
    $counter = new Counter();
    try {
        $result = $counter->ChangeStatusCounter($counterID,$status);
        if ($result) {
            if($status == 0){
                echo json_encode(['success' => true, 'message' => 'Counter Deactivate successfully']);
            }else{
                echo json_encode(['success' => true, 'message' => 'Counter Activate successfully']);
            }
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

/*----------------------------------------------------------------------------------------------------------------*/
// Search Conductor Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchConductor') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $conductor=new Conductor(); 
    $conductor-> Search($type,$txtSearch);
    exit();
}

// Get Conductor Data
if (isset($_GET['action']) && $_GET['action'] == 'getConductorData') {
    
    //echo $return = "getConductorData";
    $type = $_GET['Type'];
    $conductor=new Conductor(); 
    $conductor-> ViewConductor($type);
    exit();
}

// Add Conductor Data
if (isset($_POST['action']) && $_POST['action'] == 'addConductor') {
    
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];

    $conductor = new Conductor();
    try {
        $result = $conductor->register($name, $password, $contact, $email);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Conductor added successfully']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Update Conductor Data
if (isset($_POST['action']) && $_POST['action'] == 'updateConductor') {
    
    $conductorID = $_POST['ConductorID'];
    $U_name = $_POST['Name'];
    $U_email = $_POST['Email'];
    $U_location = $_POST['Location'];
    $U_contact = $_POST['Contact'];

    $U_Password = $_POST['Password'];

    $conductor = new Conductor();
    try {
        $result = $conductor->Update($conductorID,$U_name, $U_email, $U_contact,$U_location, $U_Password);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Conductor updateed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Get Conductor next ID
if (isset($_GET['action']) && $_GET['action'] == 'getNextConductorID') {
    
    $conductor = new Conductor();
    $newConductorID = $conductor->generateNewConductorID();
    echo json_encode(['success' => true, 'newConductorID' => $newConductorID]);
}

// Deactive Conductor Data
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusConductor') {
    
    $conductorID = $_POST['ConductorID'];
    $status = $_POST['Status'];
    $conductor = new Conductor();
    try {
        $result = $conductor->ChangeStatusConductor($conductorID,$status);
        if ($result) {
            if($status == 0){
                echo json_encode(['success' => true, 'message' => 'Conductor Deactivate successfully']);
            }else{
                echo json_encode(['success' => true, 'message' => 'Conductor Activate successfully']);
            }
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

/*----------------------------------------------------------------------------------------------------------------*/
// Search Driver Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchDriver') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $driver=new Driver(); 
    $driver-> Search($type,$txtSearch);
    exit();
}

// Get Driver next ID
if (isset($_GET['action']) && $_GET['action'] == 'getNextDriverID') {
    
    $driver = new Driver();
    $newDriverID = $driver->generateNewDriverID();
    echo json_encode(['success' => true, 'newDriverID' => $newDriverID]);
}

// Add Driver Data
if (isset($_POST['action']) && $_POST['action'] == 'addDriver') {
    
    $name = $_POST['Name'];
    $nic = $_POST['NIC'];
    $contact = $_POST['Contact'];

    $driver = new Driver();
    try {
        $result = $driver->AddDriver($name, $nic, $contact);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Driver added successfully']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Update Driver Data
if (isset($_POST['action']) && $_POST['action'] == 'updateDriver') {
    
    $driverID = $_POST['DriverID'];
    $U_name = $_POST['Name'];
    $U_nic = $_POST['NIC'];
    $U_contact = $_POST['Contact'];

    $driver = new Driver();
    try {
        $result = $driver->Update($driverID,$U_name, $U_nic, $U_contact);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Driver updateed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Get Driver Data
if (isset($_GET['action']) && $_GET['action'] == 'getDriverData') {
    
    //echo $return = "getDriverData";
    $type = $_GET['Type'];
    $driver=new Driver(); 
    $driver-> ViewDriver($type);
    exit();
}

// Deactive Driver Data
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusDriver') {
    
    $driverID = $_POST['DriverID'];
    $status = $_POST['Status'];
    $driver = new Driver();
    try {
        $result = $driver->ChangeStatusDriver($driverID,$status);
        if ($result) {
            if($status == 0){
                echo json_encode(['success' => true, 'message' => 'Driver Deactivate successfully']);
            }else{
                echo json_encode(['success' => true, 'message' => 'Driver Activate successfully']);
            }
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}
