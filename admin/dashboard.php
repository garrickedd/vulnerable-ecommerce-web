<?php
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // admin dashboard content
} else {
    header("Location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .dashboard_sidebar{
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: gray;
        }
        .dashboard_sidebar ul li{
            list-style: none;
        }
        .dashboard_sidebar ul li a{
            text-decoration: none;
            color: white;
            display: block;
            padding: 15px;
        }
        .dashboard_main{
            margin-left: 200px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="dashboard_sidebar">
        <ul>
            <li><a href="addproduct.php">Add Product</a></li>
            <li><a href="displayproduct.php">View Products</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="dashboard_main">
        <div class="addproduct">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Beatae et, odio tempora corrupti molestias repellendus saepe voluptates, quia, nostrum accusantium cum ipsa illum. Voluptas corporis ea quisquam, hic harum aliquam?
        </div>
    </div>
</body>
</html>