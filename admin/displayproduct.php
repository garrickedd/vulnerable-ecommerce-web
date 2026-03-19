<?php
session_start();
include "../connect.php";

if(isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $sql = "SELECT * FROM products";
    try {
        $stmt = $pdo->query($sql);
        $products = $stmt->fetchAll();
    } catch (\PDOException $e) {
        echo $e->getMessage();
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
        .dashboard_sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 200px;
        height: 100%;
        background-color: gray;
        z-index: 1000;
    }
    .dashboard_sidebar ul li {
        list-style: none;
    }
    .dashboard_sidebar ul li a {
        text-decoration: none;
        color: white;
        display: block;
        padding: 15px;
    }
    .dashboard_main {
        margin-left: 220px;
        padding: 20px;
        min-height: 100vh;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .update {
        color: blue;
        text-decoration: none;
    }
    .update:hover {
        text-decoration: underline;
    }
    .delete {
        color: red;
        text-decoration: none;
    }
    .delete:hover {
        text-decoration: underline;
    }
    img {
        max-width: 100px;
        height: auto;
        border-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .content_wrapper {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .dashboard_main h1 {
        margin-bottom: 20px;
        color: #333;
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
    <div class="content_wrapper">
        <div class="dashboard_main">
            <table>
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th>Product description</th>
                        <th>price</th>
                        <th>stock</th>
                        <th>Image</th>
                        <th>Category name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo isset($product['name']) ? $product['name'] : 'N/A'; ?></td>
                        <td><?php echo isset($product['description']) ? $product['description'] : 'N/A'; ?></td>
                        <td><?php echo isset($product['price']) ? '$' . number_format($product['price'], 2) : 'N/A'; ?></td>
                        <td><?php echo isset($product['stock']) ? $product['stock'] : 'N/A'; ?></td>
                        <!-- <td><img src="<?php echo isset($product['../image']) ? $product['../image'] : 'default.jpg'; ?>" alt="Product 1" width="100"></td> -->
                        <td>
                            <?php 
                            $img_path = !empty($product['image']) ? "../image/" . $product['image'] : "default.jpg";
                            ?>
                            <img src="<?php echo htmlspecialchars($img_path); ?>" alt="<?php echo htmlspecialchars($product['name'] ?? 'Product'); ?>" width="100">
                        </td>
                        <td><?php echo isset($product['category_name']) ? $product['category_name'] : 'N/A'; ?></td>
                        <td><a href="updateproduct.php?id=<?= $product['id'] ?>">Update</a></td>
                        <td><a class="delete" href="deleteproduct.php?id=<?php echo $product['id']; ?>">Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>