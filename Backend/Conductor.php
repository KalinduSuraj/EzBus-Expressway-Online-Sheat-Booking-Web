<?php

class Conductor extends User{

    public function register(string $name, string $password, string $contact, string $email){
        try{

            mysqli_begin_transaction($this->db->getConnection());
            //auto increment userID
            $userID = $this->userIDIncrement();

            //auto increment passengerID
            $sql1= "Select Max(ConductorID) from admin";
            $r = mysqli_query($this->db->getConnection(), $sql1);
            if ($row = mysqli_fetch_array($r)) {
                $maxId = $row["ConductorID"];
                $numericPart = intval(substr($maxId, 2));
                $newNumericPart = $numericPart + 1;

                $conductorid = 'CD' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
            } else {
                $conductorid = 'CD001';
            }


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
}
