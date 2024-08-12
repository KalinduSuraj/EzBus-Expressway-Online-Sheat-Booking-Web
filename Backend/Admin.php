<?php

class Admin extends User
{

    public function register(string $name, string $password, string $contact, string $email)
    {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->db->getConnection());

            // Auto increment userID
            $userID = $this->userIDIncrement();
            $adminId = $this->AdminIDIncrement();



            // Registration process
            $sql2 = "SELECT Email FROM user WHERE Email='$email'";
            $res = mysqli_query($this->db->getConnection(), $sql2);

            if (!(mysqli_num_rows($res) == 1)) {
                // Insert queries
                $query1 = "INSERT INTO user_account(UserID, Name, Email, Contact, Password, UserType) VALUES('$userID', '$name', '$email', '$contact', '$password', 'Passenger')";
                $query2 = "INSERT INTO admin VALUES('$adminId', '$userID')";

                $result1 = mysqli_query($this->db->getConnection(), $query1);
                $result2 = mysqli_query($this->db->getConnection(), $query2);

                if ($result1 && $result2) {
                    mysqli_commit($this->db->getConnection());
                    echo "<script> console.log('Added'); </script>";
                    echo "<script>alert('Admin Registered Successfully');</script>";

                    // Redirection file->
                    // echo "<script>window.location.href = 'signIn.php';</script>";
                } else {
                    mysqli_rollback($this->db->getConnection());
                    echo "<script> alert('not Added'); </>";
                }
                return true;
            } else {
                echo "<script> alert('there is the Admin in this $email'); </script>";
                mysqli_rollback($this->db->getConnection());
                return false;
            }
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            echo $e;
        } finally {
            $this->db->disconnect();
        }
    }
    private function AdminIDIncrement()
    {

        try {
            // Query to get the last inserted UserID
            $query = "SELECT AdminID FROM admin ORDER BY AdminID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);
            $lastID = mysqli_fetch_assoc($result)['AdminID'];

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
            $newID = 'A' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            return $newID;
        } catch (Exception $e) {
            echo "Error generating new UserID: " . $e->getMessage();
            return null;
        }
    }
}
