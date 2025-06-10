<?php

session_start();

//check if username and or userid is set in SESSION
if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

//spl autoload register classes in /classes
spl_autoload_register(function ($className) {
    require_once 'classes/' . $className . '.php';
});

$db = new Database();
$gm = new GameManager($db);

//if server method request is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //if logout button is clicked
    if (isset($_POST['logout'])) {
        //unset session variables
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    //if add game button is clicked
    if(isset($_POST['add-game'])) {
        //fileupload
        if($gm->fileUpload($_FILES['image'])) {
            echo "File uploaded";
        } else {
            echo "File not uploaded";
        }
        //insert game into database
        $gm->insertGame($_POST, $_FILES['image']['name']);
    }
    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>

        
    <div id='main-container'>

        <div id="uitlogknop">
            <form method="POST">
                <input type="submit" value="Logout" name="logout">
            </form>
        </div>

        <div id='side-bar'>
            <h2>Game Manager</h2>
            <div id='add-game'>
                ADD GAME
            </div>
        </div>


        <div id='content'>
            <h2>Games</h2>

            <div id='game-list'>
                <?php
                    $games = $gm->selectAllGames();
                    foreach ($games as $game) {
                        echo "<div class='game-image-container'>";
                        echo "<img class='game-image' src='uploads/" . $game->getImage() . "'>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>

    </div>


    <div id='form-container'>
        <div id='form' method='POST' enctype='multipart/form-data'>
            <input type='text' name='title' placeholder='Title' required>
            <input type='text' name='developer' placeholder='Developer' required>
            <input type='text' name='publisher' placeholder='Publisher' required>
            <input type='text' name='genre' placeholder='Genre' required>
            <input type='text' name='platform' placeholder='Platform' required>
            <input type='date' name='release_date' placeholder='Release date' required>
            <input type='number' name='rating' placeholder='Rating' min='0' max='10' required>
            <input type='file' name='image' placeholder='Image' required>
            <input type='submit' name='submit' value='Add Game' name='add-game'>
        </div>
    </div>



</body>
</html>