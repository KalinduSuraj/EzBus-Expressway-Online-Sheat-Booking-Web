<?php
class Passenger extends User
{




    public function register(string $name, string $password, string $contact, string $email)
    {
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Auto increment userID
            $userID = $this->userIDIncrement();
            if (!$userID) {
                throw new Exception("Failed to generate a new user ID.");
            }

            //PassengerID
            $passengerId = $this->generateNewPassengerID();
            if (!$passengerId) {
                throw new Exception("Failed to generate a new Passenger ID.");
            }


            // Registration process
            $checkEmailQuery = "SELECT Email FROM user_account WHERE Email = ? AND UserType='Passenger'";
            $stmtEmail = $conn->prepare($checkEmailQuery);
            $stmtEmail->bind_param("s", $email);
            $stmtEmail->execute();
            $resultEmail = $stmtEmail->get_result();

            if ($resultEmail->num_rows > 0) {
                throw new Exception("Email already exists.");
            }
            $stmtEmail->close();

            $insertUserQuery = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                            VALUES (?, ?, ?, ?, ?, 'Passenger', 'Password')";
            $stmtUser = $conn->prepare($insertUserQuery);
            $stmtUser->bind_param("sssss", $userID, $name, $email, $contact, $password);

            if (!$stmtUser->execute()) {
                throw new Exception("Failed to insert into user_account: " . $stmtUser->error);
            }
            $stmtUser->close();

            // Insert into admin
            $insertPassengerQuery = "INSERT INTO passenger(PassengerID, UserID) VALUES (?, ?)";
            $stmtPassenger = $conn->prepare($insertPassengerQuery);
            $stmtPassenger->bind_param("ss", $passengerId, $userID);
            if (!$stmtPassenger->execute()) {
                throw new Exception("Failed to insert into Passenger: " . $stmtPassenger->error);
            }
            $stmtPassenger->close();

            mysqli_commit($conn);
            return $passengerId;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage(), 3, '/Backend/error.log');

            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    // Auto increment passengerID
    public function generateNewPassengerID()
    {
        try {
            // Query to get the last inserted PassengerID
            $query = "SELECT PassengerID FROM passenger ORDER BY PassengerID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);
            $lastID = mysqli_fetch_assoc($result)['PassengerID'];

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
            $newID = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new PassengerID: " . $e->getMessage();
            return null;
        }
    }

    public function ViewPassenger(string $type)
    {
        $conn = $this->db->getConnection();
        try {
            // echo $return = "View Admin Data";
            $query = "SELECT * FROM passengerview WHERE status= ? ORDER BY PassengerID ASC; ";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $type);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_array = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'No Record Found']);
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function SearchPassenger(string $type, string $txtSearch)
    {
        $conn = $this->db->getConnection();
        try {
            $query = "SELECT * FROM passengerview WHERE status = ? 
                  AND (PassengerID LIKE ? OR Name LIKE ? OR Email LIKE ? OR Contact LIKE ?) 
                  ORDER BY PassengerID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("sssss", $type, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();

            $result = $stmt->get_result();
            $res_array = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'No Record Found']);
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function getUserDetail(string $Email)
    {
        $conn = $this->db->getConnection();
        try {


            // Prepare and execute the SQL query
            $stmt = $conn->prepare("SELECT * FROM user_account WHERE Email = ? AND UserType='Passenger'");
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            // If the user is found, return the details
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                return $user;
            } else {
                return false; // No matching user found
            }
        } catch (Exception $e) {
            // Log the error to a file
            error_log($e->getMessage(), 3, '/Backend/error.log');
            throw new Exception("An error occurred while getting user details.");
        } finally {
            // Always close the connection
            $this->db->disconnect();
        }
    }

    public function ChangePW(string $ID, string $Password)
    {
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Prepare and execute query to check if AdminID exists
            $stmt = $conn->prepare("SELECT UserID FROM user_account WHERE UserID = ?");
            $stmt->bind_param("s", $ID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("User does not exist.");
            }

            // Deactive from admin table
            $stmt2 = $conn->prepare("UPDATE  user_account SET Password = ?  WHERE UserID= ? ");
            $stmt2->bind_param("ss", $Password, $ID);
            $res2 = $stmt2->execute();

            if (!$res2) {

                throw new Exception("Failed to Update Password: " . mysqli_error($conn));
            }

            return true;
        } catch (Exception $e) {
            // error_log($e->getMessage(), 3, '/Backend/error.log'); 
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }



    public function getUserInfo($PassengerID)
    {
        // Prepare the SQL statement
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM passengerview WHERE PassengerID = ?");

        // Bind the parameter
        $stmt->bind_param("s", $PassengerID); // Assuming PassengerID is a string

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Fetch the user data
                return $result->fetch_assoc(); // Returns an associative array of the user data
            } else {
                return null; // No user found
            }
        } else {
            throw new Exception("Database query error: " . $stmt->error);
        }
    }

    public function updatePassengerInfo(string $passengerID, string $name, string $email, string $contact, string $password) {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);
    
            // Check if PassengerID exists
            $stmt = $conn->prepare("SELECT UserID FROM passenger WHERE PassengerID = ?");
            $stmt->bind_param("s", $passengerID);
            $stmt->execute();
            $res = $stmt->get_result();
    
            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }
    
            if ($res->num_rows == 0) {
                throw new Exception("PassengerID does not exist.");
            }
    
            // Get the UserID
            $row = mysqli_fetch_assoc($res);
            $userID = $row['UserID'];
    
            // Get current user data
            $stmt1 = $conn->prepare("SELECT * FROM user_account WHERE UserID = ?");
            $stmt1->bind_param("s", $userID);
            $stmt1->execute();
            $res1 = $stmt1->get_result();
            $row1 = mysqli_fetch_assoc($res1);
    
            $oldName = $row1['Name'];
            $oldEmail = $row1['Email'];
            $oldContact = $row1['Contact'];
            $oldPassword = $row1['Password'];
    
            // Update Name if it's changed
            if ($oldName !== $name) {
                $stmt2 = $conn->prepare("UPDATE user_account SET Name = ? WHERE UserID = ?");
                $stmt2->bind_param("ss", $name, $userID);
                if (!$stmt2->execute()) {
                    throw new Exception("Failed to update Name for user: $userID");
                }
            }
    
            // Update Email if it's changed
            if ($oldEmail !== $email) {
                $stmt3 = $conn->prepare("SELECT Email FROM user_account WHERE Email = ?");
                $stmt3->bind_param("s", $email);
                $stmt3->execute();
                $res3 = $stmt3->get_result();
    
                if ($res3->num_rows > 0) {
                    throw new Exception("Email already exists.");
                }
    
                $stmt4 = $conn->prepare("UPDATE user_account SET Email = ? WHERE UserID = ?");
                $stmt4->bind_param("ss", $email, $userID);
                if (!$stmt4->execute()) {
                    throw new Exception("Failed to update email for user: $userID");
                }
            }
    
            // Update Contact if it's changed
            if ($oldContact !== $contact) {
                $stmt5 = $conn->prepare("UPDATE user_account SET Contact = ? WHERE UserID = ?");
                $stmt5->bind_param("ss", $contact, $userID);
                if (!$stmt5->execute()) {
                    throw new Exception("Failed to update contact for user: $userID");
                }
            }
    
            // Update Password if it's changed
            if ($oldPassword !== $password) {
                $stmt6 = $conn->prepare("UPDATE user_account SET Password = ? WHERE UserID = ?");
                $stmt6->bind_param("ss", $password, $userID);
                if (!$stmt6->execute()) {
                    throw new Exception("Failed to update password for user: $userID");
                }
            }
    
            mysqli_commit($conn);
    
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            return false; // Indicate failure
        } finally {
            $this->db->disconnect();
        }
    }
    
}
