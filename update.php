<?php
// Database connection setup
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'user_db';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the product details
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $productName = $_POST['productName'];
        $productQuantity = $_POST['productQuantity'];

        // Update the product in the database
        $updateQuery = "UPDATE products SET name = ?, quantity = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sii", $productName, $productQuantity, $productId);

        if ($updateStmt->execute()) {
            echo "<script>alert('Product updated successfully!'); window.location.href = 'add_manage.php';</script>";
        } else {
            echo "<script>alert('Database error: Could not update product.');</script>";
        }
    }

    $stmt->close();
} else {
    echo "<script>alert('No product ID provided.'); window.location.href = 'add_manage.php';</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Product</title>
</head>
<body>
  <h1>Update Product</h1>
  <form method="POST" action="update.php?id=<?= $product['id'] ?>">
    <input type="text" name="productName" value="<?= htmlspecialchars($product['name']) ?>" required>
    <input type="number" name="productQuantity" value="<?= htmlspecialchars($product['quantity']) ?>" required>
    <button type="submit">Update Product</button>
  </form>
</body>
</html>