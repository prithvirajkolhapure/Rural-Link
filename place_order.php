<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'user_db';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['basket'])) {
    $basketData = json_decode($_POST['basket'], true);

    if (!empty($basketData)) {
        $stmt = $conn->prepare("INSERT INTO orders (product_name, quantity, price, total_price, shop_name, username, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending Confirmation')");

        foreach ($basketData as $item) {
            $total_price = $item['price'] * $item['quantity'];
            $shop_name = $item['shop_name']; // Ensure this is included in the frontend
            $username = $_SESSION['username']; // Get the logged-in username

            $stmt->bind_param("sdidss", $item['name'], $item['quantity'], $item['price'], $total_price, $shop_name, $username);
            $stmt->execute();
        }

        $stmt->close();
        
        // Redirect user to confirm_order.php
        echo "<script>alert('added to cart!'); window.location.href='confirm_order.php';</script>";
    } else {
        echo "<script>alert('Basket is empty!'); window.location.href='buyer_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='buyer_dashboard.php';</script>";
}

$conn->close();
?>
