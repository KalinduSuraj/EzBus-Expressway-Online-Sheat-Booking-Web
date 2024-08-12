<?php

class Conductor extends User{

    public function register(string $name, string $password, string $contact, string $email){
        try{

            mysqli_begin_transaction($this->db->getConnection());
            //auto increment userID
            $userID = $this->userIDIncrement();
            $conductorid = $this->ConductorIDIncrement();

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
    private function ConductorIDIncrement(){

        try {
             // Query to get the last inserted UserID
             $query = "SELECT ConductorID FROM passenger ORDER BY ConductorID DESC LIMIT 1";
             $result = mysqli_query($this->db->getConnection(), $query);
             $lastID = mysqli_fetch_assoc($result)['ConductorID'];
 
             if ($lastID) {
                 // Extract the numeric part of the last ID
                 $number = intval(substr($lastID, 1));
                 // Increment the number
                 $newNumber = $number + 1;
             } else {
                 // If no records exist, start with 1
                 $newNumber = 1;
             }
 
             // Format the new ID with leading zeros
             $newID = 'CD' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
             return $newID;
        } catch (Exception $e) {
            echo "Error generating new UserID: " . $e->getMessage();
            return null;
        }
    }
}
