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

// Fetch products from the database
// Fetch products from the database, including shop_name
$query = "SELECT name, quantity, price, shop_name FROM products";
$result = $conn->query($query);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}


$conn->close();
?>
<?php 
include 'includes/header.php';
include 'includes/navbarC.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style> body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .product-card {
            width: 200px;  /* Fixed width for the product card */
            height: 300px;  /* Adjusted height for better spacing */
            background: #fff;
            padding: 15px;  /* Increased padding */
            border: 1px solid #ddd;
            border-radius: 10px;  /* Slightly rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* Slightly bigger shadow */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;  /* Top alignment for better spacing */
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Hover effect for smoother interaction */
        }

        .product-card:hover {
            transform: scale(1.05);  /* Scale effect */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); /* More intense shadow */
        }

        .product-card h3 {
            font-size: 14px;  /* Increased size */
            font-weight: 500;  /* Slightly bolder */
            margin: 10px 0 5px 0;  /* Adding some space between name and quantity */
            color: #333;
            text-align: center;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .product-card p {
            font-size: 12px;  /* Slightly bigger and easier to read */
            margin: 2px 0;
            color: #555;
            text-align: center;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;  /* To fill the card */
        }

        .quantity-controls button {
            padding: 5px;
            background-color: #4CAF50;  /* Green for contrast */
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity-controls button:hover {
            background-color: #45a049;  /* Slightly darker on hover */
        }

        .quantity-controls input {
            width: 50%;  /* Expanded width for better user experience */
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .add-to-basket {
            width: 100%;  /* Full-width button for better usability */
            padding: 10px;
            background-color: #2196F3;  /* Blue for a fresh look */
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;  /* Space between elements */
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .add-to-basket:hover {
            background-color: #1e88e5;  /* Darker blue on hover */
            transform: scale(1.05);  /* Button zoom effect */
        }

        #basket button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #basket .mt-4.bg-red-500 {
            background-color: #f44336;  /* Red color for Clear Basket */
        }

        #basket .mt-4.bg-red-500:hover {
            background-color: #e53935; /* Darker red on hover */
            transform: scale(1.05);
        }

        #basket .mt-4.bg-green-500 {
            background-color: #4CAF50;  /* Green color for Place Order */
        }

        #basket .mt-4.bg-green-500:hover {
            background-color: #43a047; /* Darker green on hover */
            transform: scale(1.05);
        }

        .image-preview {
            border-radius: 50%;  /* Circular shape */
            object-fit: cover;  /* Keeps the aspect ratio */
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;  /* Ensure the image fits well */
            border-radius: 10px;
            margin-bottom: 10px;  /* Adds space for the product details */
        }
        .product-card {
    width: 200px;  /* Fixed width for the product card */
    background: #fff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: auto; /* Allow the height to auto-adjust */
}

.product-card img {
    width: 100%;
    height: 150px;  /* Keeps the image height consistent */
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;  /* Adds space for the product details */
}

.product-card .product-info {
    flex-grow: 1;  /* Allow the content area to grow and take the available space */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}

      </style>
</head>
<body>
<div class="our-team-head" data="fade-down"><span>Customer</span> Dashboard</div>

    <div class="container">
       
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
    <!-- Assign image based on product name -->
    <?php 
        $productImages = [
           
            "sugar" => "assets/sugar.jpeg",
            "salt" => "assets/salt.jpeg",
            "Wheat" => "assets/wheat.jpg",
            "dawat rice" => "assets/rice.jpg",
            "pulav basmti rice" => "assets/pulav basmti rice.jpg",
            "colgate"=>"assets/colgate.jpg",
            "dettol soap" => "assets/dettol soap.jpg",
            "pears" => "assets/pears.jpg",
            "rin" => "assets/rin.jpg",
            "dove" => "assets/dove.jpg",
            "vim" => "assets/vim.jpg",
            "colgate max fresh" => "assets/colgate max fresh.jpg",
            "oreo" => "assets/oreo.jpg",
            "jimjam" => "assets/jimjam.jpg",
            "hide and seek" => "assets/hide and seek.jpg",
            "bourbon" => "assets/bourbon.jpg",
            "saffola gold" => "assets/saffola gold.jpg",
            "fortune" => "assets/fortune.jpg",
            "parle g" => "assets/parle g.jpg",
            "pure cow ghee" => "assets/pure cow ghee.jpg",
            "kimia gold" => "assets/kimia gold.jpg"
        ];

        // Use the corresponding image, or a default image if the product is not listed
        $imageSrc = isset($productImages[$product['name']]) ? $productImages[$product['name']] : "assets/wheat.jpeg";
    ?>

    <img src="<?= $imageSrc; ?>" alt="<?= htmlspecialchars($product['name']); ?>">

    <h3 class="our-team-head" data="fade-down">
        <span>Product Name:</span> <?= htmlspecialchars($product['name']); ?>
    </h3>
    <p class="our-team-head" dxata="fade-down">
        <span>Shop Name:</span> <?= htmlspecialchars($product['shop_name']); ?>
    </p>
    <p class="our-team-head" data="fade-down">
        <span>Available Quantity (kg):</span> 
        <span id="available_quantity_<?= htmlspecialchars($product['name']); ?>">
            <?= htmlspecialchars($product['quantity']); ?>
        </span>
    </p>
    <p class="our-team-head" data="fade-down">
        <span>Price (₹/kg):</span> <?= htmlspecialchars($product['price']); ?>
    </p>

    <div class="quantity-controls mt-3">
        <button class="decrease" onclick="changeQuantity('<?= $product['name']; ?>', -1)">-</button>
        <input type="number" id="quantity_<?= $product['name']; ?>" class="quantity" value="0" min="0" readonly>
        <button class="increase" onclick="changeQuantity('<?= $product['name']; ?>', 1)">+</button>
    </div>

    <button class="add-to-basket" onclick="addToBasket('<?= $product['name']; ?>', <?= $product['price']; ?>, '<?= $product['shop_name']; ?>')">
        Add to Basket
    </button>
</div>

            <?php endforeach; ?>

            <!-- Basket UI -->
            <div id="basket" class="fixed bottom-0 right-0 m-6 w-80 p-4 bg-white shadow-lg rounded-xl z-50 border border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Basket</h3>
                <div id="basketItems" class="space-y-4 max-h-60 overflow-y-auto"></div>
                <p id="totalPrice" class="mt-4 font-semibold">Total: ₹0</p>
                <button class="mt-4 w-full py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="clearBasket()">Clear Basket</button>
                <form method="POST" id="orderForm" action="place_order.php">
    <input type="hidden" name="basket" id="basketData">
    <button class="mt-4 w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" type="submit" onclick="updateBasketHiddenField()">Place Order</button>
</form>
            </div>
        </div>
    </div>

    <script>
        let basket = [];

        function changeQuantity(productName, amount) {
    const quantityInput = document.getElementById('quantity_' + productName);
    const availableQuantityElement = document.getElementById('available_quantity_' + productName);

    let quantity = parseInt(quantityInput.value);
    let availableQuantity = parseInt(availableQuantityElement.textContent);

    if (amount > 0) {
        // Handle "+" button
        if (quantity >= availableQuantity) {
            alert("Not enough quantity available.");
            return;
        }
        quantity += amount;
        availableQuantity -= amount; // Decrease available quantity
    } else if (amount < 0) {
        // Handle "-" button
        if (quantity > 0) {
            quantity += amount;
            availableQuantity -= amount; // Increase available quantity back
        } else {
            // Do nothing if quantity is already 0
            return;
        }
    }

    // Update the input and available quantity display
    quantityInput.value = quantity;
    availableQuantityElement.textContent = availableQuantity;
}

function addToBasket(productName, price, shopName) {
    const quantity = parseInt(document.getElementById('quantity_' + productName).value);
    
    if (quantity > 0) {
        const existingItemIndex = basket.findIndex(item => item.name === productName);
        
        if (existingItemIndex > -1) {
            basket[existingItemIndex].quantity += quantity;
        } else {
            basket.push({ name: productName, price: price, quantity: quantity, shop_name: shopName });  // Include shop_name
        }
        updateBasketUI();
    } else {
        alert("Please select a quantity before adding to the basket.");
    }
}

function updateBasketUI() {
    const basketItemsContainer = document.getElementById('basketItems');
    const totalPriceContainer = document.getElementById('totalPrice');
    basketItemsContainer.innerHTML = '';

    let totalPrice = 0;

    basket.forEach(item => {
        const itemTotal = item.price * item.quantity;
        totalPrice += itemTotal;
        basketItemsContainer.innerHTML += `
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <div>
                    <span><strong>${item.name}</strong> (x${item.quantity})</span><br>
                    <small>Shop: ${item.shop_name}</small>  <!-- Display shop name -->
                </div>
                <span>₹${itemTotal}</span>
            </div>`;
    });

    totalPriceContainer.textContent = `Total: ₹${totalPrice}`;
}


        function updateBasketHiddenField() {
    const basketInput = document.getElementById('basketData');
    basketInput.value = JSON.stringify(basket);
}

        function clearBasket() {
            basket = [];
            updateBasketUI();
        }
    </script>
</body>
</html>
<?php
include 'includes/footer.php';
?>
