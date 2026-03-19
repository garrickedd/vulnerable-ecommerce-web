<?php
session_start();
include "../connect.php";

if(isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {

    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];

        $sql = "DELETE FROM products WHERE id = :id";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: displayproduct.php");
            exit;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid product ID.";
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>
