<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";
class Conductor extends User{

    public function register(string $name, string $password, string $contact, string $email){
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Auto increment userID
            $userID = $this->userIDIncrement();
            if (!$userID) {
                throw new Exception("Failed to generate a new user ID.");
            }

            $conductorID = $this->generateNewConductorID();
            if (!$conductorID) {
                throw new Exception("Failed to generate a new conductor ID.");
            }

            // Check if email already exists
            $sql2 = "SELECT Email FROM user_account WHERE Email='$email'";
            $res = mysqli_query($conn, $sql2);

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($res) > 0) {
                throw new Exception("Email already exists.");
            }

            // Insert queries
            $query1 = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                   VALUES('$userID', '$name', '$email', '$contact', '$password', 'Conductor', 'Password')";
            $query2 = "INSERT INTO conductor(ConductorID, UserID, Creator) 
                   VALUES('$conductorID', '$userID', 'A001')"; // Change the Creator ID

            $result1 = mysqli_query($conn, $query1);
            if (!$result1) {
                throw new Exception("Failed to insert into user_account: " . mysqli_error($conn));
            }

            $result2 = mysqli_query($conn, $query2);
            if (!$result2) {
                throw new Exception("Failed to insert into conductor: " . mysqli_error($conn));
            }

            // Commit the transaction if both inserts were successful
            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage(), 3, '/Backend/error.log'); // Specify a path to log errors
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }

    }

    public function ViewConductor()
    {
        // echo $return = "View Conductor Data";
        $queary = "SELECT * FROM conductorview ";
        $queary_run = mysqli_query($this->db->getConnection(), $queary);
        $res_array=[];

        if(mysqli_num_rows($queary_run)>0){
            foreach($queary_run as $row){
                array_push($res_array,$row);
            }
            header('Content-type: application/json');
            echo json_encode($res_array);
        }      
    }
    
    public function generateNewConductorID()
    {
        try {
            // Query to get the last inserted CounterID
            $query = "SELECT ConductorID FROM conductor ORDER BY ConductorID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($this->db->getConnection()));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['ConductorID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 4)); // Assumes prefix 'COU-' is 4 characters
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'C' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'C001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new CounterID: " . $e->getMessage();
            return null;
        }
    }
    
}
