<?php
session_start();

include "../connect.php";

if(isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {

    $sql1 = "SELECT * FROM categories";
    try {
        $stmt1 = $pdo->query($sql1);
        $categories = $stmt1->fetchAll();
    } catch (\PDOException $e) {
        echo $e->getMessage();
    }

    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $image = $_FILES['image']['name'];
        $temp_location = $_FILES['image']['tmp_name'];
        $upload_location = "../image/";
        // $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];

        $sql = "INSERT INTO products (name, description, price, stock, image, category_id, category_name) VALUES ('$name', '$description', '$price', '$stock', '$image', NULL, '$category_name')";

        try {
            $pdo->exec($sql);
            // echo "New record created successfully";
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
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
        .dashboard_main input{
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            width: 300px;
        }
        .dashboard_main select{
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            width: 320px;
        }
        .dashboard_main textarea{
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            width: 300px;
            height: 100px;
        }
        .button{
            padding: 10px 20px;
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
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
        <form action="addproduct.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="enter product name">
            <textarea name="description" placeholder="enter product description"></textarea>
            <input type="number" name="price" placeholder="enter price">
            <input type="number" name="stock" placeholder="enter stock number">
            <input type="file" name="image">

            <!-- <select name="category_id">
                <option value="">Select Category</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select> -->
            <select name="category_name">
                <option value="">Select Category</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <!-- <select name="">
                <option value="category_name">category_name</option>
            </select> -->


            <input type="submit" name="submit" value="add product">
        </form>
    </div>
</body>
</html>