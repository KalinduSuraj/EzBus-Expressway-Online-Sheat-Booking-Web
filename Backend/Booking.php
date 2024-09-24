
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

    public function Create(string $Name, string $Contact, string $ScheduleID, string $SetaNo, string $ID)
    {


        if (substr($ID, 0, 1) === 'C') {
            $CounterID = $ID;
            $PassengerID = null;
        } elseif (substr($ID, 0, 1) === 'P') {
            $PassengerID = $ID;
            $CounterID = null;
        }
    
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);
    
            // Auto increment userID
            $BookingID = $this->generateNewBookingID();
            if (!$BookingID) {
                throw new Exception("Failed to generate a new Booking ID.");
            }
    
            // Check if seat is already booked
            $checkBooking = "SELECT ScheduleID, SeatNo FROM booking WHERE ScheduleID = ? AND SeatNo = ?";
            $stmt = $conn->prepare($checkBooking);
            $stmt->bind_param("ss", $ScheduleID, $SetaNo);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                throw new Exception("Seat already booked.");
            }
            $stmt->close();
    
            // Insert into Passenger Booking
            $CreatePassengerBookingQuery = "INSERT INTO booking(BookingID, Name, Contact, ScheduleID, SeatNo, PassengerID) VALUES (?, ?, ?, ?, ?, ? )";
    
            // Insert into Counter Booking
            $CreateCounterBookingQuery = "INSERT INTO booking(BookingID, Name, Contact, ScheduleID, SeatNo, CounterID) VALUES (?, ?, ?, ?, ?, ? )";
    
            // Prepare the correct query based on ID type
            if ($PassengerID !== null) {
                $stmt = $conn->prepare($CreatePassengerBookingQuery);
                $stmt->bind_param("ssssss", $BookingID, $Name, $Contact, $ScheduleID, $SetaNo, $PassengerID);
            } else if ($CounterID !== null) {
                $stmt = $conn->prepare($CreateCounterBookingQuery);
                $stmt->bind_param("ssssss", $BookingID, $Name, $Contact, $ScheduleID, $SetaNo, $CounterID);
            }
    
            // Execute the booking insertion
            if (!$stmt->execute()) {
                throw new Exception("Failed to insert booking: " . $stmt->error);
            }
            $stmt->close();
    
            // Commit the transaction
            mysqli_commit($conn);
    
            // Return the generated booking ID
            return $BookingID;
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($conn);
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            // Close the connection
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
            $lastID = $row ? $row['BookingID'] : null;

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

    public function Search(string $type, string $txtSearch) {
        $conn = $this->db->getConnection();
        $res_array = [];
    
        try {
            $searchTerm = '%' . $txtSearch . '%';
            
            if ($type === "All") {
                $query = "SELECT * FROM bookingview WHERE BookingID LIKE ? ORDER BY BookingID ASC;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $searchTerm);
            } else {
                $query = "SELECT * FROM bookingview WHERE BookingStatus = ? AND BookingID LIKE ? ORDER BY BookingID ASC;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $type, $searchTerm);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['message' => 'No Record Found']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            header('Content-type: application/json');
            echo json_encode(['success' => false, 'message' => 'An error occurred']);
        }
    }
    


    public function getTicketDetails(string $txtSearch)
    {
        $conn = $this->db->getConnection(); // Assuming $this->db is your DB connection object
        $res_array = [];

        try {
            // check BookingID exists
            $stmt = $conn->prepare("SELECT BookingStatus FROM bookingview WHERE BookingID = ?");
            if (!$stmt) {
                throw new Exception("Statement preparation failed: " . $conn->error);
            }

            $stmt->bind_param("s", $txtSearch);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . $conn->error);
            }

            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $BookingStatus = $row['BookingStatus'];

                // Check BookingStatus
                if ($BookingStatus == "Conform") {
                    throw new Exception("Ticket is already used.");
                } else if ($BookingStatus == "Canceled") {
                    throw new Exception("Ticket is canceled.");
                } else if ($BookingStatus == "Booked") {

                    // Fetch the ticket details if status is 'Booked'
                    $query = "SELECT * FROM bookingview WHERE BookingStatus = 'Booked' AND BookingID = ? ORDER BY BookingID ASC;";
                    $stmt = $conn->prepare($query);

                    if (!$stmt) {
                        throw new Exception("Statement preparation failed: " . $conn->error);
                    }

                    $stmt->bind_param("s", $txtSearch);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $res_array[] = $row;

                        // Return JSON response with the data
                        header('Content-type: application/json');
                        echo json_encode($res_array);
                    } else {
                        // Return JSON response for no records found
                        header('Content-type: application/json');
                        echo json_encode(['message' => 'No ticket found.']);
                    }
                }
            } else {
                // Return JSON response for no records found
                throw new Exception("No ticket found with the provided ID.");
            }
        } catch (Exception $e) {
            // Log the error
            error_log($e->getMessage(), 3, '/Backend/error.log');

            // Return error in JSON format
            header('Content-type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            // Ensure the statement and connection are closed
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    public function ConformBooking(string $BookingID)
    {
        // throw new Exception($BookingID);
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // Deactive from Driver table
            $stmt2 = $conn->prepare("UPDATE  booking SET BookingStatus = 'Conform' WHERE BookingID= ? ");
            $stmt2->bind_param("s", $BookingID);
            $res2 = $stmt2->execute();

            if (!$res2) {

                throw new Exception("Failed to Update Ticket Status : " . mysqli_error($conn));
            }
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function getPassengerBookingData(string $ID)
    {
        try {
            $query = "SELECT * FROM bookingview WHERE BookingStatus = 'Booked' AND PassengerID = ?  ORDER BY BookingID ASC";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("s", $ID);

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
