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
            if (!$userID) {
                throw new Exception("Failed to generate a new user ID.");
            }

            $adminID = $this->generateNewAdminID();
            if (!$adminID) {
                throw new Exception("Failed to generate a new admin ID.");
            }

            // Check if email already exists
            $sql2 = "SELECT Email FROM user_account WHERE Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!$res) {
                throw new Exception("Database query failed: " . mysqli_error($this->db->getConnection()));
            }

            if (mysqli_num_rows($res) > 0) {
                throw new Exception("Email already exists.");
            }

            // Insert queries
            $query1 = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType, LoginType) 
                   VALUES('$userID', '$name', '$email', '$contact', '$password', 'Admin', 'Password')";
            $query2 = "INSERT INTO admin(AdminID, UserID, Creator) 
                   VALUES('$adminID', '$userID', 'A001')"; // Change the Creator ID

            $result1 = mysqli_query($this->db->getConnection(), $query1);
            if (!$result1) {
                throw new Exception("Failed to insert into user_account: " . mysqli_error($this->db->getConnection()));
            }

            $result2 = mysqli_query($this->db->getConnection(), $query2);
            if (!$result2) {
                throw new Exception("Failed to insert into admin: " . mysqli_error($this->db->getConnection()));
            }

            // Commit the transaction if both inserts were successful
            mysqli_commit($this->db->getConnection());
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            error_log($e->getMessage(), 3, '/Backend/error.log'); // Specify a path to log errors
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }

    public function delete(string $adminID)
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

            // Get the UserID
            $row = mysqli_fetch_assoc($res);
            $userID = $row['UserID'];

            // Delete from admin table
            $query1 = "DELETE FROM admin WHERE AdminID='$adminID'";
            $result1 = mysqli_query($conn, $query1);
            if (!$result1) {
                throw new Exception("Failed to delete from admin: " . mysqli_error($conn));
            }

            // Delete from user_account table
            $query2 = "DELETE FROM user_account WHERE UserID='$userID'";
            $result2 = mysqli_query($conn, $query2);
            if (!$result2) {
                throw new Exception("Failed to delete from user_account: " . mysqli_error($conn));
            }

            // Commit the transaction if both deletions were successful
            mysqli_commit($conn);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log($e->getMessage(), 3, '/Backend/error.log'); // Specify a path to log errors
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            $this->db->disconnect();
        }
    }




    public function generateNewAdminID()
    {
        try {
            // Query to get the last inserted AdminID
            $query = "SELECT AdminID FROM admin ORDER BY AdminID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);

            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($this->db->getConnection()));
            }

            $row = mysqli_fetch_assoc($result);
            $lastID = $row ? $row['AdminID'] : null;

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

    public function ViewAdmin()
    {
        // echo $return = "View Admin Data";
        $queary = "SELECT * FROM adminview ORDER BY AdminID ASC";
        $queary_run = mysqli_query($this->db->getConnection(), $queary);
        $res_array = [];

        if (mysqli_num_rows($queary_run) > 0) {
            foreach ($queary_run as $row) {
                array_push($res_array, $row);
            }
            header('Content-type: application/json');
            echo json_encode($res_array);
        } else {
            echo $return = "<h4>No Record Found</h4>";
        }
    }
}
