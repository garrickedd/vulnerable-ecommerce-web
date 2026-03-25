<?php
session_start();
include "connect.php";

$sql = "SELECT * FROM products";
try {
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll();
} catch (\PDOException $e) {
    echo $e->getMessage();
}


$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM products";
$params = [];

if (!empty($search)) {
    $sql .= " WHERE name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

$sql .= " ORDER BY id DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    echo "error " . htmlspecialchars($e->getMessage());
    $products = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: gray;
            padding: 30px;
            flex-direction: row;
        }
        .header ul li {
            list-style: none;
        }
        .header a{
            text-decoration: none;
            color: white;
        }
        .header li{
            display: inline-block;
            margin-right: 50px;
        }
        .main{
            margin-top: 100px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* background-color: black; */
            margin-bottom: 90px;
        }
        .main div{
            /* margin-left: 10px; */
            border: none;
            max-width: 300px;
            padding: 30px;
        }
        .main a{
            text-decoration: none;
            color: white;
            background-color: greenyellow;
            padding: 10px;
            margin: 2px;
        }
        .product{
            margin: 10px;
            border: 2px solid blueviolet;
            max-width: 300px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 8px 0;
        }
        /* .product p{
            margin-top: 10px;
            margin-bottom: 10px;
        } */
        .product a{
            display: block;
            text-decoration: none;
            color: black;
            background-color: greenyellow;
            padding: 10px;
            margin-top: 10px;
            width: 100%;
        }
        .product img{
            width: 150px;
            height: auto;
        }
        .productprice{
            opacity: 70%;
            color: red;
            font-size: 20px;
        }
        .footer{
            /* position: fixed; */
            bottom: 0;
            width: 100%;
            background-color: gray;
            text-align: center;
            padding: 20px;
            flex-direction: column;
        }
        .footer p{
            text-align: center;
        }
        .search-box{
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    @media(max-width: 400px){
        .header{
            flex-direction: column;
            display: flex;
        }
        .footer{
            display: flex;
            flex-direction: column;
        }
    }
</head>

<body>
    <header class="header">
        <a href="index.php">shop</a>
        <a href="index.php"><img src="" alt=""></a>
        <nav>
            <ul>
                <li><a href="./login.php">login</a></li>
                <li><a href="./register.php">register</a></li>
                <li><a href="./logout.php">logout</a></li>
                <li><a href="">dashboard</a></li>
            </ul>
        </nav>

    </header>
    <main class="main">
    <div class="search-box">
        <form method="GET" action="index.php">
            <input type="text" name="search" placeholder="Search products by name" 
                value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
            <?php if (!empty($search)): ?>
                <a href="index.php" style="margin-left:10px;">Delete search</a>
            <?php endif; ?>
        </form>
    </div>
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <?php
                $img_src = !empty($product['image']) ? 'image/' . htmlspecialchars($product['image']) : 'https://via.placeholder.com/150?text=No+Image';
                ?>
                <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p class="productprice"><?= number_format($product['price'], 0) ?> USD</p>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="singleorder.php?id=<?php echo $_SESSION['user_id']?>&product_id=<?= $product['id'] ?>">Buy Now</a>
                <?php else: ?>
                    <a href="/ecommerce/login.php">Login to Buy</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; font-size:1.2em;">No products</p>
    <?php endif; ?>
</main>
    <footer class="footer">
        <p>copyright@: 2003 DungTran. All rights reserved.</p>
    </footer>
</body>
</html>