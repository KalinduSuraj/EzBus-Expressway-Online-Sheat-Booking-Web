<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";

class Counter extends User
{
    public function register(string $name, string $password, string $contact, string $email, string $location,string $AdminID)
    {
        $con = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($con);

            // Auto increment userID
            $userID = $this->userIDIncrement();
            if (!$userID) {
                throw new Exception("Failed to generate a new user ID.");
            }

            $counterID = $this->generateNewCounterID();
            if (!$counterID) {
                throw new Exception("Failed to generate a new Counter ID.");
            }

            // Check if email already exists
            $checkEmailQuery = "SELECT Email FROM user_account WHERE Email = ?";
            $stmt = $con->prepare($checkEmailQuery);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($con));
            }

            if ($result->num_rows > 0) {
                throw new Exception("Email already exists.");
            }

            // Insert into user_account
            $insertUserQuery = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                            VALUES (?, ?, ?, ?, ?, 'Counter', 'Password')";
            $stmtUser = $con->prepare($insertUserQuery);
            $stmtUser->bind_param("sssss", $userID, $name, $email, $contact, $password);
            if (!$stmtUser->execute()) {
                throw new Exception("Failed to insert into user_account: " . $stmtUser->error);
            }

            // Insert into counter
            $insertCounterQuery = "INSERT INTO counter(CounterID, UserID, AdminID, Location) VALUES (?, ?, ?, ?)";
            $stmtCounter = $con->prepare($insertCounterQuery);
            
            $stmtCounter->bind_param("ssss", $counterID, $userID,$AdminID, $location);
            if (!$stmtCounter->execute()) {
                throw new Exception("Failed to insert into counter: " . $stmtCounter->error);
            }

            // Commit the transaction if both inserts were successful
            mysqli_commit($con);
            return $counterID;
        } catch (Exception $e) {
            mysqli_rollback($con);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            
        } finally {
            $this->db->disconnect();
        }
    }

    public function Update(string $counterID,string $U_name, string $U_email, string $U_contact, string $U_Password)
    {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // check CounterID exists
            $stmt = $conn->prepare("SELECT UserID FROM Counter WHERE CounterID = ?");
            $stmt->bind_param("s", $counterID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("CounterID does not exist.");
            }

            // Get the UserID
            $row = mysqli_fetch_assoc($res);
            $userID = $row['UserID'];

            // get user data
            $stmt1 = $conn->prepare("SELECT * FROM user_account WHERE UserID= ?");
            $stmt1->bind_param("s", $userID);
            $stmt1->execute();
            $res1 = $stmt1->get_result();
            $row1 = mysqli_fetch_assoc($res1);

            $oldName = $row1['Name'];
            $oldEmail = $row1['Email'];
            $oldContact = $row1['Contact'];
            $oldPassword = $row1['Password'];

            // Update Name if it's changed
            if ($oldName !== $U_name) {
                $stmt4 = $conn->prepare("UPDATE user_account SET Name = ? WHERE UserID = ?");
                $stmt4->bind_param("ss", $U_name, $userID);
                if (!$stmt4->execute()) {
                    throw new Exception("Failed to update Name for user: $userID");
                }
            }

            // Update Email if it's changed
            if ($oldEmail !== $U_email) {
                $stmt2 = $conn->prepare("SELECT Email FROM user_account WHERE Email = ?");
                $stmt2->bind_param("s", $U_email);
                $stmt2->execute();
                $res2 = $stmt2->get_result();

                if ($res2->num_rows > 0) {
                    throw new Exception("Email already exists.");
                }

                $stmt3 = $conn->prepare("UPDATE user_account SET Email = ? WHERE UserID = ?");
                $stmt3->bind_param("ss", $U_email, $userID);
                if (!$stmt3->execute()) {
                    throw new Exception("Failed to update email for user: $userID");
                }
            }

            // Update Contact if it's changed
            if ($oldContact !== $U_contact) {
                $stmt4 = $conn->prepare("UPDATE user_account SET Contact = ? WHERE UserID = ?");
                $stmt4->bind_param("ss", $U_contact, $userID);
                if (!$stmt4->execute()) {
                    throw new Exception("Failed to update contact for user: $userID");
                }
            }

            // Update Password if it's changed
            if ($oldPassword !== $U_Password) {
                $stmt5 = $conn->prepare("UPDATE user_account SET Password = ? WHERE UserID = ?");
                $stmt5->bind_param("ss", $U_Password, $userID);
                if (!$stmt5->execute()) {
                    throw new Exception("Failed to update password for user: $userID");
                }
            }

            mysqli_commit($conn);

            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
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

    public function ViewCounter(string $type)
    {
        try {
            $query = "SELECT * FROM counterview WHERE status = ? ORDER BY CounterID ASC";
            $stmt = $this->db->getConnection()->prepare($query);
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


    public function generateNewCounterID()
    {
        $conn = $this->db->getConnection();
        try {
            // get the last  CounterID
            $query = "SELECT CounterID FROM counter ORDER BY CounterID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['CounterID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 4)); // Assumes prefix 'COU-' is 4 characters
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

    public function ChangeStatusCounter(string $counterID, string $status)
    {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // Prepare and execute query to check if counterID exists
            $stmt = $conn->prepare("SELECT UserID FROM counter WHERE CounterID = ?");
            $stmt->bind_param("s", $counterID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("counterID does not exist.");
            }

            // Deactive from counter table
            $stmt2 = $conn->prepare("UPDATE  counter SET status='$status' WHERE CounterID= ? ");
            $stmt2->bind_param("s", $counterID);
            $res2 = $stmt2->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate counter: " . mysqli_error($conn));
                } else {
                    throw new Exception("Failed to Activate counter: " . mysqli_error($conn));
                }
            }
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function Search(string $type, string $txtSearch)
    {
        $conn = $this->db->getConnection();
        try {
            $query = "SELECT * FROM counterview WHERE status = ? 
                  AND (Location LIKE ? OR CounterID LIKE ? OR Name LIKE ? OR Email LIKE ? OR Contact LIKE ?) 
                  ORDER BY CounterID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("ssssss", $type, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
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

    public function ChangePW(string $ID, string $Password)
    {
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Check AdminID exists
            $stmt = $conn->prepare("SELECT UserID FROM counter WHERE CounterID = ?");
            $stmt->bind_param("s", $ID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("CounterID does not exist.");
            }

            // Get the UserID
            $row = mysqli_fetch_assoc($res);
            $userID = $row['UserID'];

            // Update password in user_account table
            $stmt2 = $conn->prepare("UPDATE user_account SET Password = ? WHERE UserID = ?");
            $stmt2->bind_param("ss", $Password, $userID);
            $res2 = $stmt2->execute();

            if (!$res2) {
                throw new Exception("Failed to update password: " . mysqli_error($conn));
            }

            $stmt3 = $conn->prepare("UPDATE counter SET PasswordStatus = '0' WHERE CounterID = ?");
            $stmt3->bind_param("s", $ID);
            $res3 = $stmt3->execute();

            if (!$res3) {
                throw new Exception("Failed to update password: " . mysqli_error($conn));
            }

            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);  // Rollback transaction in case of failure
            error_log($e->getMessage());
            return false;
        } finally {
            $this->db->disconnect();
        }
    }
}
