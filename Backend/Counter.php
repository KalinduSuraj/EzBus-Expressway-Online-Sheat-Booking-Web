<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";

class Counter extends User
{
    public function register(string $name, string $password, string $contact, string $email, string $location)
    {
        $con = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($con);

            // Auto increment userID
            $userID = $this->userIDIncrement();
            if (!$userID) {
                throw new Exception("Failed to generate a new user ID.");
            }

            $counterID = $this->generateNewCounterID();
            if (!$counterID) {
                throw new Exception("Failed to generate a new Counter ID.");
            }

            // Check if email already exists
            $sql2 = "SELECT Email FROM user_account WHERE Email='$email'";
            $res = mysqli_query($con, $sql2);

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($con));
            }

            if (mysqli_num_rows($res) > 0) {
                throw new Exception("Email already exists.");
            }

            // Insert queries
            $query1 = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                   VALUES('$userID', '$name', '$email', '$contact', '$password', 'Counter', 'Password')";
            $query2 = "INSERT INTO counter(CounterID, UserID, AdminID,Location) 
                   VALUES('$counterID', '$userID', 'A001','$location')"; // Change the Creator ID

            $result1 = mysqli_query($con, $query1);
            if (!$result1) {
                throw new Exception("Failed to insert into user_account: " . mysqli_error($con));
            }

            $result2 = mysqli_query($con, $query2);
            if (!$result2) {
                throw new Exception("Failed to insert into counter: " . mysqli_error($con));
            }

            // Commit the transaction if both inserts were successful
            mysqli_commit($con);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($con);
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $this->db->disconnect();
        }
    }

    /*public function register(string $name, string $password, string $contact, string $email)
    {
        try {

            mysqli_begin_transaction($this->db->getConnection());
            //auto increment userID
            $userID = $this->userIDIncrement();

            //auto increment passengerID
            $counterId = $this->generateNewCounterID();


            //registration process
            $sql2 = "select Email from user where Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!(mysqli_num_rows($res) == 1)) {
                //inner join
                $queary1 = "insert into user_account(UserID,Name,Email,Contact,Password,UserType)
                values('$userID','$name','$email','$contact','$password','Counter');";
                $queary2 = "insert into counter
                values('$counterId','$userID');";

                $result1 = mysqli_query($this->db->getConnection(), $queary1);
                $result2 = mysqli_query($this->db->getConnection(), $queary2);
                $this->db->disconnect();
                if ($result1 && $result2) {
                    mysqli_commit($this->db->getConnection());
                    echo "<script> console.log('Added'); </script>";
                    echo "<script>alert('Counter Registered Successfully');</script>";

                    //redirection file->
                    //echo "<script>window.location.href = 'signIn.php';</script>";
                } else {
                    mysqli_rollback($this->db->getConnection());
                    echo "<script> alert('not Added'); </>";
                }
                return true;
            } else {
                mysqli_rollback($this->db->getConnection());
                echo "<script> alert('there is the Counter in this $email'); </script>";
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            echo $e;
        }
    }*/

    public function ViewCounter(string $type)
    {
        try {
            // echo $return = "View Counter Data";
            $queary = "SELECT * FROM counterview WHERE status='$type' ORDER BY CounterID ASC; ";
            $queary_run = mysqli_query($this->db->getConnection(), $queary);
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

    public function generateNewCounterID()
    {
        $conn = $this->db->getConnection();
        try {
            // Query to get the last inserted CounterID
            $query = "SELECT CounterID FROM counter ORDER BY CounterID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['CounterID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 4)); // Assumes prefix 'COU-' is 4 characters
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'COU-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'COU-001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new CounterID: " . $e->getMessage();
            return null;
        }
    }

    public function ChangeStatusCounter(string $counterID, string $status)
    {
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Prepare and execute query to check if counterID exists
            $stmt = $conn->prepare("SELECT UserID FROM counter WHERE CounterID = ?");
            $stmt->bind_param("s", $counterID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("counterID does not exist.");
            }

            // Deactive from counter table
            $stmt2 = $conn->prepare("UPDATE  counter SET status='$status' WHERE CounterID= ? ");
            $stmt2->bind_param("s", $counterID);
            $res2 =$stmt2->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate counter: " . mysqli_error($conn));
                } else {
                    throw new Exception("Failed to Activate counter: " . mysqli_error($conn));
                }
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log'); // Specify a path to log errors
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function Search(string $type, string $txtSearch)
    {
        $conn = $this->db->getConnection();
        try {
            // echo $return = "View Counter Data";
            $queary = "SELECT * FROM counterview WHERE status='$type' AND (Location like '%$txtSearch%' OR CounterID like '%$txtSearch%' OR Name like '%$txtSearch%' OR Email like '%$txtSearch%' OR Contact like '%$txtSearch%') ORDER BY CounterID ASC; ";
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
