<?php
require_once __DIR__ . "/DBConnection.php";
class Route{
    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    //Generate New Route ID
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

    public function ViewRouter(string $type)
    {
        try {
            $query = "SELECT * FROM router WHERE status = ? ORDER BY RouterID ASC";
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

    public function ChangeStatusRouter(string $routerID, string $status)
    {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // Deactive from Router table
            $stmt2 = $conn->prepare("UPDATE  Router SET status='$status' WHERE RouterID= ? ");
            $stmt2->bind_param("s", $routerID);
            $res2 = $stmt2->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate Router: " . mysqli_error($conn));
                } else {
                    throw new Exception("Failed to Activate Router: " . mysqli_error($conn));
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
            $query = "SELECT * FROM route WHERE status = ?  AND (FromCity LIKE ? OR ToCity LIKE ? ) ORDER BY RouteID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("sss", $type, $searchTerm, $searchTerm);
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