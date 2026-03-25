<?php
include 'connect.php';

session_start();

// back to home after login
if (isset($_SESSION['user_id']) || isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

$message = '';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    // echo $email;
    // echo $password;

    $sql = "SELECT * FROM users WHERE name='$name' AND password='$password'";

    try {
        $stmt = $pdo->query($sql);
        $user = $stmt->fetch();

        if($user){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            $message = "Login successful!";
            if($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
        } else {
            $message = "Invalid email or password.";
        }
    } catch (\PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .login{
            margin-top: 200px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: center;
            /* align-items: center; */
            /* margin-top: 100px; */
        }

        .login input{
            display: block;
            padding: 15px;
            margin: 8px;
            /* width: 300px; */
        }
        .login a{
            text-decoration: none;
            color: white;
            background-color: lightgreen;
            padding: 10px;
            margin: 2px;
        }
        .button{
            width: 200px;
            background-color: green;
            border: none;
        }
        .shoplink{
            display: block;
            width: 100px;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            text-decoration: none;
            background-color: lightgreen;
            color: white;
            padding: 10px;
            /* margin: 2px; */
        }

    </style>
</head>
<body>
<a class="shoplink" href="index.php">Shop</a>
    <div class="login">
        <form action="login.php" method="post">
            <input type="name" name="name" placeholder="Enter your Name here!" required>
            <input type="password" name="password" placeholder="Enter your Password here!" required>
            <!-- <button type="submit" name="submit" value="login">Login</button> -->
            <input class="button" type="submit" name="submit" value="login">
            <p>Let try first!<a href="register.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>