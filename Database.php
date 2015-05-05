<?php

class Database()
{
    $connection = "";

    /**
     * Establishes connection to the specified MySQL database and stores this
     * connection in the $connection class variable to be used later.
     * @param  String $host     Host to connect to
     * @param  String $username Username to authenticate with
     * @param  String $password Password to authenticate with
     * @param  String $database Database to connect to
     */
    public function connect_to_db($host, $username, $password, $database) 
    {
        $this->$connection = new mysqli($host, $username, $password, $database);
        if ($this->$connection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
    } 

    /**
     * Checks to see if the passed in variable is currently connected to a MySQL database.
     * @param  DB_Connection  $db_connection The connection to test
     * @return boolean                       Returns true if it is connected, false otherwise
     */
    public function is_connected($db_connection)
    {
        if($db_connection->ping() !== false) {
            return true;
        }
        return false;
    }
}

?>