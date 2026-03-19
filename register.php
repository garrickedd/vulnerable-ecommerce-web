<?php
include 'connect.php';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = "user";

    $sql = "INSERT INTO users (name, email, password, phone, address, role) VALUES ('$name', '$email', '$password', '$phone', '$address', '$role')";
    
    try {
        $pdo->exec($sql);
        // echo "New record created successfully";
    } catch (\PDOException $e) {
        echo $e->getMessage();
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
        .registerdiv{
            margin-top: 200px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: center;
            /* align-items: center; */
            /* margin-top: 100px; */
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
        .registerdiv input{
            display: block;
            padding: 15px;
            margin: 8px;
            /* width: 300px; */
        }
        .registerdiv textarea{
            display: block;
            padding: 15px;
            margin: 8px;
            width: 171px;
        }
        .button{
            width: 200px;
            background-color: green;
            border: none;
        }
        .button:hover{
            background-color: darkorange;
        }
        .registerdiv a{
            text-decoration: none;
            color: white;
            background-color: lightgreen;
            padding: 10px;
            margin: 2px;
        }
    </style>
</head>
<body>
<a class="shoplink" href="index.php">Shop</a>
    <div class="registerdiv">
        <form action="register.php" method="post">
            <input type="text" name="name" placeholder="Enter your Name here!" required>
            <input type="email" name="email" placeholder="Enter your Email here!" required>
            <input type="password" name="password" placeholder="Enter your Password here!" required>
            <input type="phone" name="phone" placeholder="Enter your Number here!" required>
            <textarea name="address" placeholder="Enter your Address here!"></textarea>
            <input class="button" type="submit" name="submit" value="sign up">
            <p>go for login<a href="login.php">Login</a></p>
        </form>
    </div>
    
</body>
</html>