<?php
class DBConnection
{
    //*------------------------------------------------|DONE|----------------------------------------------
    private $connection;

    public function connect()
    {
        //awardspace.net
        $this->connection = mysqli_connect("fdb1029.awardspace.net", "4500036_ezbus", "EzBus@1234", "4500036_ezbus");
        if (!$this->connection) {
            echo "Connection failed: " . mysqli_connect_error();
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
        return $this->connection;
    }
}
