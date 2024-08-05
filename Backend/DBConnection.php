<?php
class DBConnection
{
    //*------------------------------------------------|DONE|----------------------------------------------
    private $connection;

    public function connect()
    {
        // $conn = new mysqli($servername, $username, $password, $dbname);

        // infinityfree connection
        //$conn = new mysqli('sql305.infinityfree.com', 'if0_36817372', 'YOmTan81T2kFf', 'if0_36817372_ezbusdb');

        //Kalindu's db
        $conn = mysqli_connect("localhost", "suraj", "20030115", "ezbusdb");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            echo "<script> console.log('Database connection failed'); </script>";
        }
        //echo "Connected successfully";
        echo "<script> console.log('Database connection successful'); </script>";
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
        return $this->connection;
    }
}

// $db = new DBConnection();
// $db->connect();
// $conn = $db->getConnection();

// // Perform database operations here

// $db->disconnect();
?>

