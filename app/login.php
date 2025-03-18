<?php

    session_start();

    //spl autoload register classes in /classes
    spl_autoload_register(function ($className) {
        require_once 'classes/' . $className . '.php';
    });

    $db = new Database();
    $userManager = new UserManager($db->getConnection());

    //if server method request is post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //if register button is clicked
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $userManager->insertUser($username, $password); 
        }

        //if login button is clicked
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $userManager->getUser($username);

            if (password_verify($password, $user['password'])) {
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                echo "Login failed";
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='./css/login.css'>
</head>
<body>

    <form method="POST">
        <h1>REGISTER</h1>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password"><br>
        <input type="submit" value="Register" name="register">
    </form>

    <form method="POST">
        <h1>LOGIN</h1>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password"><br>
        <input type="submit" value="Login" name="login">
    </form>
    
</body>
</html>