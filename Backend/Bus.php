<?php
require_once __DIR__ . "/DBConnection.php";

class Bus
{
    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    //Generate New BUS ID
    public function generateNewBusID()
    {
        $conn = $this->db->getConnection();
        try {
            // get the last  BusID
            $query = "SELECT BusID FROM bus ORDER BY BusID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['BusID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1));
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'B' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'B001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new Bus ID: " . $e->getMessage();
            return null;
        }
    }

    //Add Bus
    public function AddBus(string $BusNumber, string $NoOfSeat, string $DriverID, string $ConductorID,string $AdminID)
    {
        $con = $this->db->getConnection();
        try {
            mysqli_begin_transaction($con);

            $BusID = $this->generateNewBusID();
            if (!$BusID) {
                throw new Exception("Failed to generate a new Bus ID.");
            }

            $checkBusNoQuery = "SELECT BusNumber FROM Bus WHERE BusNumber = ?";
            $stmt = $con->prepare($checkBusNoQuery);
            $stmt->bind_param("s", $BusNumber);
            $stmt->execute();
            $resultBusNo = $stmt->get_result();
            if ($resultBusNo->num_rows > 0) {
                throw new Exception("Bus already exists.");
            }
            $stmt->close();

            $checkDriverQuery = "SELECT DriverID FROM driver WHERE DriverID = ?";
            $stmt = $con->prepare($checkDriverQuery);
            $stmt->bind_param("s", $DriverID);
            $stmt->execute();
            $resultDriver = $stmt->get_result();
            if ($resultDriver->num_rows == 0) {
                throw new Exception("Can't Find This Driver.");
            }
            $stmt->close();

            $checkDriverQuery = "SELECT DriverID FROM bus WHERE DriverID = ?";
            $stmt = $con->prepare($checkDriverQuery);
            $stmt->bind_param("s", $DriverID);
            $stmt->execute();
            $resultDriver = $stmt->get_result();
            if ($resultDriver->num_rows > 0) {
                throw new Exception("This Driver already asign.");
            }
            $stmt->close();

            $checkConductorQuery = "SELECT ConductorID FROM conductor WHERE ConductorID = ?";
            $stmt = $con->prepare($checkConductorQuery);
            $stmt->bind_param("s", $ConductorID);
            $stmt->execute();
            $resultConductor = $stmt->get_result();
            if ($resultConductor->num_rows == 0) {
                throw new Exception("Can't Find This Conductor.");
            }
            $stmt->close();

            $checkConductorQuery = "SELECT ConductorID FROM bus WHERE ConductorID = ?";
            $stmt = $con->prepare($checkConductorQuery);
            $stmt->bind_param("s", $ConductorID);
            $stmt->execute();
            $resultConductor = $stmt->get_result();
            if ($resultConductor->num_rows > 0) {
                throw new Exception("This Conductor already asign.");
            }
            $stmt->close();

            // Insert queries
            $query1 = "INSERT INTO Bus(BusID, BusNumber,NoOfSeat,DriverID,ConductorID,AdminID) VALUES(?,?,?,?,?,?)";
            $stmt = $con->prepare($query1);
            $stmt->bind_param("ssssss", $BusID, $BusNumber, $NoOfSeat, $DriverID, $ConductorID, $AdminID);
            if (!$stmt->execute()) {
                throw new Exception("Failed to insert into Bus: " . $stmt->error);
            }
            $stmt->close();

            $query2 = "UPDATE driver SET AsignStatus = 1 WHERE DriverID = ? ";
            $stmt = $con->prepare($query2);
            $stmt->bind_param("s", $DriverID);
            if (!$stmt->execute()) {
                throw new Exception("Failed to Update Asign Status into Driver: " . $stmt->error);
            }
            $stmt->close();

            $query3 = "UPDATE conductor SET AsignStatus = 1 WHERE ConductorID = ? ";
            $stmt = $con->prepare($query3);
            $stmt->bind_param("s", $ConductorID);
            if (!$stmt->execute()) {
                throw new Exception("Failed to Update Asign Status into Conductor: " . $stmt->error);
            }
            $stmt->close();

            mysqli_commit($con);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($con);
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function Update(string $BusID, string $U_NoOfSeat, string $U_DriverID, string $U_ConductorID)
    {
        // echo "<script>console.log($BusID,$U_NoOfSeat,$U_DriverID,$U_ConductorID) </script>";

        $con = $this->db->getConnection();
        try {
            mysqli_begin_transaction($con);

            // Get current bus data
            $getBusData = "SELECT * FROM bus WHERE BusID = ?";
            $stmt = $con->prepare($getBusData);

            $stmt->bind_param("s", $BusID);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $row1 = $res->fetch_assoc();

                $oldNoOfSeat = $row1['NoOfSeat'];
                $oldDriverID = $row1['DriverID'];
                $oldConductorID = $row1['ConductorID'];
            } else {
                throw new Exception("No bus found with BusID: $BusID");
            }


            // echo "<script>console.log($BusID,$oldNoOfSeat,$oldDriverID,$oldConductorID) </script>";
            // throw new Exception("$BusID,$oldNoOfSeat,$oldDriverID,$oldConductorID");

            $stmt->close();

            if ($oldNoOfSeat !== $U_NoOfSeat) {
                $stmt = $con->prepare("UPDATE bus SET NoOfSeat = ? WHERE BusID = ?");
                $stmt->bind_param("ss", $U_NoOfSeat, $BusID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update No Of Seat : $BusID");
                }
                $stmt->close();
            }

            // Update DriverID
            if ($oldDriverID !== $U_DriverID) {
                // Check if the new driver exists
                $checkDriverQuery = "SELECT DriverID FROM driver WHERE DriverID = ?";
                $stmt = $con->prepare($checkDriverQuery);
                $stmt->bind_param("s", $U_DriverID);
                $stmt->execute();
                $resultDriver = $stmt->get_result();
                if ($resultDriver->num_rows == 0) {
                    throw new Exception("Can't Find This Driver.");
                }
                $stmt->close();

                // Check if the new driver is already assigned to another bus
                $checkDriverAssignmentQuery = "SELECT DriverID FROM bus WHERE DriverID = ? ";
                $stmt = $con->prepare($checkDriverAssignmentQuery);
                $stmt->bind_param("s", $U_DriverID);
                $stmt->execute();
                $resultDriverAssignment = $stmt->get_result();
                if ($resultDriverAssignment->num_rows > 0) {
                    throw new Exception("This Driver already assigned.");
                }
                $stmt->close();

                // Update the bus with the new driver ID
                $updateBusQuery = "UPDATE bus SET DriverID = ? WHERE BusID = ?";
                $stmt = $con->prepare($updateBusQuery);
                $stmt->bind_param("ss", $U_DriverID, $BusID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update Driver for Bus: $BusID");
                }
                $stmt->close();

                // Update the assignment status of the new driver
                $updateNewDriverStatusQuery = "UPDATE driver SET AsignStatus = '1' WHERE DriverID = ?";
                $stmt = $con->prepare($updateNewDriverStatusQuery);
                $stmt->bind_param("s", $U_DriverID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to Update Assignment Status for New Driver: " . $stmt->error);
                }
                $stmt->close();

                // Update the assignment status of the old driver
                $updateOldDriverStatusQuery = "UPDATE driver SET AsignStatus = '0' WHERE DriverID = ?";
                $stmt = $con->prepare($updateOldDriverStatusQuery);
                $stmt->bind_param("s", $oldDriverID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to Update Assignment Status for Old Driver: " . $stmt->error);
                }
                $stmt->close();
            }

            // Update ConductorID
            if ($oldConductorID !== $U_ConductorID) {
                // Check if the new conductor exists
                $checkConductorQuery = "SELECT ConductorID FROM conductor WHERE ConductorID = ?";
                $stmt = $con->prepare($checkConductorQuery);
                $stmt->bind_param("s", $U_ConductorID);
                $stmt->execute();
                $resultConductor = $stmt->get_result();
                if ($resultConductor->num_rows == 0) {
                    throw new Exception("Can't Find This Conductor.");
                }
                $stmt->close();

                // Check if the new conductor is already assigned to another bus
                $checkConductorAssignmentQuery = "SELECT ConductorID FROM bus WHERE ConductorID = ? AND BusID != ?";
                $stmt = $con->prepare($checkConductorAssignmentQuery);
                $stmt->bind_param("ss", $U_ConductorID, $BusID);
                $stmt->execute();
                $resultConductorAssignment = $stmt->get_result();
                if ($resultConductorAssignment->num_rows > 0) {
                    throw new Exception("This Conductor already assigned.");
                }
                $stmt->close();

                // Update the bus with the new conductor ID
                $updateBusQuery = "UPDATE bus SET ConductorID = ? WHERE BusID = ?";
                $stmt = $con->prepare($updateBusQuery);
                $stmt->bind_param("ss", $U_ConductorID, $BusID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update Conductor for Bus: $BusID");
                }
                $stmt->close();

                // Update the assignment status of the new conductor
                $updateNewConductorStatusQuery = "UPDATE conductor SET AsignStatus = '1' WHERE ConductorID = ?";
                $stmt = $con->prepare($updateNewConductorStatusQuery);
                $stmt->bind_param("s", $U_ConductorID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to Update Assignment Status for New Conductor: " . $stmt->error);
                }
                $stmt->close();

                // Update the assignment status of the old conductor
                $updateOldConductorStatusQuery = "UPDATE conductor SET AsignStatus = '0' WHERE ConductorID = ?";
                $stmt = $con->prepare($updateOldConductorStatusQuery);
                $stmt->bind_param("s", $oldConductorID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to Update Assignment Status for Old Conductor: " . $stmt->error);
                }
                $stmt->close();
            }

            mysqli_commit($con);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($con);
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            return false;
        } finally {
            $this->db->disconnect();
        }
    }

    public function ViewBus(string $type)
    {
        try {
            $query = "SELECT * FROM busview WHERE status = ? ORDER BY BusID ASC";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("s", $type);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_array = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'No Record Found']);
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function ChangeStatusBus(string $BusID, string $status)
    {
        // throw new Exception("BusID: $BusID, Status: $status");

        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);
            $stmt = $conn->prepare("UPDATE bus SET status = ? WHERE BusID = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ss", $status, $BusID);
            $res2 = $stmt->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate Bus: " . $stmt->error);
                } else {
                    throw new Exception("Failed to Activate Bus: " . $stmt->error);
                }
            }
            $stmt->close();
            return true;

        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function Search(string $type, string $txtSearch)
    {

        $conn = $this->db->getConnection();
        try {
            $query = "SELECT * FROM busview WHERE status = ?  AND (BusNumber LIKE ? OR BusID LIKE ? )ORDER BY BusID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("sss", $type, $searchTerm,$searchTerm);
            $stmt->execute();

            $result = $stmt->get_result();
            $res_array = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'No Record Found']);
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function GetFreeDriver(string $txtSearch)
    {

        $conn = $this->db->getConnection();
        try {
            $query = "SELECT * FROM driver WHERE status = 1  AND (DriverID LIKE ? OR Name LIKE ? OR NIC LIKE ? ) ORDER BY DriverID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();

            $result = $stmt->get_result();
            $res_array = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'Not Found']);
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function GetFreeConductor(string $txtSearch)
    {
        $conn = $this->db->getConnection();
        try {
            $query = "SELECT * FROM conductorview 
                  WHERE status = 1 
                  AND ( ConductorID LIKE ? OR Name LIKE ? ) 
                  ORDER BY ConductorID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("ss",  $searchTerm, $searchTerm);
            $stmt->execute();

            $result = $stmt->get_result();
            $res_array = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'Not  Found']);
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
