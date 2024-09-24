<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";
class Admin extends User
{

    public function register(string $name, string $password, string $contact, string $email,string $creator)
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

            $adminID = $this->generateNewAdminID();
            if (!$adminID) {
                throw new Exception("Failed to generate a new admin ID.");
            }

            // Check if email already exists
            $checkEmailQuery = "SELECT Email FROM user_account WHERE Email = ? AND UserType='Admin'";
            $stmtEmail = $conn->prepare($checkEmailQuery);
            $stmtEmail->bind_param("s", $email);
            $stmtEmail->execute();
            $resultEmail = $stmtEmail->get_result();

            if ($resultEmail->num_rows > 0) {
                throw new Exception("Email already exists.");
            }

            // Insert into user_account
            $insertUserQuery = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                            VALUES (?, ?, ?, ?, ?, 'Admin', 'Password')";
            $stmtUser = $conn->prepare($insertUserQuery);
            $stmtUser->bind_param("sssss", $userID, $name, $email, $contact, $password);

            if (!$stmtUser->execute()) {
                throw new Exception("Failed to insert into user_account: " . $stmtUser->error);
            }

            // Insert into admin
            $insertAdminQuery = "INSERT INTO admin(AdminID, UserID, Creator) VALUES (?, ?, ?)";
            $stmtAdmin = $conn->prepare($insertAdminQuery);
            
            $stmtAdmin->bind_param("sss", $adminID, $userID, $creator);
            if (!$stmtAdmin->execute()) {
                throw new Exception("Failed to insert into admin: " . $stmtAdmin->error);
            }


            mysqli_commit($conn);
            return $adminID;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function Update(string $adminID, string $U_name, string $U_email, string $U_contact, string $U_Password)
    {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // check AdminID exists
            $stmt = $conn->prepare("SELECT UserID FROM admin WHERE AdminID = ?");
            $stmt->bind_param("s", $adminID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("AdminID does not exist.");
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

    public function ChangeStatusAdmin(string $adminID, string $status)
    {
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Prepare and execute query to check if AdminID exists
            $stmt = $conn->prepare("SELECT UserID FROM admin WHERE AdminID = ?");
            $stmt->bind_param("s", $adminID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("AdminID does not exist.");
            }

            // Deactive from admin table
            $stmt2 = $conn->prepare("UPDATE  admin SET status='$status' WHERE AdminID= ? ");
            $stmt2->bind_param("s", $adminID);
            $res2 = $stmt2->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate Admin: " . mysqli_error($conn));
                } else {
                    throw new Exception("Failed to Activate Admin: " . mysqli_error($conn));
                }
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log'); // Specify a path to log errors
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function generateNewAdminID()
    {
        $conn = $this->db->getConnection();
        try {
            // Query to get the last inserted AdminID
            $query = "SELECT AdminID FROM admin ORDER BY AdminID DESC LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            // $row = mysqli_fetch_assoc($result);
            $lastID = mysqli_fetch_assoc($result)['AdminID'];

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1)); // Assumes prefix 'A' is 1 characters
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'A' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'A001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new AdminID: " . $e->getMessage();
            return null;
        }
    }

    public function ViewAdmin(string $type)
    {
        $conn = $this->db->getConnection();
        try {
            // echo $return = "View Admin Data";
            $queary = "SELECT * FROM adminview WHERE status= ? ORDER BY AdminID ASC; ";
            $stmt = $conn->prepare($queary);
            $stmt->bind_param("s", $type);
            $stmt->execute();
            $result = $stmt->get_result();
            $res_array = [];

            if (mysqli_num_rows($result) > 0) {
                foreach ($result as $row) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['message' => 'No Record Found']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/Backend/error.log');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function Search(string $type, string $txtSearch)
    {
        $conn = $this->db->getConnection();
        try {
            // echo $return = "View Admin Data";
            $queary = "SELECT * FROM adminview WHERE status='$type' AND (AdminID like '%$txtSearch%' OR Name like '%$txtSearch%' OR Email like '%$txtSearch%' OR Contact like '%$txtSearch%') ORDER BY AdminID ASC; ";
            $queary_run = mysqli_query($conn, $queary);
            $res_array = [];

            if (mysqli_num_rows($queary_run) > 0) {
                foreach ($queary_run as $row) {
                    array_push($res_array, $row);
                }
                header('Content-type: application/json');
                echo json_encode($res_array);
            } else {
                header('Content-type: application/json');
                echo json_encode(['success' => false, 'message' => 'No Record Found']);
            }
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
            $stmt = $conn->prepare("SELECT UserID FROM admin WHERE AdminID = ?");
            $stmt->bind_param("s", $ID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("AdminID does not exist.");
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

            $stmt3 = $conn->prepare("UPDATE admin SET PasswordStatus = '0' WHERE AdminID = ?");
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
