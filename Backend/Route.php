<?php
require_once __DIR__ . "/DBConnection.php";
class Route{
    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    public function AddRoute(string $From, string $To,string $Price,string $AdminID){
        $con = $this->db->getConnection();
        try {
            mysqli_begin_transaction($con);

            $routeID = $this->generateNewRouteID();
            if (!$routeID) {
                throw new Exception("Failed to generate a new Route ID.");
            }

            $checkRouteQuery = "SELECT * FROM route WHERE FromCity = ? AND ToCity = ? ";
            $stmtRoute = $con->prepare($checkRouteQuery);
            $stmtRoute->bind_param("ss", $From,$To);
            $stmtRoute->execute();
            $resultRoute = $stmtRoute->get_result();

            if ($resultRoute->num_rows > 0) {
                throw new Exception("Route already exists.");
            }

            // Insert queries
            $query1 = "INSERT INTO route(RouteID, FromCity,ToCity,Price,AdminID) VALUES(?,?,?,?,?)";
            $stmt = $con->prepare($query1);
            
            $stmt->bind_param("sssds", $routeID, $From, $To, $Price, $AdminID);
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

    public function Update(string $RouteID, string $U_Price){
        $con = $this->db->getConnection();
        try {
            mysqli_begin_transaction($con);

            $query1 = "UPDATE route SET Price = ? WHERE RouteID = ? ";
            $stmt = $con->prepare($query1);
            $stmt->bind_param("ds", $U_Price ,$RouteID);
            if (!$stmt->execute()) {
                throw new Exception("Failed to Update into Driver: " . $stmt->error);
            }
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            } else {
                throw new Exception("No rows were updated for RouteID: " . $RouteID);
            }
            mysqli_commit($con);
            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function generateNewRouteID()
    {
        $conn = $this->db->getConnection();
        try {
            // get the last  RouteID
            $query = "SELECT RouteID FROM route ORDER BY RouteID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['RouteID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1));
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'R' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'R001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new Route ID: " . $e->getMessage();
            return null;
        }
    }

    public function ViewRoute(string $type)
    {
        try {
            $query = "SELECT * FROM route WHERE status = ? ORDER BY RouteID ASC";
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

    public function ChangeStatusRoute(string $RouteID, string $status)
    {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // Deactive from Route table
            $stmt2 = $conn->prepare("UPDATE  route SET status='$status' WHERE RouteID= ? ");
            $stmt2->bind_param("s", $RouteID);
            $res2 = $stmt2->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate Route: " . mysqli_error($conn));
                } else {
                    throw new Exception("Failed to Activate Route: " . mysqli_error($conn));
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
            $query = "SELECT * FROM route WHERE status = ?  AND (FromCity LIKE ? OR ToCity LIKE ? OR RouteID LIKE ? ) ORDER BY RouteID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("ssss", $type, $searchTerm, $searchTerm,$searchTerm);
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