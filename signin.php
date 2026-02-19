<?php
session_start();

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root"; // Default XAMPP username
    $password = ""; 
    $dbname = "user_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $role = $_POST['role'];
    

    $sql = "SELECT * FROM users WHERE username = '$user' AND role = '$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $user;
            $_SESSION['role'] = $role;
            
            // Success message
            $success_message = "Login successful! Redirecting...";
            
            if ($role == 'farmer') {
                header("Location: farmer_dashboard.php");
            } elseif ($role == 'buyer') {
                header("Location: buyer_dashboard.php");
            }
        } else {
            $error_message = "Invalid username or password!";
        }
    } else {
        $error_message = "No user found with that username and role!";
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-2xl font-semibold text-green-700 text-center mb-6">Sign In</h2>

        <?php if (!empty($success_message)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="signin.php" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-600 font-medium mb-2">Username:</label>
                <input type="text" name="username" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300">
            </div>

            <div>
                <label for="password" class="block text-gray-600 font-medium mb-2">Password:</label>
                <input type="password" name="password" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300">
            </div>

            <div>
                <label for="role" class="block text-gray-600 font-medium mb-2">Role:</label>
                <select name="role" required 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300">
                    <option value="farmer">Shopkeeper</option>
                    <option value="buyer">Customer</option>
                </select>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg transition-transform transform hover:scale-105 hover:bg-green-700 focus:ring focus:ring-green-300">
                Submit
            </button>
            <div class="col mb-2 mt-4">
                <p class="text-center" 
                  style="font-weight: 600; color: navy;">
                  <a href="./signup.php" style="text-decoration: none;">I don't have an account, Create Account</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
