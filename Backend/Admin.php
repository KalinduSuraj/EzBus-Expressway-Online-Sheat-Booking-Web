<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";
class Admin extends User
{

    public function register(string $name, string $password, string $contact, string $email)
    {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->db->getConnection());

            // Auto increment userID
            $userID = $this->userIDIncrement();

            // Auto increment passengerID
            $sql1 = "SELECT MAX(AdminID) FROM admin";
            $r = mysqli_query($this->db->getConnection(), $sql1);
            if ($row = mysqli_fetch_array($r)) {
                $maxId = $row["AdminID"];
                $numericPart = intval(substr($maxId, 1));
                $newNumericPart = $numericPart + 1;

                $adminId = 'A' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
            } else {
                $adminId = 'A001';
            }

            // Registration process
            $sql2 = "SELECT Email FROM user WHERE Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!(mysqli_num_rows($res) == 1)) {
                // Insert queries
                $query1 = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType) VALUES('$userID', '$name', '$email', '$contact', '$password', 'Passenger')";
                $query2 = "INSERT INTO admin VALUES('$adminId', '$userID')";

                $result1 = mysqli_query($this->db->getConnection(), $query1);
                $result2 = mysqli_query($this->db->getConnection(), $query2);

                if ($result1 && $result2) {
                    mysqli_commit($this->db->getConnection());
                    echo "<script> console.log('Added'); </script>";
                    echo "<script>alert('Admin Registered Successfully');</script>";

                    // Redirection file->
                    // echo "<script>window.location.href = 'signIn.php';</script>";
                } else {
                    mysqli_rollback($this->db->getConnection());
                    echo "<script> alert('not Added'); </>";
                }
                return true;
            } else {
                echo "<script> alert('there is the Admin in this $email'); </script>";
                mysqli_rollback($this->db->getConnection());
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            echo $e;
        } finally {
            $this->db->disconnect();
        }
    }


    public function ViewAdmin()
    {
        // echo $return = "View Admin Data";
        $queary = "SELECT * FROM adminview ";
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
}

 