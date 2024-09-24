<?php
require_once __DIR__ . "/DBConnection.php";
abstract class User
{
    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    public function login(String $key, String $password, String $Type)
    {
        $conn = $this->db->getConnection();
        try {
            $table = ''; // Initialize table variable
            $UserTypeID='';
            // Determine whether the login is via Email or Contact
            if (strpos($key, "@")) {
                // For Email login
                $table = "passengerview";
                $query = "SELECT * FROM $table WHERE Email = ? AND Password = ? ";
                $userID = $key;
            } else if ($Type == "Passenger") {
                // For Contact login for passengers
                $table = "passengerview";
                $query = "SELECT * FROM $table WHERE Contact = ? AND Password = ? ";
                $userID = $key;
            } else {
                $UserTypeID=$key;
                // For Admin, Counter, and Conductor, get UserID first
                switch ($Type) {
                    case "Admin":
                        $table = "adminview";
                        $getUserIDQuery = "SELECT UserID FROM admin WHERE AdminID = ?";
                        break;
                    case "Counter":
                        $table = "counterview";
                        $getUserIDQuery = "SELECT UserID FROM counter WHERE CounterID = ?";
                        break;
                    case "Conductor":
                        $table = "conductorview";
                        $getUserIDQuery = "SELECT UserID FROM conductor WHERE ConductorID = ?";
                        break;
                }

                // Get the UserID first
                $stmt = $conn->prepare($getUserIDQuery);
                $stmt->bind_param("s", $key);
                $stmt->execute();
                $res = $stmt->get_result();

                if (!$res) {
                    throw new Exception("Database query failed: " . mysqli_error($conn));
                }

                if ($res->num_rows == 0) {
                    throw new Exception("ID does not exist.");
                }

                // Get the UserID
                $row = mysqli_fetch_assoc($res);
                $userID = $row['UserID'];

                // Prepare the login query after UserID is fetched
                $query = "SELECT * FROM $table WHERE UserID = ? AND Password = ? ";
            }

            // Prepare the main login query
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $userID, $password);

            // error_log($query, 3, '/Backend/error.log');
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                // $user['ID'] = $UserTypeID; // Add ID to the response
                $user['UserType'] = $Type;
                return $user; // Return the user details
            } else {
                return false; // Login failed
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            throw new Exception("An error occurred while logging in.");
        }
    }




    // public function login(String $key, String $password)
    // {
    //     $conn = $this->db->getConnection();
    //     try {
    //         $res_array = [];
    //         if (strpos($key, "@")) {
    //             $query = "Select UserType from user_account where Email= ? and Password= ? ";

    //         } else {
    //             $query = "Select UserType from user_account where Contact= ? and Password= ? ";
    //         }

    //         $stmt = $conn->prepare($query);
    //         $stmt->bind_param("ss", $key, $password);

    //         if (!$stmt->execute()) {
    //             throw new Exception("Failed to User Login: " . $stmt->error);
    //         }
    //         $result = $stmt->get_result();
    //         $stmt->close();
    //         if ($result->num_rows == 0) {
    //             array_push($res_array, $result);

    //             //!sessions----------------------------------------
    //             header('Content-type: application/json');
    //             echo json_encode($res_array);
    //         } else {
    //             header('Content-type: application/json');
    //             echo json_encode(['success' => false, 'message' => 'Incorrect User Name or Contact ']);
    //         }
    //     } catch (Exception $e) {
    //         error_log($e->getMessage(), 3, '/Backend/error.log');
    //         header('Content-type: application/json');
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }
    //function register(String $name, String $password, String $contact, String $email){}

    public function userIDIncrement()
    {
        try {
            // Query to get the last inserted UserID
            $query = "SELECT UserID FROM user_account ORDER BY UserID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);
            $lastID = mysqli_fetch_assoc($result)['UserID'];

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
            $newID = 'U' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new UserID: " . $e->getMessage();
            return null;
        }
    }
}
