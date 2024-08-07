<?php
require_once __DIR__ . "/DBConnection.php";
    abstract class User{
        protected $db;
        

        public function __construct(){
            $this->db= new DBConnection();
            $this->db->connect();
        }

        public function login(String $password,String $key){
            try{
                $sql="";
                if(strpos($key,"@")){
                    $sql = "Select UserType from user_account where Email='$key' and Password='$password'";
                } 
                else{
                    $sql = "Select UserType from user_account where Contact='$key' and Password='$password'";
                }
                $result = mysqli_query($this->db->getConnection(), $sql);
                if(mysqli_num_rows($result)==1){
                    $row = mysqli_fetch_array($result);
                    $userType= $row["UserType"];
                    echo "<script>console.log('Login successful');</script>";
                    //!sessions----------------------------------------

                    if ($userType == "Passneger") {
                        //*Passenger Panel
                    
                    } 
                    else if ($userType == 'Admin') {
                        //*Admin Panel
                    }
                    elseif ($userType == "Counter") {
                        //*Counter Panel
                    }
                    elseif($userType=="Conductor"){
                        //*Conductor Panel
                    }
                }
                else{
                    echo "<script>console.log('Login Fail');</script>";
                }
            }
            catch(Exception $e){
                echo $e;
            }
        }
        abstract function register(String $name,String $password,String $contact,String $email);
        protected function userIDIncrement(){
            
            try{
                $sql= "Select Max(UserID) from user_account";
                $r = mysqli_query($this->db->getConnection(), $sql);
                if ($row = mysqli_fetch_array($r)) {
                    $maxId = $row["UserID"];
                    $numericPart = intval(substr($maxId, 1));
                    $newNumericPart = $numericPart + 1;
    
                    $userID = 'U' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
                } else {
                    $userID = 'U001';
                }
                return $userID;
            }catch(Exception $e){
                return null;
            }
        }

    }