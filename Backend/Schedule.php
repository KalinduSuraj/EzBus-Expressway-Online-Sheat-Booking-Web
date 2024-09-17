<?php
require_once __DIR__ . "/DBConnection.php";

class Schedule
{
    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    public function generateNewScheduleID()
    {
        $conn = $this->db->getConnection();
        try {
            // get the last  ScheduleID
            $query = "SELECT ScheduleID FROM bus_schedule ORDER BY ScheduleID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['ScheduleID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1));
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'S' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'S001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new Schedule ID: " . $e->getMessage();
            return null;
        }
    }

    public function ViewSchedule(string $type)
    {
        try {
            $query = "SELECT * FROM scheduleview WHERE status = ? ORDER BY ScheduleID ASC";
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

    public function AddSchedule(string $RouteID,  string $BusID,  string $Date, string $Time)
    {
        $con = $this->db->getConnection();
        try {
            mysqli_begin_transaction($con);

            $ScheduleID = $this->generateNewScheduleID();
            if (!$ScheduleID) {
                throw new Exception("Failed to generate a new Schedule ID.");
            }

            $checkScheduleQuery = "SELECT * FROM bus_schedule WHERE Date = ? AND Time = ? AND RouteID = ? AND BusID = ?  ";
            $stmt = $con->prepare($checkScheduleQuery);
            $stmt->bind_param("ssss", $Date, $Time, $RouteID, $BusID);
            $stmt->execute();
            $resultBusNo = $stmt->get_result();
            if ($resultBusNo->num_rows > 0) {
                throw new Exception("Schedule is already exists.");
            }
            $stmt->close();

            $query1 = "INSERT INTO bus_schedule(ScheduleID, Date,Time,RouteID,BusID,AdminID) VALUES(?,?,?,?,?,?)";
            $stmt = $con->prepare($query1);
            $LogedUserID = "A001";
            $stmt->bind_param("ssssss", $ScheduleID, $Date, $Time, $RouteID, $BusID, $LogedUserID);
            if (!$stmt->execute()) {
                throw new Exception("Failed to insert into Schedule: " . $stmt->error);
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

    public function ChangeStatusSchedule(string $ScheduleID, string $status)
    {
        // throw new Exception("ScheduleID: $ScheduleID, Status: $status");

        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);
            $stmt = $conn->prepare("UPDATE bus_schedule SET status = ? WHERE ScheduleID = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ss", $status, $ScheduleID);
            $res2 = $stmt->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate Schedule: " . $stmt->error);
                } else {
                    throw new Exception("Failed to Activate Schedule: " . $stmt->error);
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

    public function SearchSchedule(string $type, string $txtSearch)
    {

        $conn = $this->db->getConnection();
        try {
            $query = "SELECT * FROM scheduleview WHERE status = ?  AND (Date LIKE ? OR Formatted_time LIKE ? OR FromCity LIKE ? OR ToCity LIKE ? OR BusID LIKE ? OR BusNumber LIKE ?)ORDER BY BusID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("sssssss", $type, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();

            $result = $stmt->get_result();
            $res_array = [];


            header('Content-type: application/json');
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                echo json_encode($res_array);
            } else {
                echo json_encode(['success' => false, 'message' => 'No Record Found']);
            }
            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function UpdateSchedule(string $ScheduleID, string $U_RouteID,  string $U_BusID,  string $U_Date, string $U_Time)
    {

        $con = $this->db->getConnection();
        try {
            // throw new Exception("$ScheduleID + $U_RouteID + $U_BusID + $U_Date + $U_Time  ");

            mysqli_begin_transaction($con);

            $checkScheduleQuery = "SELECT * FROM bus_schedule WHERE Date = ? AND Time = ? AND RouteID = ? AND BusID = ?  ";
            $stmt = $con->prepare($checkScheduleQuery);
            $stmt->bind_param("ssss", $U_Date, $U_Time, $U_RouteID, $U_BusID);
            $stmt->execute();
            $resultBusNo = $stmt->get_result();
            if ($resultBusNo->num_rows > 0) {
                throw new Exception("Schedule is already exists.");
            }
            $stmt->close();

            $getScheduleData = "SELECT * FROM bus_schedule WHERE ScheduleID = ?";
            $stmt = $con->prepare($getScheduleData);

            if ($stmt === false) {
                throw new Exception("Failed to prepare the SQL statement: " . $con->error);
            }
            $stmt->bind_param("s", $ScheduleID);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $row1 = $res->fetch_assoc();

                $oldRouteID = $row1['RouteID'];
                $oldBusID = $row1['BusID'];
                $oldDate = $row1['Date'];
                $oldTime = $row1['Time'];
            } else {
                throw new Exception("No Schedule found with Schedule ID: $ScheduleID");
            }

            // throw new Exception("$oldRouteID + $oldBusID + $oldDate + $oldTime");

            if ($oldRouteID !== $U_RouteID) {
                // throw new Exception("Not qule RouteID");
                $stmt = $con->prepare("UPDATE bus_schedule SET RouteID = ? WHERE ScheduleID = ?");
                $stmt->bind_param("ss", $U_RouteID, $ScheduleID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update No Of Seat : $ScheduleID");
                }
                $stmt->close();
            }

            if ($oldBusID !== $U_BusID) {
                // throw new Exception("Not qule BusID");
                $stmt = $con->prepare("UPDATE bus_schedule SET BusID = ? WHERE ScheduleID = ?");
                $stmt->bind_param("ss", $U_BusID, $ScheduleID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update No Of Seat : $ScheduleID");
                }
                $stmt->close();
            }

            if ($oldDate !== $U_Date) {
                // throw new Exception("Not qule Date");
                $stmt = $con->prepare("UPDATE bus_schedule SET Date = ? WHERE ScheduleID = ?");
                $stmt->bind_param("ss", $U_Date, $ScheduleID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update No Of Seat : $ScheduleID");
                }
                $stmt->close();
            }

            if ($oldTime !== $U_Time) {
                // throw new Exception("Not qule Time");
                $stmt = $con->prepare("UPDATE bus_schedule SET Time = ? WHERE ScheduleID = ?");
                $stmt->bind_param("ss", $U_Time, $ScheduleID);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update No Of Seat : $ScheduleID");
                }
                $stmt->close();
            }


            return true;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }
}
