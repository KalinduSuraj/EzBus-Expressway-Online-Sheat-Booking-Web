<?php

use Google\Service\CloudControlsPartnerService\Console;

require_once __DIR__ . "/BackEnd/User.php";
require_once __DIR__ . "/BackEnd/Admin.php";
require_once __DIR__ . "/BackEnd/Counter.php";
require_once __DIR__ . "/BackEnd/Conductor.php";
require_once __DIR__ . "/BackEnd/Driver.php";
require_once __DIR__ . "/BackEnd/Route.php";
require_once __DIR__ . "/BackEnd/Schedule.php";
require_once __DIR__ . "/BackEnd/Bus.php";
require_once __DIR__ . "/BackEnd/Passenger.php";
require_once __DIR__ . "/BackEnd/Booking.php";
require_once __DIR__ . "/BackEnd/Mails.php";
require_once __DIR__ . "/BackEnd/Notify.php";
require_once __DIR__ . "/BackEnd/Payment.php";
require_once __DIR__ . "/BackEnd/QR.php";



ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

session_start();
define('SESSION_TIMEOUT', 900);

/*----------------------------------------------------------------------------------------------------------------*/
// Get Admin Data
if (isset($_GET['action']) && $_GET['action'] == 'getAdminData') {

    //echo $return = "getAdminData";
    $type = $_GET['Type'];
    $admin = new Admin();
    $admin->ViewAdmin($type);
    exit();
}

// Search Admin Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchAdmin') {

    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $admin = new Admin();
    $admin->Search($type, $txtSearch);
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
    $adminID = $_POST['AdminID'];

    $admin = new Admin();
    try {
        $userId = $admin->register($name, $password, $contact, $email, $adminID);

        if ($userId) {
            $mail = new Mails();
            // $notify = new Notify();
            $emailMsg = "
            <h3>Welcome, {$name}!</h3>
            <p>Your admin account has been successfully created.</p>
            <p><strong>Your Credentials:</strong></p>
            <ul>
                <li><strong>UserID  :</strong> {$userId}</li>
                <li><strong>Name    :</strong> {$name}</li>
                <li><strong>Email   :</strong> {$email}</li>
                <li><strong>Contact :</strong> {$contact}</li>
                <li><strong>Password:</strong> {$password}</li>
            </ul>
            <p>Please use these credentials to log in to the system.</p>
            <p>(This is one Time Password you can change after first time login)</p>
            <p>Best regards,<br>EzBus Admin Team</p>";

            // $smsMsg = "Welcome, {$name}!
            // Your admin account has been successfully created.

            // Your Credentials:
            // UserID   : {$userId}
            // Name     : {$name}
            // Email    : {$email}
            // Contact  : {$contact}
            // Password : {$password}

            // Please use these credentials to log in to the system.
            // (This is a one-time password; you can change it after your first login)

            // Best regards,
            // Admin Team";


            $mail->sendMail($emailMsg, $email);
            // $notify->sendMsg($smsMsg,$contact);

            ob_clean();
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
        $result = $admin->Update($adminID, $U_name, $U_email, $U_contact, $U_Password);

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
        $result = $admin->ChangeStatusAdmin($adminID, $status);
        if ($result) {
            if ($status == 0) {
                echo json_encode(['success' => true, 'message' => 'Admin Deactivate successfully']);
            } else {
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
    $counter = new Counter();
    $counter->ViewCounter($type);
    exit();
}

// Search Counter Data
if (isset($_GET['action']) && $_GET['action'] == 'SearchCounter') {

    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $counter = new Counter();
    $counter->Search($type, $txtSearch);
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
    $location = $_POST['Location'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];
    $AdminID = $_POST['AdminID'];

    $counter = new Counter();
    try {
        $userId = $counter->register($name, $password, $contact, $email, $location, $AdminID);

        if ($userId) {
            $mail = new Mails();
            // $notify = new Notify();
            $emailMsg = "
            <h3>Welcome, {$name}!</h3>
            <p>Your Counter account has been successfully created.</p>
            <p><strong>Your Credentials:</strong></p>
            <ul>
                <li><strong>UserID  :</strong> {$userId}</li>
                <li><strong>Name    :</strong> {$name}</li>
                <li><strong>Email   :</strong> {$email}</li>
                <li><strong>Contact :</strong> {$contact}</li>
                <li><strong>Password:</strong> {$password}</li>
                <li><strong>Location:</strong> {$location}</li>
            </ul>
            <p>Please use these credentials to log in to the system.</p>
            <p>(This is one Time Password you can change after first time login)</p>
            <p>Best regards,<br>EzBus Admin Team</p>";

            // $smsMsg = "Welcome, {$name}!
            // Your admin account has been successfully created.

            // Your Credentials:
            // UserID   : {$userId}
            // Name     : {$name}
            // Email    : {$email}
            // Contact  : {$contact}
            // Password : {$password}
            // Location : {$location}

            // Please use these credentials to log in to the system.
            // (This is a one-time password; you can change it after your first login)

            // Best regards,
            // Admin Team";


            $mail->sendMail($emailMsg, $email);
            // $notify->sendMsg($smsMsg,$contact);

            ob_clean();
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
        $result = $counter->Update($counterID, $U_name, $U_email, $U_contact, $U_location, $U_Password);

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
        $result = $counter->ChangeStatusCounter($counterID, $status);
        if ($result) {
            if ($status == 0) {
                echo json_encode(['success' => true, 'message' => 'Counter Deactivate successfully']);
            } else {
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

    $conductor = new Conductor();
    $conductor->Search($type, $txtSearch);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'getConductorDetails') {

    $ID = $_GET['ID'];

    $conductor = new Conductor();
    $conductor->getConductorDetails($ID);
    exit();
}

// Get Conductor Data
if (isset($_GET['action']) && $_GET['action'] == 'getConductorData') {

    //echo $return = "getConductorData";
    $type = $_GET['Type'];
    $conductor = new Conductor();
    $conductor->ViewConductor($type);
    exit();
}

// Add Conductor Data
if (isset($_POST['action']) && $_POST['action'] == 'addConductor') {

    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];
    $AdminID = $_POST['AdminID'];

    $conductor = new Conductor();
    try {
        $userID = $conductor->register($name, $password, $contact, $email, $AdminID);

        if ($userID) {
            $mail = new Mails();
            // $notify = new Notify();
            $emailMsg = "
            <h3>Welcome, {$name}!</h3>
            <p>Your Conductor account has been successfully created.</p>
            <p><strong>Your Credentials:</strong></p>
            <ul>
                <li><strong>UserID  :</strong> {$userID}</li>
                <li><strong>Name    :</strong> {$name}</li>
                <li><strong>Email   :</strong> {$email}</li>
                <li><strong>Contact :</strong> {$contact}</li>
                <li><strong>Password:</strong> {$password}</li>
            </ul>
            <p>Please use these credentials to log in to the system.</p>
            <p>(This is one Time Password you can change after first time login)</p>
            <p>Best regards,<br>EzBus Admin Team</p>";

            // $smsMsg = "Welcome, {$name}!
            // Your admin account has been successfully created.

            // Your Credentials:
            // UserID   : {$userId}
            // Name     : {$name}
            // Email    : {$email}
            // Contact  : {$contact}
            // Password : {$password}

            // Please use these credentials to log in to the system.
            // (This is a one-time password; you can change it after your first login)

            // Best regards,
            // Admin Team";


            $mail->sendMail($emailMsg, $email);
            // $notify->sendMsg($smsMsg,$contact);

            ob_clean();
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
        $result = $conductor->Update($conductorID, $U_name, $U_email, $U_contact, $U_location, $U_Password);

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
        $result = $conductor->ChangeStatusConductor($conductorID, $status);
        if ($result) {
            if ($status == 0) {
                echo json_encode(['success' => true, 'message' => 'Conductor Deactivate successfully']);
            } else {
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

    $driver = new Driver();
    $driver->Search($type, $txtSearch);
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
    $AdminID = $_POST['AdminID'];

    $driver = new Driver();
    try {
        $result = $driver->AddDriver($name, $nic, $contact, $AdminID);

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
        $result = $driver->Update($driverID, $U_name, $U_nic, $U_contact);

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
    $driver = new Driver();
    $driver->ViewDriver($type);
    exit();
}

// Deactive Driver Data
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusDriver') {

    $driverID = $_POST['DriverID'];
    $status = $_POST['Status'];
    $driver = new Driver();
    try {
        $result = $driver->ChangeStatusDriver($driverID, $status);
        if ($result) {
            if ($status == 0) {
                echo json_encode(['success' => true, 'message' => 'Driver Deactivate successfully']);
            } else {
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

    $route = new Route();
    $route->Search($type, $txtSearch);
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
    $AdminID = $_POST['AdminID'];

    $Route = new Route();
    try {
        $result = $Route->AddRoute($From, $To, $Price, $AdminID);

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
    $route = new Route();
    $route->ViewRoute($type);
    exit();
}

// Deactive Route Data
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusRoute') {

    $RouteID = $_POST['RouteID'];
    $status = $_POST['Status'];
    $Route = new Route();
    try {
        $result = $Route->ChangeStatusRoute($RouteID, $status);
        if ($result) {
            if ($status == 0) {
                echo json_encode(['success' => true, 'message' => 'Route Deactivate successfully']);
            } else {
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

    $bus = new Bus();
    $bus->Search($type, $txtSearch);
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
    $AdminID = $_POST['AdminID'];

    $Bus = new Bus();
    try {
        $result = $Bus->AddBus($BusNumber,  $NoOfSeat,  $DriverID, $ConductorID, $AdminID);

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
    $U_NoOfSeat = $_POST['U_NoOfSeat'];
    $U_DriverID = $_POST['U_DriverID'];
    $U_ConductorID = $_POST['U_ConductorID'];

    $Bus = new Bus();
    try {
        $result = $Bus->Update($BusID, $U_NoOfSeat, $U_DriverID, $U_ConductorID);

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
    $Bus = new Bus();
    $Bus->ViewBus($type);
    exit();
}

// Deactive/Active Bus 
if (isset($_POST['action']) && $_POST['action'] == 'ChangeStatusBus') {

    $BusID = $_POST['BusID'];
    $status = $_POST['Status'];
    // echo json_encode(['success' => false, 'message' => $BusID,$status]);

    $Bus = new Bus();
    try {
        $result = $Bus->ChangeStatusBus($BusID, $status);
        if ($result) {
            if ($status == 0) {
                echo json_encode(['success' => true, 'message' => 'Bus Deactivate successfully']);
            } else {
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

    $BUS = new BUS();
    $BUS->GetFreeDriver($txtSearch);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'GetFreeConductor') {

    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $BUS = new BUS();
    $BUS->GetFreeConductor($txtSearch);
    exit();
}

/*------------------------------------------------------------------------------------------------------------------*/
if (isset($_GET['action']) && $_GET['action'] == 'getScheduleData') {
    //echo $return = "getScheduleData";
    $type = $_GET['Type'];
    $Schedule = new Schedule();
    $Schedule->ViewSchedule($type);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'getNextScheduleID') {
    $Schedule = new Schedule();
    $newScheduleID = $Schedule->generateNewScheduleID();
    if ($newScheduleID) {
        echo json_encode(['success' => true, 'newScheduleID' => $newScheduleID]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to generate Schedule ID']);
    }
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'addSchedule') {

    $RouteID = $_POST['RouteID'];
    $BusID = $_POST['BusID'];
    $Date = $_POST['Date'];
    $Time = $_POST['Time'];
    $AdminID = $_POST['AdminID'];

    $Schedule = new Schedule();
    try {
        $result = $Schedule->AddSchedule($RouteID,  $BusID,  $Date, $Time, $AdminID);
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
    $status = $_POST['Type'];
    // echo json_encode(['success' => false, 'message' => $ScheduleID,$status]);

    $Schedule = new Schedule();
    try {
        $result = $Schedule->ChangeStatusSchedule($ScheduleID, $status);
        if ($result) {
            if ($status == 0) {
                echo json_encode(['success' => true, 'message' => 'Schedule Deactivate successfully']);
            } else {
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

    $Schedule = new Schedule();
    $Schedule->SearchSchedule($type, $txtSearch);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'updateSchedule') {

    $ScheduleID = $_POST['ScheduleID'];
    $U_RouteID = $_POST['U_RouteID'];
    $U_BusID = $_POST['U_BusID'];
    $U_Date = $_POST['U_Date'];
    $U_Time = $_POST['U_Time'];

    $Schedule = new Schedule();
    try {
        $result = $Schedule->UpdateSchedule($ScheduleID, $U_RouteID,  $U_BusID,  $U_Date, $U_Time);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Schedule updateed successfully']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

/*------------------------------------------------------------------------------------------------------------------*/
if (isset($_GET['action']) && $_GET['action'] == 'getPassengerData') {
    //echo $return = "getScheduleData";
    $type = $_GET['Type'];
    $Passenger = new Passenger();
    $Passenger->ViewPassenger($type);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'searchPassenger') {

    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    $Passenger = new Passenger();
    $Passenger->SearchPassenger($type, $txtSearch);
    exit();
}
/*
    if (isset($_POST['action']) && $_POST['action'] == 'PassengerLogin') {

        $ID = $_POST['ID'];
        $Password = $_POST['Password'];

        $Passenger = new Passenger();
        try{
            $result = $Passenger->login($ID, $Password);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Login Successful']);

            } else {
                echo json_encode(['success' => false, 'message' => 'Incorrect User Name or Contact']);
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }
*/

if (isset($_POST['action']) && $_POST['action'] == 'addPassenger') {

    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];

    $Passenger = new Passenger();
    try {
        $userID = $Passenger->register($name, $password, $contact, $email);

        if ($userID) {
            $mail = new Mails();
            // $notify = new Notify();
            $emailMsg = "
            <h3>Welcome, {$name}!</h3>
            <p>Your Passenger account has been successfully created.</p>
            <p><strong>Your Credentials:</strong></p>
            <ul>
                <li><strong>UserID  :</strong> {$userID}</li>
                <li><strong>Name    :</strong> {$name}</li>
                <li><strong>Email   :</strong> {$email}</li>
                <li><strong>Contact :</strong> {$contact}</li>
            </ul>
            <p>Please use these credentials to log in to the system.</p>
            <p>(This is one Time Password you can change after first time login)</p>
            <p>Best regards,<br>EzBus Admin Team</p>";

            $smsMsg = "Welcome, {$name}!
            Your admin account has been successfully created.

            Your Credentials:
            UserID: {$userID}
            Name: {$name}
            Email: {$email}
            Contact: {$contact}
            Please use these credentials to log in to the system.
            (This is a one-time password; you can change it after your first login)

            Best regards,
            Admin Team";


            $mail->sendMail($emailMsg, $email);
            // $notify->sendMsg($smsMsg,$contact);

            ob_clean();
            echo json_encode(['success' => true, 'message' => 'Regestered successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

/*------------------------------------------------------------------------------------------------------------------*/
if (isset($_GET['action']) && $_GET['action'] == 'getBookingData') {
    //echo $return = "getBookingData";
    $type = $_GET['Type'];
    $Booking = new Booking();
    $Booking->ViewBooking($type);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'searchBooking') {

    $type = $_GET['Type'];
    $txtSearch = $_GET['txtSearch'];

    try{
    $Booking = new Booking();
    $Booking->Search($type, $txtSearch);
    }catch(Exception $e){
        error_log($e->getMessage(), 3, '/Backend/error.log');

    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'getTicketDetails') {
    //echo $return = "getBookingData";
    $txtSearch = $_GET['txtSearch'];
    $Booking = new Booking();
    $Booking->getTicketDetails($txtSearch);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'ConformTicket') {

    $BookingID = $_POST['BookingID'];

    $Booking = new Booking();
    try {
        $result = $Booking->ConformBooking($BookingID);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Ticket Conformed ']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'getConductorScheduleData') {
    //echo $return = "getBookingData";
    $ID = $_GET['ID'];
    $Schedule = new Schedule();
    $Schedule->getConductorScheduleData($ID);
    exit();
}

// ---------------------------------------------------------------------------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] == 'EzBusLogin') {

    $ID = $_POST['ID'];
    $Password = $_POST['Password'];
    $UserType = $_POST['UserType'];

    $Passenger = new Passenger();
    $Admin = new Admin();
    $Counter = new Counter();
    $Conductor = new Conductor();

    try {

        $user = null; // Variable to hold user details

        switch ($UserType) {
            case "Passenger":
                $user = $Passenger->login($ID, $Password, $UserType);
                break;
            case "Admin":
                $user = $Admin->login($ID, $Password, $UserType);
                break;
            case "Counter":
                $user = $Counter->login($ID, $Password, $UserType);
                break;
            case "Conductor":
                $user = $Conductor->login($ID, $Password, $UserType);
                break;
        }

        if ($user) {
            $_SESSION['logedUser'] = $user;

            echo json_encode([
                'success' => true,
                'message' => 'Login Successful',
                'user' => $user // Send user details in the response
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect User Name or Contact']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}


if (isset($_POST['action']) && $_POST['action'] == 'changeloginPW') {
    $ID = $_POST['ID'];
    $Password = $_POST['Password'];
    $UserType = $_POST['UserType'];

    $Admin = new Admin();
    $Counter = new Counter();
    $Conductor = new Conductor();

    try {
        $result = false;

        // Switch based on user type
        switch ($UserType) {
            case "Admin":
                $result = $Admin->ChangePW($ID, $Password);
                break;
            case "Counter":
                $result = $Counter->ChangePW($ID, $Password);
                break;
            case "Conductor":
                $result = $Conductor->ChangePW($ID, $Password);
                break;
        }

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
        } else {
            throw new Exception("Failed to change password.");
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());  // Log the error for debugging
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}


// ------------------------------------------------------------------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] == 'getUserDetail') {
    //echo $return = "getBusData";
    $Email = $_POST['Email'];
    $Passenger = new Passenger();

    try {
        $user = $Passenger->getUserDetail($Email);;
        if ($user) {
            echo json_encode([
                'success' => true,
                'message' => 'user details',
                'user' => $user // Send user details in the response
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect Email ']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'changePW') {

    $ID = $_POST['ID'];
    $Password = $_POST['Password'];
    // echo json_encode(['success' => false, 'message' => $ScheduleID,$status]);

    $Passenger = new Passenger();
    try {
        $result = $Passenger->ChangePW($ID, $Password);
        if ($result) {

            echo json_encode(['success' => true, 'message' => 'Password Change successfully']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'getPassengerBookingData') {
    //echo $return = "getBookingData";
    $ID = $_GET['ID'];
    $Booking = new Booking();
    $Booking->getPassengerBookingData($ID);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'getUserInfo') {
    $ID = $_POST['ID']; // Change from 'ID' to match your frontend
    $Passenger = new Passenger();

    try {
        $user = $Passenger->getUserInfo($ID);
        if ($user) {
            echo json_encode([
                'success' => true,
                'message' => 'User details retrieved successfully',
                'data' => [
                    'PassengerID' => $user['PassengerID'], // Assuming these keys exist in the returned user array
                    'Name' => $user['Name'],
                    'Contact' => $user['Contact'],
                    'Email' => $user['Email'],
                    'Password' => $user['Password']
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'updatePassenger') {
    $passengerID = $_POST['PassengerID'];
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $password = $_POST['Password'];

    $Passenger = new Passenger();

    try {
        $result = $Passenger->updatePassengerInfo($passengerID, $name, $email, $contact, $password);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Passenger updateed successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'sendOTPEmail') {
    $otp = $_POST['OTP'];
    $email = $_POST['Email'];

    $mail = new Mails();

    try {
        $result = $mail->sendOTP($otp, $email);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'OTP sent successfully']);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error: " . $e->getMessage());
        // Return the error as a JSON response
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['logedUser'])) {
        $user = $_SESSION['logedUser'];
        $userName = $user->Name;
        $userID = $user->UserID;
        $currentTime = date('Y-m-d H:i:s');

        $logMessage = "User: $userName (ID: $userID) logged out at $currentTime\n";
        error_log($logMessage, 3, '/Backend/custom_logout.log'); 

    }
    // Destroy the session
    if (session_destroy()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Logout Successful']);
    }

    exit();
}



if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'getAll':
            getData();
            break;
        case 'getRoot':
            getRoot();
            break;
        case 'getTable':
            getTableData();
            break;
        case 'getSchedule':
            //getRoot();
            getScheduls();
            break;
        case 'getSeats':
            getBookedSeats();
            //getRoot();
            break;
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'No action specified'));
}



// -----Get From city and To city----------------------------

function getRoot()
{



    header('Content-Type: application/json'); // Ensure the response is JSON

    try {

        // Create a new BusSchedule instance and fetch data
        $Schedule = new Schedule();
        $from = $Schedule->getRoot();

        // Return the result as JSON
        //return $from;
        echo json_encode($from);
    } catch (Exception $e) {
        // Handle any exceptions and return error message
        echo json_encode(array('error' => $e->getMessage()));
    }
}

// -----------Get Shedule data using  cities -------------------

function getTableData()
{
    header('Content-Type: application/json');

    $fromCity = $_REQUEST['fromCity'];
    $toCity = $_REQUEST['toCity'];
    $date = $_REQUEST['day'];


    try {

        // Create a new Schedule instance and fetch data
        $Schedule = new Schedule();
        $TableData = $Schedule->getBusSchedules($fromCity, $toCity, $date);

        // Return the result as JSON
        //return $from;
        echo json_encode($TableData);
    } catch (Exception $e) {
        // Handle any exceptions and return error message
        echo json_encode(array('error' => $e->getMessage()));
    }
}

// ----------Get All the datafrom table-------------------------
function getData()
{


    header('Content-Type: application/json'); // Ensure the response is JSON

    $date = $_REQUEST['day'];

    try {

        // Create a new Schedule instance and fetch data
        $Schedule = new Schedule();
        $All = $Schedule->getAllSchedules($date);

        // Return the result as JSON
        //return $from;
        echo json_encode($All);
    } catch (Exception $e) {
        // Handle any exceptions and return error message
        echo json_encode(array('error' => $e->getMessage()));
    }
}

// -----------get bus schedule uusing shedule id----------------
function getScheduls()
{

    header('Content-Type: application/json'); // Ensure the response is JSON

    $schedule = isset($_REQUEST['scheduleId']) ? $_REQUEST['scheduleId'] : null;

    try {

        // Create a new Schedule instance and fetch data
        $Schedule = new Schedule();
        $All = $Schedule->getSchedulesForSeat($schedule);

        // Return the result as JSON
        //return $from;
        echo json_encode($All);
    } catch (Exception $e) {
        // Handle any exceptions and return error message
        echo json_encode(array('error' => $e->getMessage()));
    }
}

// --------for get pre booked seats------------
function getBookedSeats()
{

    header('Content-Type: application/json'); // Ensure the response is JSON

    $schedule = isset($_REQUEST['scheduleId']) ? $_REQUEST['scheduleId'] : null;

    try {
        // Create a new Schedule instance and fetch data
        $busSchedule = new Schedule();
        $from = $busSchedule->getSeats($schedule);

        // Return the result as JSON
        //return $from;
        echo json_encode($from);
    } catch (Exception $e) {
        // Handle any exceptions and return error message
        echo json_encode(array('error' => $e->getMessage()));
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'TicketPayment') {
    if (isset($_POST['Price']) && isset($_POST['scheduleID']) && isset($_POST['seatData'])) {
        $price = $_POST['Price'];
        $scheduleID = $_POST['scheduleID'];
        $seatData = $_POST['seatData'];

        $Booking = new Booking();
        $qr = new QR();
        $mail = new Mails();
        $seatsArray = explode(',', $seatData); // Assuming the seats are comma-separated

        session_start();

        $NAME = $_SESSION['logedUser']['Name'];
        $CONTACT = $_SESSION['logedUser']['Contact'];
        $EMAIL = $_SESSION['logedUser']['Email'];
        $COUNTERID = $_SESSION['logedUser']['CounterID'];
        $PASSENGERID = $_SESSION['logedUser']['PassengerID'];

        // Determine the ID to use (either CounterID or PassengerID)
        $ID = (!empty($COUNTERID)) ? $COUNTERID : $PASSENGERID;

        foreach ($seatsArray as $SEATNO) {

            $BookingID = $Booking->Create($NAME, $CONTACT, $scheduleID, $SEATNO, $ID);
            $file = $qr->generateQRCode($BookingID);
            $mail->sendTicket($EMAIL,$file);

        }
        echo json_encode(['success' => true, 'message' => 'Booking created successfully!', 'BookingID' => $BookingID]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    }
}



if ($_GET['action'] == 'checkout') {
    $seatPrice = $_GET['seatPrice']; // Get seat price from request

    // Call your checkout function
    $payment = new Payment();
    $payment->checkOut($seatPrice);
}

if (isset($_GET['action']) && $_GET['action'] == 'PaymentSucess') {
    $response = ['status' => 'success', 'message' => 'Payment Success'];
    echo json_encode($response);

    echo "<script>console.log('Payment Success: {$response['message']}');</script>";

    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'PaymentFailed') {
    $response = ['status' => 'fail', 'message' => 'Payment fail'];
    echo json_encode($response);

    // Print the message in the browser's console via a script
    echo "<script>console.log('Payment fail: {$response['message']}');</script>";
    exit();
}
