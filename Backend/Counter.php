<?php

class Counter extends User{
    public function register(string $name, string $password, string $contact, string $email){
        try{

            mysqli_begin_transaction($this->db->getConnection());
            //auto increment userID
            $userID = $this->userIDIncrement();

            //auto increment passengerID
            $sql1= "Select Max(CounterID) from counter";
            $r = mysqli_query($this->db->getConnection(), $sql1);
            if ($row = mysqli_fetch_array($r)) {
                $maxId = $row["CounterID"];
                $numericPart = intval(substr($maxId, 1));
                $newNumericPart = $numericPart + 1;

                $counterId = 'C' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
            } else {
                $counterId = 'C001';
            }


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
        }
        catch(Exception $e){
            mysqli_rollback($this->db->getConnection());
            echo $e;
        }

    }
}