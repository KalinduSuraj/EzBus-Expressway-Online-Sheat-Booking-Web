<?php
class DBConnection
{
    //*------------------------------------------------|DONE|----------------------------------------------
    private $connection;

    public function connect()
    {
        
       // Kalindu's db
       $this->connection = mysqli_connect("localhost", "suraj", "20030115", "ezbusdb");
        
        //$conn = mysqli_connect("localhost", "chanuka", "Chanuka@20021004", "ezbus");

        // Check connection
        if (!$this->connection) {
            echo "Database connection failed";
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    public function disconnect()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
            $this->connection = null; // Unset the connection object
        }
    }

    // Method to get the connection object
    public function getConnection()
    {
        $this->connect();
        return $this->connection;
    }
}

// $db = new DBConnection();

// $conn = $db->getConnection();

// // Perform database operations here

// $db->disconnect();
?>

