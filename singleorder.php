<?php
session_start();
include "connect.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];

    $sql = "SELECT * FROM products WHERE id = :id";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch();

        $sql = "INSERT INTO single_order (user_id, product_id, total_amount) VALUES (:user_id, :product_id, :total_amount)";

        if ($product) {
            $total_amount = $product['price'];
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
            $stmt->execute();
            // Process the order (e.g., save to orders table)
            $sql_payment = "INSERT INTO payments (order_id, user_id, payment_method) VALUES (:order_id, :user_id, :payment_method)";
            $order_id = $pdo->lastInsertId();
            $payment_method = 'cash';
            $stmt_payment = $pdo->prepare($sql_payment);
            $stmt_payment->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt_payment->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt_payment->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
            $stmt_payment->execute();
            // For simplicity, we just display a confirmation message here
            echo "Order placed for product: " . htmlspecialchars($product['name']);
            echo "<br><a href='index.php'>Continue Shopping</a>";
        } else {
            echo "Product not found.";
        }
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
    exit;
}
?>