<?php
// define('DB_PATH', './database/ecommdb.db');
define('DB_PATH', 'C:\xampp\htdocs\ecommerce\database\ecommdb.db');

try {
    $pdo = new \PDO("sqlite:" . DB_PATH);
    // echo 'Connected to the SQLite database successfully!';
} catch (\PDOException $e) {
    echo $e->getMessage();
}

?>