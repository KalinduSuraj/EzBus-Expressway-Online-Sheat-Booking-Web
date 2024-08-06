<?php
    class Passenger extends User{
        
        public function register(string $name, string $password, string $contact, string $email){
            try{

                //auto increment userID
                $userID = $this->userIDIncrement();

                //auto increment passengerID
                $sql1= "Select Max(PassengerID) from passenger";
                $r = mysqli_query($this->db->getConnection(), $sql1);
                if ($row = mysqli_fetch_array($r)) {
                    $maxId = $row["PassengerID"];
                    $numericPart = intval(substr($maxId, 1));
                    $newNumericPart = $numericPart + 1;
    
                    $passengerId = 'P' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
                } else {
                    $passengerId = 'P001';
                }


                //registration process
                $sql2 = "select Email from user where Email='$email'";
                $res = mysqli_query($this->db->getConnection(), $sql2);

                if (!(mysqli_num_rows($res) == 1)) {
                    //inner join
                    $queary1 = "insert into user_account
                    values('$contact','$email','$name','$password','$userID','Passenger');";
                    $queary2 = "insert into passenger
                    values('$passengerId','$userID');";
    
                    $result1 = mysqli_query($this->db->getConnection(), $queary1);
                    $result2 = mysqli_query($this->db->getConnection(), $queary2);
                    $this->db->disconnect();
                    if ($result1 && $result2) {
                        echo "<script> console.log('Added'); </script>";
                        echo "<script>alert('Passenger Registered Successfully');</script>";

                        //redirection file->
                        //echo "<script>window.location.href = 'signIn.php';</script>";
                    } else {
                        echo "<script> alert('not Added'); </>";
                    }
                    return true;
                } else {
                    echo "<script> alert('there is the Passenger in this $email'); </script>";
                    return false;
                }
            }
            catch(Exception $e){
                echo $e;
            }

        }
    }

