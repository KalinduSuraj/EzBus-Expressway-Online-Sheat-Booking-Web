<?php
require_once __DIR__ . "/DBConnection.php";
require_once __DIR__ . "/User.php";
class Conductor extends User
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

            $conductorID = $this->generateNewConductorID();
            if (!$conductorID) {
                throw new Exception("Failed to generate a new conductor ID.");
            }

            // Check if email already exists
            $checkEmailQuery = "SELECT Email FROM user_account WHERE Email = ?";
            $stmt = $conn->prepare($checkEmailQuery);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($result->num_rows > 0) {
                throw new Exception("Email already exists.");
            }

            // Insert into user_account
            $insertUserQuery = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                            VALUES (?, ?, ?, ?, ?, 'Conductor', 'Password')";
            $stmtUser = $conn->prepare($insertUserQuery);
            $stmtUser->bind_param("sssss", $userID, $name, $email, $contact, $password);
            if (!$stmtUser->execute()) {
                throw new Exception("Failed to insert into user_account: " . $stmtUser->error);
            }

            // Insert into conductor
            $insertConductorQuery = "INSERT INTO conductor(ConductorID, UserID, AdminID) VALUES (?, ?, ?)";
            $stmtConductor = $conn->prepare($insertConductorQuery);
            $LogedUserID = "A001";
            $stmtConductor->bind_param("sss", $conductorID, $userID, $LogedUserID);

            if (!$stmtConductor->execute()) {
                throw new Exception("Failed to insert into conductor: " . $stmtConductor->error);
            }

            // Commit the transaction if both inserts were successful
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

    public function Update(string $conductorID, string $U_name, string $U_email, string $U_contact, string $U_Password)
    {
        $conn = $this->db->getConnection();
        try {
            mysqli_begin_transaction($conn);

            // check ConductorID exists
            $stmt = $conn->prepare("SELECT UserID FROM conductor WHERE ConductorID = ?");
            $stmt->bind_param("s", $conductorID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("ConductorID does not exist.");
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

    public function ViewConductor(string $type)
    {
        try {
            $query = "SELECT * FROM conductorview WHERE status = ? ORDER BY ConductorID ASC";
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

    public function generateNewConductorID()
    {
        try {
            // Query to get the last inserted CounterID
            $query = "SELECT ConductorID FROM conductor ORDER BY ConductorID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($this->db->getConnection()));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['ConductorID'] : null;

            if ($lastID) {
                // Ensure the prefix is correctly ignored
                $number = intval(substr($lastID, 1));
                // Increment the number
                $newNumber = $number + 1;
                $newID = 'C' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist
                $newID = 'C001';
            }

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new CounterID: " . $e->getMessage();
            return null;
        }
    }

    public function ChangeStatusConductor(string $conductorID, string $status)
    {
        $conn = $this->db->getConnection();
        try {
            // Begin transaction
            mysqli_begin_transaction($conn);

            // Prepare and execute query to check if conductorID exists
            $stmt = $conn->prepare("SELECT UserID FROM conductor WHERE ConductorID = ?");
            $stmt->bind_param("s", $conductorID);
            $stmt->execute();
            $res = $stmt->get_result();

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }

            if ($res->num_rows == 0) {
                throw new Exception("ConductorID does not exist.");
            }

            // Deactive from conductor table
            $stmt2 = $conn->prepare("UPDATE  conductor SET status='$status' WHERE ConductorID= ? ");
            $stmt2->bind_param("s", $conductorID);
            $res2 = $stmt2->execute();

            if (!$res2) {
                if ($status == 0) {
                    throw new Exception("Failed to Deactivate conductor: " . mysqli_error($conn));
                } else {
                    throw new Exception("Failed to Activate conductor: " . mysqli_error($conn));
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

    public function Search(string $type, string $txtSearch)
    {
        $conn = $this->db->getConnection();
        try {
            $query = "SELECT * FROM conductorview 
                  WHERE status = ? 
                  AND ( ConductorID LIKE ? OR Name LIKE ? OR Email LIKE ? OR Contact LIKE ?) 
                  ORDER BY ConductorID ASC";

            $stmt = $conn->prepare($query);
            $searchTerm = '%' . $txtSearch . '%';
            $stmt->bind_param("sssss", $type,  $searchTerm, $searchTerm, $searchTerm, $searchTerm);
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
}
