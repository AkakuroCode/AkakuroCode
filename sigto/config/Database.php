<?php
class Database {
    private $host = "db";
    private $db_name = "oceantrade";
    private $username;
    private $password;
    private $conn;

    public function __construct($role = 'guest') {
        switch ($role) {
            case 'admin':
                $this->username = 'dba_user';
                $this->password = 'password_dba';
                break;
            case 'user':
                $this->username = 'app_user';
                $this->password = 'password_app';
                break;
            default:
                // $this->username = 'guest_user';
                // $this->password = 'password_guest';
                $this->username = 'root';
                $this->password = '';
                break;
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getHost() {
        return $this->host;
    }

    public function getDbName() {
        return $this->db_name;
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                throw new Exception("Error en la conexión: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $this->conn;
    }
}
