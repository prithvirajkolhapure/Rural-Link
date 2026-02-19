<?php  

include 'includes/header.php';
include 'includes/navbar.php';

// Database connection
$servername = "localhost"; // Change if not using localhost
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "user_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $region = $conn->real_escape_string($_POST['eventCategory']);
    $comments = $conn->real_escape_string($_POST['comments']);

    // Insert data into the database
    $sql = "INSERT INTO contact_form (fullName, email, phone, region, comments) 
            VALUES ('$fullName', '$email', '$phone', '$region', '$comments')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Thank you for contacting us! Your information has been saved.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$conn->close();

?>

<style>
/* Your existing styles */
</style>

<div class="content-section">
    <div class="section-header">
        <div class="container">
            <div class="row">
                <h1 class="text-center p-2 m-3">Contact Us</h1>
                <p class="text-center">
                    Our platform acts as an intermediate connection bridge between farmers and businesses, ensuring a seamless process of order placement, crop procurement, basket assembly, and delivery. The solution focuses on creating a fair, efficient, and scalable agricultural supply chain.
                </p>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <section id="contact-us-loc" class="contact-body">
                <div id="contact-form">
                    <div class="container my-5">
                        <h2 class="text-center mb-4">Contact Us</h2>
                        <form method="POST" action="">
                            <!-- Name -->
                            <div class="mb-3">
                                <input type="text" class="form-control" name="fullName" placeholder="Enter your name" required>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                            </div>
                            <!-- Phone Number -->
                            <div class="mb-3">
                                <input type="tel" class="form-control" name="phone" placeholder="Enter your phone number" required>
                            </div>
                            <!-- Region -->
                            <div class="mb-3">
                                <select class="form-select" name="eventCategory" required>
                                    <option selected disabled>Select Region</option>
                                    <option value="Pune">Pune</option>
                                    <option value="Mumbai">Mumbai</option>
                                    <option value="Kolhapur">Kolhapur</option>
                                    <option value="Sangli">Sangli</option>
                                </select>
                            </div>
                            <!-- Message -->
                            <div class="mb-3">
                                <textarea class="form-control" name="comments" rows="4" placeholder="Enter your message here..."></textarea>
                            </div>
                            <!-- Agreement Checkbox -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agree" required>
                                <label class="form-check-label" for="agree">I agree to the terms and conditions.</label>
                            </div>
                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>