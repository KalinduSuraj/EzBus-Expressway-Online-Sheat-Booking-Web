<?php
require_once __DIR__ . "/BackEnd/User.php";
require_once __DIR__ . "/BackEnd/Admin.php";
require_once __DIR__ . "/BackEnd/Counter.php";
require_once __DIR__ . "/BackEnd/Conductor.php";
require_once __DIR__ . "/BackEnd/Driver.php";
require_once __DIR__ . "/BackEnd/Route.php";
require_once __DIR__ . "/BackEnd/Schedule.php";
require_once __DIR__ . "/BackEnd/Bus.php";

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

/*------------------------------------------------------------------------------------------------------------------*/
// Search Route Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchRoute') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $route=new Route(); 
    $route-> Search($type,$txtSearch);
    exit();
}

// Get Route next ID
if (isset($_GET['action']) && $_GET['action'] == 'getNextRouteID') {
    
    $route = new Route();
    $newRouteID = $route->generateNewRouteID();
    echo json_encode(['success' => true, 'newRouteID' => $newRouteID]);
}

// Add Route Data
if (isset($_POST['action']) && $_POST['action'] == 'addRoute') {
    
    $From = $_POST['From'];
    $To = $_POST['To'];
    $Price = $_POST['Price'];

    $Route = new Route();
    try {
        $result = $Route->AddRoute($From, $To, $Price);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Route added successfully']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Update Route Data
if (isset($_POST['action']) && $_POST['action'] == 'updateRoute') {
    
    $RouteID = $_POST['RouteID'];
    $U_Price = $_POST['Price'];

    $Route = new Route();
    try {
        $result = $Route->Update($RouteID, $U_Price);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Route updateed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Get Route Data
if (isset($_GET['action']) && $_GET['action'] == 'getRouteData') {
    
    //echo $return = "getRouteData";
    $type = $_GET['Type'];
    $route=new Route(); 
    $route-> ViewRoute($type);
    exit();
}

// Deactive Route Data
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusRoute') {
    
    $RouteID = $_POST['RouteID'];
    $status = $_POST['Status'];
    $Route = new Route();
    try {
        $result = $Route->ChangeStatusRoute($RouteID,$status);
        if ($result) {
            if($status == 0){
                echo json_encode(['success' => true, 'message' => 'Route Deactivate successfully']);
            }else{
                echo json_encode(['success' => true, 'message' => 'Route Activate successfully']);
            }
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

/*------------------------------------------------------------------------------------------------------------------*/
// Search Bus Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchBus') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];
    
    $bus=new Bus(); 
    $bus-> Search($type,$txtSearch);
    exit();
}

// Get Bus next ID
if (isset($_GET['action']) && $_GET['action'] == 'getNextBusID') {
    
    $bus = new Bus();
    $newBusID = $bus->generateNewBusID();
    echo json_encode(['success' => true, 'newBusID' => $newBusID]);
}

// Add Bus Data
if (isset($_POST['action']) && $_POST['action'] == 'addBus') {
    
    $BusNumber = $_POST['BusNumber'];
    $NoOfSeat = $_POST['NoOfSeat'];
    $DriverID = $_POST['DriverID'];
    $ConductorID = $_POST['ConductorID'];

    $Bus = new Bus();
    try {
        $result = $Bus->AddBus( $BusNumber,  $NoOfSeat,  $DriverID, $ConductorID);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Bus added successfully']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Update Bus Data
if (isset($_POST['action']) && $_POST['action'] == 'updateBus') {
    
    $BusID = $_POST['BusID'];
    $U_NoOfSeat= $_POST['U_NoOfSeat'];
    $U_DriverID = $_POST['U_DriverID'];
    $U_ConductorID = $_POST['U_ConductorID'];

    $Bus = new Bus();
    try {
        $result = $Bus->Update( $BusID, $U_NoOfSeat, $U_DriverID , $U_ConductorID);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Bus updateed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

// Get Bus Data
if (isset($_GET['action']) && $_GET['action'] == 'getBusData') {
    //echo $return = "getBusData";
    $type = $_GET['Type'];
    $Bus=new Bus(); 
    $Bus-> ViewBus($type);
    exit();
}

// Deactive/Active Bus 
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusBus') {
    
    $BusID = $_POST['BusID'];
    $status = $_POST['Status'];
    // echo json_encode(['success' => false, 'message' => $BusID,$status]);

    $Bus = new Bus();
    try {
        $result = $Bus->ChangeStatusBus($BusID,$status);
        if ($result) {
            if($status == 0){
                echo json_encode(['success' => true, 'message' => 'Bus Deactivate successfully']);
            }else{
                echo json_encode(['success' => true, 'message' => 'Bus Activate successfully']);
            }
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'GetFreeDriver') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $BUS=new BUS(); 
    $BUS-> GetFreeDriver($txtSearch);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'GetFreeConductor') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];
    
    $BUS=new BUS(); 
    $BUS-> GetFreeConductor($txtSearch);
    exit();
}

/*------------------------------------------------------------------------------------------------------------------*/
if (isset($_GET['action']) && $_GET['action'] == 'getScheduleData') {
    //echo $return = "getScheduleData";
    $type = $_GET['Type'];
    $Schedule=new Schedule(); 
    $Schedule-> ViewSchedule($type);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'getNextScheduleID') {
    $Schedule = new Schedule();
    $newScheduleID = $Schedule->generateNewScheduleID();
    echo json_encode(['success' => true, 'newScheduleID' => $newScheduleID]);
}

if (isset($_POST['action']) && $_POST['action'] == 'addSchedule') {
    
    $RouteID = $_POST['RouteID'];
    $BusID = $_POST['BusID'];
    $Date = $_POST['Date'];
    $Time = $_POST['Time'];

    $Schedule = new Schedule();
    try {
        $result = $Schedule->AddSchedule( $RouteID,  $BusID,  $Date, $Time);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Bus added successfully']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusSchedule') {
    
    $ScheduleID = $_POST['ScheduleID'];
    $status = $_POST['Status'];
    // echo json_encode(['success' => false, 'message' => $ScheduleID,$status]);

    $Schedule = new Schedule();
    try {
        $result = $Schedule->ChangeStatusSchedule($ScheduleID,$status);
        if ($result) {
            if($status == 0){
                echo json_encode(['success' => true, 'message' => 'Schedule Deactivate successfully']);
            }else{
                echo json_encode(['success' => true, 'message' => 'Schedule Activate successfully']);
            }
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'SearchSchedule') {
    
    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];
    
    $Schedule=new Schedule(); 
    $Schedule-> Search($type,$txtSearch);
    exit();
}





























