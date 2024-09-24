<?php
require_once __DIR__ . "/DBConnection.php";

class Driver
{

    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    //Generate New Driver ID
    public function generateNewDriverID()
    {
        $conn = $this->db->getConnection();
        try {
            // get the last  DriverID
            $query = "SELECT DriverID FROM driver ORDER BY DriverID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['DriverID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1));
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'D' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'D001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new Driver ID: " . $e->getMessage();
            return null;
        }
    }

    //Add Driver
    public function AddDriver(string $name, string $nic, string $contact, string $AdminID)
    {
        $con = $this->db->getConnection();
        try {
            mysqli_begin_transaction($con);

            $driverID = $this->generateNewDriverID();
            if (!$driverID) {
                throw new Exception("Failed to generate a new Driver ID.");
            }

            $checkEmailQuery = "SELECT NIC FROM driver WHERE NIC = ?";
            $stmtEmail = $con->prepare($checkEmailQuery);
            $stmtEmail->bind_param("s", $nic);
            $stmtEmail->execute();
            $resultEmail = $stmtEmail->get_result();

            if ($resultEmail->num_rows > 0) {
                throw new Exception("NIC already exists.");
            }

            // Insert queries
            $query1 = "INSERT INTO driver(DriverID, Name,Contact,NIC,AdminID) VALUES(?,?,?,?,?)";
            $stmt = $con->prepare($query1);
           
            $stmt->bind_param("sssss", $driverID, $name, $contact, $nic, $AdminID);
            if (!$stmt->execute()) {
                throw new Exception("Failed to insert into Driver: " . $stmt->error);
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

    public function Update(string $DriverID, string $U_name, string $U_nic, string $U_contact)
    {
        $con = $this->db->getConnection();
        try {
            mysqli_begin_transaction($con);

            $getDriverData = "SELECT * FROM driver WHERE DriverID = ?";
            $stmt = $con->prepare($getDriverData);
            $stmt->bind_param("s", $DriverID);
            $stmt->execute();
            $resul = $stmt->get_result();
            $row1 = mysqli_fetch_assoc($resul);

            $oldName = $row1['Name'];
            $oldNIC = $row1['NIC'];
            $oldContact = $row1['Contact'];

            if ($oldName !== $U_name) {
                $stmt1 = $con->prepare("UPDATE driver SET Name = ? WHERE DriverID = ?");
                $stmt1->bind_param("ss", $U_name, $DriverID);
                if (!$stmt1->execute()) {
                    throw new Exception("Failed to update Name for user: $DriverID");
                }
            }



            if ($oldNIC !== $U_nic) {
                $checkEmailQuery = "SELECT NIC FROM driver WHERE NIC = ?";
                $stmtEmail = $con->prepare($checkEmailQuery);
                $stmtEmail->bind_param("s", $U_nic);
                $stmtEmail->execute();
                $resultEmail = $stmtEmail->get_result();

                if ($resultEmail->num_rows > 0) {
                    throw new Exception("NIC already exists");
                }
                $stmt3 = $con->prepare("UPDATE driver SET NIC = ? WHERE DriverID = ?");
                $stmt3->bind_param("ss", $U_nic, $DriverID);
                if (!$stmt3->execute()) {
                    throw new Exception("Failed to update NIC for user: $DriverID");
                }
            }

            if ($oldContact !== $U_contact) {
                $stmt4 = $con->prepare("UPDATE driver SET Contact = ? WHERE DriverID = ?");
                $stmt4->bind_param("ss", $U_contact, $DriverID);
                if (!$stmt4->execute()) {
                    throw new Exception("Failed to update Contact for user: $DriverID");
                }
            }

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

    public function ViewDriver(string $type)
    {
        try {
            $query = "SELECT * FROM driver WHERE status = ? ORDER BY DriverID ASC";
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

    public function ChangeStatusDriver(string $driverID, string $status)
    {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // Deactive from Driver table
            $stmt2 = $conn->prepare("UPDATE  Driver SET status='$status' WHERE DriverID= ? ");
            $stmt2->bind_param("s", $driverID);
            $res2 = $stmt2->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate Driver: " . mysqli_error($conn));
                } else {
                    throw new Exception("Failed to Activate Driver: " . mysqli_error($conn));
                }
            }
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
            $query = "SELECT * FROM driver WHERE status = ?  AND (DriverID LIKE ? OR Name LIKE ? OR NIC LIKE ? ) ORDER BY DriverID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("ssss", $type, $searchTerm,$searchTerm, $searchTerm);
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
}
