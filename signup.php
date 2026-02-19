<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $mobile=$_POST['mobile'];
    $email=$_POST['email'];

    $check_sql = "SELECT * FROM users WHERE username = '$user'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $error_message = "Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password, role,mobile,email) VALUES ('$user', '$pass', '$role','$mobile','$email')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Account created successfully! You can now login.";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-2xl font-semibold text-green-700 text-center mb-6">Sign Up</h2>

        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php elseif (!empty($success_message)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="signup.php" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-600 font-medium mb-2">Username:</label>
                <input type="text" name="username" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300">
            </div>
            <div>
                 <label for="email" class="block text-gray-600 font-medium mb-2">Email ID:</label>
                 <input type="email" name="email" required
               class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300">
            </div>
            <div>
                <label for="mobile" class="block text-gray-600 font-medium mb-2">Mobile Number:</label>
               <input type="tel" name="mobile" pattern="[0-9]{10}" required
               class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-300"
               title="Enter a valid 10-digit mobile number">
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
            <div class="mb-2 mt-4">
                <p class="text-center" style="font-weight: 600; color: navy;">I have an Account <a href="./signin.php"
                        style="text-decoration: none;">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
