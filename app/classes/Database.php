<?php

    class Database {

        private $servername = "mysql";
        private $username = "root";
        private $password = "root";
        private $dbname = "gamelibrary";
        private $conn;

        public function __construct() {
            //make new connection using $this->conn
            //mysqli object oriented, use try and catch
            try {
                $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            //if not exists create table users, with id (auto increment), username, password
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL,
                password VARCHAR(255) NOT NULL
            );";

            $this->conn->exec($sql);

            //if not exists create table games, with id (auto increment), title, description, image
            $sql = "CREATE TABLE IF NOT EXISTS games (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(30) NOT NULL,
                description TEXT NOT NULL,
                image VARCHAR(255) NOT NULL
            )";

            $this->conn->exec($sql);

            //if not exist create table user_games with id (auto increment), user_id, game_id
            //include foreign keys
            $sql = "CREATE TABLE IF NOT EXISTS user_games (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(6) UNSIGNED,
                game_id INT(6) UNSIGNED,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (game_id) REFERENCES games(id)
            )";
            
            $this->conn->exec($sql);

        }

        public function getConnection() {
            return $this->conn;
        }
    }