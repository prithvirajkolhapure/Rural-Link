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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'] ?? null;
    $productQuantity = $_POST['productQuantity'] ?? null;
    $productPrice = $_POST['productPrice'] ?? null;
    $shopName = $_POST['shopName'] ?? null;
    $shopkeeperName = $_POST['shopkeeperName'] ?? null;

    $userId = 1; // Change as needed

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update') {
            $productId = $_POST['productId'];
            $query = "UPDATE products SET name = ?, quantity = ?, price = ?, shop_name = ?, shopkeeper_name = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sidssi", $productName, $productQuantity, $productPrice, $shopName, $shopkeeperName, $productId);
            $stmt->execute();
            $stmt->close();
        } elseif ($_POST['action'] === 'delete') {
            $productId = $_POST['productId'];
            $query = "DELETE FROM products WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        $query = "INSERT INTO products (user_id, name, quantity, price, shop_name, shopkeeper_name) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isidss", $userId, $productName, $productQuantity, $productPrice, $shopName, $shopkeeperName);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch products for display
$products = [];
$userId = 1; 
$query = "SELECT * FROM products WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$conn->close();
include 'includes/header.php';
include 'includes/navbar.php';
?>

<style>
  .container1 {
    max-width: 600px;
    margin: 50px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #333;
  }

  form {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
  }

  input[type="text"],
  input[type="number"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 80%;
    font-size: 16px;
    box-sizing: border-box;
  }

  input[type="text"]:focus,
  input[type="number"]:focus {
    outline: none;
    border-color: #007bff;
  }

  button {
    padding: 10px 15px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-transform: uppercase;
    transition: background-color 0.3s, transform 0.3s;
  }

  button[type="submit"]:first-of-type {
    background-color: green;
    color: white;
    display: block;
    margin: 0 auto;
    max-width: 200px;
  }

  button[type="submit"]:first-of-type:hover {
    background-color: green;
    transform: translateY(-2px);
  }

  button[type="submit"]:not(:first-of-type) {
    background-color: green;
    color: white;
    width: 100%;
    margin-top: 10px;
  }

  button[type="submit"]:not(:first-of-type):hover {
    background-color: #218838;
  }

  .product-list {
    list-style: none;
    padding: 0;
    margin-top: 30px;
  }

  .product-item {
    display: flex;
    flex-direction: column;
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f5f5f5;
    box-sizing: border-box;
    text-align: center;
  }

  .product-info {
    font-family: 'Arial', sans-serif;
    font-size: 18px;
    color: #333;
    line-height: 1.5;
    margin-bottom: 10px;
    font-weight: 500;
    text-transform: capitalize;
  }

  .product-info strong {
    font-weight: bold;
    color: #28a745;
  }

  .product-info .quantity {
    font-size: 16px;
    color: #666;
  }

  .product-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  .product-actions form {
    display: flex;
    gap: 5px;
    flex-direction: row;
    align-items: center;
    justify-content: center;
  }

  @media (max-width: 600px) {
    .product-item {
      padding: 10px;
    }
    .container1 {
      padding: 15px;
    }
    input[type="text"],
    input[type="number"] {
      font-size: 14px;
      padding: 8px;
    }

    button {
      font-size: 14px;
    }
  }
</style>


<br><br><br>

<div class="container1">
    <div class="our-team-head"><span>Add - Manage</span> Products</div>

    <form method="POST" class="product-form">
        <input type="text" name="productName" placeholder="Product Name" required>
        <input type="number" name="productQuantity" placeholder="Quantity (kg)" required>
        <input type="number" name="productPrice" placeholder="Price (per kg)" step="0.01" required>
        <input type="text" name="shopName" placeholder="Shop Name" required>
        <input type="text" name="shopkeeperName" placeholder="Shopkeeper Name" required>
        <button type="submit">Add Product</button>
    </form>

    <ul class="product-list">
        <?php foreach ($products as $product): ?>
            <li class="product-item">
                <span class="product-info">
                    <?= htmlspecialchars($product['name']) ?> - 
                    <span class="quantity"><?= $product['quantity'] ?>kg</span> - 
                    ₹<strong><?= $product['price'] ?>/kg</strong> - 
                    <strong>Shop:</strong> <?= htmlspecialchars($product['shop_name']) ?> - 
                    <strong>Shopkeeper:</strong> <?= htmlspecialchars($product['shopkeeper_name']) ?>
                </span>

                <form method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="productId" value="<?= $product['id'] ?>">
                    <input type="text" name="productName" value="<?= htmlspecialchars($product['name']) ?>" required>
                    <input type="number" name="productQuantity" value="<?= $product['quantity'] ?>" required>
                    <input type="number" name="productPrice" value="<?= $product['price'] ?>" step="0.01" required>
                    <input type="text" name="shopName" value="<?= htmlspecialchars($product['shop_name']) ?>" required>
                    <input type="text" name="shopkeeperName" value="<?= htmlspecialchars($product['shopkeeper_name']) ?>" required>
                    <button type="submit">Update</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="productId" value="<?= $product['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>
