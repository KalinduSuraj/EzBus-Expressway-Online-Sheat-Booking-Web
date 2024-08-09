<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";
class Conductor extends User{

    public function register(string $name, string $password, string $contact, string $email){
        try{

            mysqli_begin_transaction($this->db->getConnection());
            //auto increment userID
            $userID = $this->userIDIncrement();

            //auto increment passengerID
            $conductorid = $this->generateNewConductorID();


            //registration process
            $sql2 = "select Email from user where Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!(mysqli_num_rows($res) == 1)) {
                //inner join
                $queary1 = "insert into user_account(UserID,Name,Email,Contact,Password,UserType)
                values('$userID','$name','$email','$contact','$password','Conductor');";
                $queary2 = "insert into conductor
                values('$conductorid','$userID');";

                $result1 = mysqli_query($this->db->getConnection(), $queary1);
                $result2 = mysqli_query($this->db->getConnection(), $queary2);
                $this->db->disconnect();
                if ($result1 && $result2) {
                    mysqli_commit($this->db->getConnection());
                    echo "<script> console.log('Added'); </script>";
                    echo "<script>alert('Conductor Registered Successfully');</script>";

                    //redirection file->
                    //echo "<script>window.location.href = 'signIn.php';</script>";
                } else {
                    mysqli_rollback($this->db->getConnection());
                    echo "<script> alert('not Added'); </>";
                }
                return true;
            } else {
                mysqli_rollback($this->db->getConnection());
                echo "<script> alert('there is the Conductor in this $email'); </script>";
                return false;
            }
        }
        catch(Exception $e){
            mysqli_rollback($this->db->getConnection());
            echo $e;
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
        }else{
            echo $return = "<h4>No Record Found</h4>";
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
