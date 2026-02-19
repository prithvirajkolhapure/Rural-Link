<?php
session_start();

// Check if the user is logged in, if
// not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>Farmer Dashboard</h2>
        </div>
        <ul class="nav-links">
            <li><a href="#" class="nav-item">Dashboard</a></li>
            <li><a href="#" class="nav-item">My Products</a></li>
            <li><a href="#" class="nav-item">Orders</a></li>
            <li><a href="#" class="nav-item">Account Settings</a></li>
            <li><a href="./logout.php" class="btn btn-light my-2 my-sm-0"
                   type="submit" style="font-weight:bolder;color:green;">
                Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome to Your Product Management</h1>
        </header>

        <!-- Product Management Section -->
        <section class="product-management">
            <h2>Your Products</h2>
            <button class="add-product">Add New Product</button>
            <div class="product-list">
               
            </div>
        </section>
    </div>

    <div id="modal-container" style="display: none;">
    <div class="modal">
        <h3 id="modal-title">Add New Product</h3>
        <div class="modal-content">
            <label for="product-name">Product Name</label>
            <input type="text" id="product-name" placeholder="Enter product name" />

            <label for="product-price">Price (₹/kg)</label>
            <input type="number" id="product-price" placeholder="Enter price per kg" />

            <label for="product-quantity">Quantity (kg)</label>
            <input type="number" id="product-quantity" placeholder="Enter quantity in kg" />

            <button id="modal-submit" class="modal-action-btn">Submit</button>
            <button id="modal-close" class="modal-close-btn">Cancel</button>
        </div>
    </div>
</div>


    <script src="script.js"></script>
</body>
</html>
