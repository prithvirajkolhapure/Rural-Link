<?php
// Database connection setup
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'user_db';

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders from the database
$sql = "SELECT id, product_name, quantity, price, total_price, shop_name, username, order_date, status FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
$conn->close();

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f9f4;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #2e8b57;
        }
        .search-bar {
            text-align: center;
            margin-bottom: 20px;
        }
        #search {
            padding: 10px;
            width: 80%;
            max-width: 300px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .orders-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .order-card {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #4caf50;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .order-card:hover {
            transform: translateY(-10px);
        }
        .order-card h3 {
            color: #388e3c;
            font-size: 1.2em;
        }
        .order-details span {
            font-weight: bold;
            color: #388e3c;
        }
        .order-status {
            margin-top: 10px;
            font-size: 14px;
            padding: 8px;
            border-radius: 5px;
            text-align: center;
            color: white;
        }
        .status-pending { background-color: #ffa500; }
        .status-confirmed { background-color: #4caf50; }
        .status-delivered { background-color: #2196f3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order History</h1>
        <div class="search-bar">
            <input type="text" id="search" placeholder="Search by Order ID or Product...">
        </div>
        <div id="orders-list" class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <h3>Order ID: <?= htmlspecialchars($order['id']) ?></h3>
                    <div class="order-details">
                        <span>Product Name:</span> <?= htmlspecialchars($order['product_name']) ?><br>
                        <span>Quantity:</span> <?= htmlspecialchars($order['quantity']) ?> kg<br>
                        <span>Price:</span> ₹<?= htmlspecialchars($order['price']) ?> per kg<br>
                        <span>Total Price:</span> ₹<?= htmlspecialchars($order['total_price']) ?><br>
                        <span>Shop Name:</span> <?= htmlspecialchars($order['shop_name']) ?><br>
                        <span>Username:</span> <?= htmlspecialchars($order['username']) ?><br>
                        <span>Order Date:</span> <?= htmlspecialchars($order['order_date']) ?><br>
                        <span>Status:</span> 
                        <div class="order-status status-<?= strtolower($order['status']) ?>">
                            <?= htmlspecialchars($order['status']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const orders = document.querySelectorAll('.order-card');
            
            orders.forEach(order => {
                const text = order.textContent.toLowerCase();
                order.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>