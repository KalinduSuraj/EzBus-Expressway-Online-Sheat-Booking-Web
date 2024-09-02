<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";

class Counter extends User
{
    public function register(string $name, string $password, string $contact, string $email)
    {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->db->getConnection());

            // Auto increment userID
            $userID = $this->userIDIncrement();
            if (!$userID) {
                throw new Exception("Failed to generate a new user ID.");
            }

            $counterID = $this->generateNewCounterID();
            if (!$counterID) {
                throw new Exception("Failed to generate a new admin ID.");
            }

            // Check if email already exists
            $sql2 = "SELECT Email FROM user_account WHERE Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($this->db->getConnection()));
            }

            if (mysqli_num_rows($res) > 0) {
                throw new Exception("Email already exists.");
            }

            // Insert queries
            $query1 = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                   VALUES('$userID', '$name', '$email', '$contact', '$password', 'Admin', 'Password')";
            $query2 = "INSERT INTO admin(CounterID, UserID, Creator) 
                   VALUES('$counterID', '$userID', 'A001')"; // Change the Creator ID

            $result1 = mysqli_query($this->db->getConnection(), $query1);
            if (!$result1) {
                throw new Exception("Failed to insert into user_account: " . mysqli_error($this->db->getConnection()));
            }

            $result2 = mysqli_query($this->db->getConnection(), $query2);
            if (!$result2) {
                throw new Exception("Failed to insert into counter: " . mysqli_error($this->db->getConnection()));
            }

            // Commit the transaction if both inserts were successful
            mysqli_commit($this->db->getConnection());
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
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
    
    public function ViewCounter()
    {
        // echo $return = "View Counter Data";
        $queary = "SELECT * FROM counterview ";
        $queary_run = mysqli_query($this->db->getConnection(), $queary);
        $res_array = [];

        if (mysqli_num_rows($queary_run) > 0) {
            foreach ($queary_run as $row) {
                array_push($res_array, $row);
            }
            header('Content-type: application/json');
            echo json_encode($res_array);
        } else {
            echo $return = "<h4>No Record Found</h4>";
            header('Content-type: application/json');
            echo json_encode($res_array);
        }
    }

    public function generateNewCounterID()
    {
        try {
            // Query to get the last inserted CounterID
            $query = "SELECT CounterID FROM counter ORDER BY CounterID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($this->db->getConnection()));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['CounterID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1)); // Assumes prefix 'C' is 1 characters
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
}
