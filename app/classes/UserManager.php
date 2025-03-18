<?php

    class UserManager {

        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function insertUser($username, $password) {

            //regex for username
            $userNameRegex = "/^[a-zA-Z0-9]*$/";
            
            if(!preg_match($userNameRegex, $username)) {
                echo "Invalid username";
                return;
            }

            //prepare statement
            $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

        }

        public function getUser($username) {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch();
            
        }

    }


?>