<?php
    abstract class Model 
    {
        public $db_server      = 'localhost';
        public $db_name        = 'amart';
        public $db_user        = 'root';
        public $db_password    = '';
        public $conn;

        function __construct() 
        {
            $this->conn = new mysqli($this->db_server, $this->db_user, $this->db_password, $this->db_name);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            mysqli_set_charset($this->conn, "utf8");
            $method = $_SERVER['REQUEST_METHOD'];
        }

        function showDB()
        {
            return $this->db_name;
        }

        
    }

?>