<?php 

include_once '/xampp/htdocs/auth_rest/inc/config.php';

class Database {

public $conn;

    function __construct(){
        $this->connect();
       }

        //db connect
        public function connect() {
            try {
                $this->conn = new PDO(HOST, DB_USER, DB_PASS);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo 'Connection Error '. $e->getMessage();
            }
        }

    }