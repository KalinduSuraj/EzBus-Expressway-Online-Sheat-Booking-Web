<?php
require_once __DIR__ . "/DBConnection.php";

class Driver
{

    protected $db;


    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db->connect();
    }

    //Generate New Driver ID
    public function generateNewDriverID()
    {
        try {
            // Query to get the last inserted DriverID
            $query = "SELECT DriverID FROM driver ORDER BY DriverID DESC LIMIT 1";
            $result = mysqli_query($this->db->getConnection(), $query);
            $lastID = mysqli_fetch_assoc($result)['DriverID'];
            
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
            $newID = 'D' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            

            return $newID;
        } catch (Exception $e) {
            echo "Error generating new DriverID: " . $e->getMessage();
            return null;
        }
    }

    //Add Driver
    public function AddDriver($name, $contact)
    {
        try {
            // Begin transaction
            mysqli_begin_transaction($this->db->getConnection());


            $driverID = $this->generateNewDriverID();
            if (!$driverID) {
                throw new Exception("Failed to generate a new admin ID.");
            }
            // Insert queries
            $query1 = "INSERT INTO driver(DriverID, Name,Contact) VALUES('$driverID', '$name',  '$contact')";

            $result1 = mysqli_query($this->db->getConnection(), $query1);
            if (!$result1) {
                throw new Exception("Failed to insert into driver : " . mysqli_error($this->db->getConnection()));
            }
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->db->getConnection());
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $this->db->disconnect();
        }
    }
    //Update Driver

}
