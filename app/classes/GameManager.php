<?php

    class GameManager {
        
        private $conn;

        public function __construct(Database $db) { 
            $this->conn = $db->getConnection();
        }

        public function insertGame($data) {

            $title = htmlspecialchars($data['title']);
            $developer = htmlspecialchars($data['developer']);
            $publisher = htmlspecialchars($data['publisher']);
            $genre = htmlspecialchars($data['genre']);
            $platform = $data['platform'];
            $release_date = $data['release_date'];
            $rating = $data['rating'];
            $image = $data['image'];

            $title_error = $developer_error = $publisher_error = $genre_error = null;

            $regex = "/^[A-Z][a-z]*$/";
            
            if (!preg_match($regex, $title)) {
                $title_error = "Title is invalid";
            }

            if (!preg_match($regex, $developer)) {
                $developer_error = "Developer is invalid";
            }

            if (!preg_match($regex, $publisher)) {
                $publisher_error = "Publisher is invalid";
            }

            if (!preg_match($regex, $genre)) {
                $genre_error = "Genre is invalid";
            }

            //if any error is not null, echo that error and stop function
            if ($title_error || $developer_error || $publisher_error || $genre_error) {
                echo $title_error;
                echo $developer_error;
                echo $publisher_error;
                echo $genre_error;
                return;
            }

            $sql = "INSERT INTO games (title, developer, publisher, genre, platform, release_date, rating, image) 
            VALUES (:title, :developer, :publisher, :genre, :platform, :release_date, :rating, :image)";

            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':developer', $developer);
                $stmt->bindParam(':publisher', $publisher);
                $stmt->bindParam(':genre', $genre);
                $stmt->bindParam(':platform', $platform);
                $stmt->bindParam(':release_date', $release_date);
                $stmt->bindParam(':rating', $rating);
                $stmt->bindParam(':image', $image);
                $stmt->execute();
            } catch(PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }

        public function selectAllGames() {

            $games = [];
            $sql = "SELECT * FROM games";

            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                //fethmode assoc
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll();
                
                //for each result make new game object also include id
                foreach ($result as $row) {
                    $game = new Game($row['id'], $row['title'], $row['developer'], $row['publisher'], $row['genre'], $row['platform'], $row['release_date'], $row['rating'], $row['image']);
                    array_push($games, $game);
                }

                return $games;
                
            } catch(PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }


        public function fileUpload($file) {
            //put imagefile in folder: images

            //check if file is not empty
            if (empty($file)) {
                echo "Please select a file";
                return false;
            }
            //first check if file is image
            if (!getimagesize($file['tmp_name'])) {
                echo "File is not an image";
                return false;
            }
            //then check if file is .jpg or .jpeg or .gif or .webp or .png
            if ($file['type'] != "image/jpeg" && $file['type'] != "image/jpg" && $file['type'] != "image/gif" && $file['type'] != "image/webp" && $file['type'] != "image/png") {
                echo "Filetype not allowed, must be .jpg, .jpeg, .gif, .webp or .png";
                return false;
            }
            //then check if file is less than 5mb
            if($file['size'] > 5000000) {
                echo "File is too large, must be less than 5mb";
                return false;
            }
            //check if file allready exists
            if (file_exists($file['name'])) {
                echo "File allready exists";
                return false;
            }

            $target_dir = "images/";
            $target_file = $target_dir . basename($file["name"]);
            $uploadOk = 1;



        }
    }

?>