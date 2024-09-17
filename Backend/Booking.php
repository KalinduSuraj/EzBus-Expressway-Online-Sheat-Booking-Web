
<?php
require_once __DIR__ . "/DBConnection.php";
class Booking
{

    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    public function Create(string $Name, string $Contact, string $ScheduleID, string $SetaNo, string $PassengerID, string $CounterID)
    {
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Auto increment userID
            $BookingID = $this->generateNewBookingID();
            if (!$BookingID) {
                throw new Exception("Failed to generate a new user ID.");
            }

            $checkBooking = "SELECT ScheduleID,SeatNo FROM booking WHERE ScheduleID = ? AND SeatNo = ? ";
            $stmt = $conn->prepare($checkBooking);
            $stmt->bind_param("ss", $ScheduleID, $SetaNo);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                throw new Exception("Seat already Booked.");
            }
            $stmt->close();

            // Insert into Passenger Booking
            $CreatePassengerBookingQuery = "INSERT INTO booking(BookingID, Name, Contact, ScheduleID, SeatNo, PassengerID) VALUES (?, ?, ?, ?, ?, ? )";

            // Insert into Counter Booking
            $CreateCounterBookingQuery = "INSERT INTO booking(BookingID, Name, Contact, ScheduleID, SeatNo, CounterID) VALUES (?, ?, ?, ?, ?, ? )";


            if ($PassengerID !== null) {
                $stmt = $conn->prepare($CreatePassengerBookingQuery);
                $stmt->bind_param("ssssss", $BookingID, $Name, $Contact, $ScheduleID, $SetaNo, $PassengerID);
            } else if ($CounterID !== null) {
                $stmt = $conn->prepare($CreateCounterBookingQuery);
                $stmt->bind_param("ssssss", $BookingID, $Name, $Contact, $ScheduleID, $SetaNo, $CounterID);
            }

            if (!$stmt->execute()) {
                throw new Exception("Failed to insert into Booking: " . $stmt->error);
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

    public function generateNewBookingID()
    {
        $conn = $this->db->getConnection();
        try {
            $query = "SELECT BookingID FROM booking ORDER BY BookingID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['AdminID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1)); // Assumes prefix 'B' is 1 characters
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'B' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'B001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new Booking ID: " . $e->getMessage();
            return null;
        }
    }

    public function ViewBooking(string $type)
    {
        $conn = $this->db->getConnection();
        try {
            $res_array = [];

            if ($type == "All") {
                // Handle the "All" condition by preparing and executing the query
                $queary = "SELECT * FROM bookingview ORDER BY BookingID ASC;";
                $stmt = $conn->prepare($queary);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                // Handle the specific BookingStatus query
                $queary = "SELECT * FROM bookingview WHERE BookingStatus = ? ORDER BY BookingID ASC;";
                $stmt = $conn->prepare($queary);
                $stmt->bind_param("s", $type);
                $stmt->execute();
                $result = $stmt->get_result();
            }

            // Check if there are any records found
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    array_push($res_array, $row);
                }
                // Return JSON response with the data
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                // Return JSON response for no records found
                header('Content-type: application/json');
                echo json_encode(['message' => 'No Record Found']);
            }
        } catch (Exception $e) {
            // Handle exceptions and log the error
            error_log($e->getMessage(), 3, '/Backend/error.log');
            header('Content-type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function Search(string $type, string $txtSearch)
    {
        $conn = $this->db->getConnection();
        try {
            // echo $return = "View Admin Data";
            $queary = "SELECT * FROM adminview WHERE status='$type' AND (AdminID like '%$txtSearch%' OR Name like '%$txtSearch%' OR Email like '%$txtSearch%' OR Contact like '%$txtSearch%') ORDER BY AdminID ASC; ";
            $queary_run = mysqli_query($conn, $queary);
            $res_array = [];

            if (mysqli_num_rows($queary_run) > 0) {
                foreach ($queary_run as $row) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'No Record Found']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    
}
