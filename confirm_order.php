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

// Fetch latest pending order of the logged-in user
$username = $_SESSION['username'];

$stmt = $conn->prepare("
    SELECT id, SUM(total_price) AS total_amount
    FROM orders
    WHERE username = ? AND status = 'Pending Confirmation'
    GROUP BY id
    ORDER BY order_date DESC
    LIMIT 1
");
$stmt->bind_param("s", $username);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
    $order_id = $order['id'];
    $order_amount = $order['total_amount'] ?? 0;
} else {
    echo "<script>alert('No pending orders found!'); window.location.href='buyer_dashboard.php';</script>";
    exit;
}

// Shopkeeper UPI Details
$shopkeeper_upi = "shopkeeper@upi";
$shopkeeper_name = "Shop Name";

// Generate Dynamic UPI Payment URL
$upi_link = "upi://pay?pa=$shopkeeper_upi&pn=$shopkeeper_name&tn=Order%20Payment&am=$order_amount&cu=INR";

// Your GPay QR Code
$gpay_qr = "Qr.jpg";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];
    $payment_mode = $_POST['payment_mode'];

    // ✅ Fixed Query Using JOIN Instead of Subquery
    $update_stmt = $conn->prepare("
        UPDATE orders o1
        JOIN (SELECT MAX(order_date) AS latest_order_date FROM orders WHERE username = ? AND status = 'Pending Confirmation') o2
        ON o1.order_date = o2.latest_order_date
        SET o1.address = ?, o1.payment_mode = ?, o1.status = 'Confirmed'
        WHERE o1.username = ? AND o1.status = 'Pending Confirmation'
    ");
    $update_stmt->bind_param("ssss", $username, $address, $payment_mode, $username);

    if ($update_stmt->execute()) {
        echo "<script>alert('Order confirmed successfully!'); window.location.href='buyer_dashboard.php';</script>";
    } else {
        echo "Error updating order: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-2xl font-semibold text-green-700 text-center mb-6">Confirm Your Order</h2>

        <form method="POST" action="confirm_order.php" class="space-y-6">
            <div>
                <label for="address" class="block text-gray-600 font-medium mb-2">Delivery Address:</label>
                <textarea name="address" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300"></textarea>
            </div>

            <div>
                <label for="payment_mode" class="block text-gray-600 font-medium mb-2">Payment Mode:</label>
                <select name="payment_mode" id="payment_mode" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300">
                    <option value="COD">Cash on Delivery</option>
                    <option value="UPI">UPI (Google Pay, PhonePe, Paytm)</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                </select>
            </div>

            <!-- GPay QR Code Section -->
            <div id="upi_payment_section" class="hidden bg-gray-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-green-700 mb-2">Scan to Pay via GPay / PhonePe / Paytm</h3>
                <img id="qr_image" src="<?= $gpay_qr ?>" alt="GPay QR Code" class="mx-auto mb-2 w-40 h-40 rounded-lg shadow-lg">
                <p>Or click the link: <a href="<?= $upi_link ?>" target="_blank" class="text-blue-600 underline">Pay via UPI</a></p>
            </div>

            <button type="submit" class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg transition-transform transform hover:scale-105 hover:bg-green-700 focus:ring focus:ring-green-300">
                Confirm Order
            </button>
        </form>
    </div>

    <!-- JavaScript to Show QR Code When UPI is Selected -->
    <script>
        document.getElementById('payment_mode').addEventListener('change', function() {
            document.getElementById('upi_payment_section').classList.toggle('hidden', this.value !== 'UPI');
        });
    </script>
</body>
</html>