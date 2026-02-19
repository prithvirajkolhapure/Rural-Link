<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'farmer') {
    header("Location: signin.php");
    $_SESSION = array();
    
    exit;
}
include 'includes/header.php';
include 'includes/navbar.php';


echo "
<div id='dashboard-welcome' class='welcome-banner'>
    <h2>Welcome to the Shopkeeper Dashboard, <span class='username-highlight'>" . $_SESSION['username'] . "</span>!</h2>
</div>";

?>

<!-- Header section -->
<section id="about-us-loc" class="section-body">
    <div id="header-wrap">
        <div id="header-text" data-aos="fade-up" data-aos-delay="300">
            <div id="bonjour">Always , Best Choice!!</div>
            <div id="welcome"><span id="geeksforgeeks">Rural link</span> </div>
            <div id="description">Rural link is a revolutionary online shopping platform designed specifically for villages, bringing essential products and everyday necessities right to your doorstep. With a wide range of quality goods at affordable prices, we make shopping easy, accessible, and convenient for rural communities. Our mission is to empower villages with digital commerce, ensuring fast delivery, reliable service, and a seamless shopping experience—all from the comfort of your home..</div>
        </div>
        <div id="header-img" data-aos="fade-up">
            <img src="./assets/shop1.jpeg" alt="">
        </div>
    </div>
</section>


<section id="events-loc" class="swiper-body">
    <div class="our-team-head" data-aos="fade-down">Our Products</div>
    <div class="swiper mySwiper" data-aos="fade-up">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="./assets/item1.jpeg"></div>
            <div class="swiper-slide"><img src="./assets/item2.jpeg"></div>
            <div class="swiper-slide"><img src="./assets/item3.jpeg"></div>
            <div class="swiper-slide"><img src="./assets/item4.jpeg"></div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</section>

<!-- Our core team section -->
<section id="team-loc" class="section-body">
    <div id="team-header">
        <div class="team-headline" data-aos="fade-up">
           
        </div>
    </div>
</section>

<!-- Contact Section with Form -->
<section id="contact-us-loc" class="section-body">
    <div id="contact-form">
        <div class="container">
            <h2>Contact Us</h2>

            <form>
            <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullName" placeholder="Enter your name" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" required>
            </div>
                <div class="mb-3">
                    <label for="eventCategory" class="form-label">Region</label>
                    <select class="form-select" id="eventCategory" required>
                        <option selected disabled>Select Region</option>
                        <option value="coding">Pune</option>
                        <option value="hackathon">Mumbai</option>
                        <option value="webinar">Kolhapur</option>
                        <option value="workshop">Sangli</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="comments" class="form-label">Message</label>
                    <textarea class="form-control" id="comments" rows="4" placeholder="Enter your message here..."></textarea>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="agree" required>
                    <label class="form-check-label" for="agree">I agree to the terms and conditions.</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>

<br>
<br>

<style>
    /* Overall Section Styling */
    #contact-us-loc {
        padding: 40px 0;
        margin-bottom: 100px;
    }

    /* Contact Form Container */
    #contact-form .container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
        transition: transform 0.3s ease;
    }

    #contact-form .container:hover {
        transform: translateY(-10px);
    }

    /* Section Heading */
    #contact-form h2 {
        font-size: 2rem;
        color: #343a40;
        font-weight: bold;
    }

    /* Input Fields */
    .form-control,
    .form-select,
    #comments {
        border-radius: 5px;
        border: 2px solid #ced4da;
        box-sizing: border-box;
        padding: 10px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    /* Focused Input Fields */
    .form-control:focus,
    .form-select:focus,
    #comments:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
    }

    /* Submit Button */
    .btn {
        background-color: #28a745;
        border: none;
        color: white;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #218838;
    }

    .welcome-banner {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 20px auto;
        max-width: 800px;
        transition: transform 0.3s ease;
    }

    .welcome-banner:hover {
        transform: translateY(-5px);
    }

    .welcome-banner h2 {
        font-size: 1.8rem;
        color: #343a40;
        font-weight: bold;
        margin: 0;
    }

    .username-highlight {
        color: #28a745;
    }
</style>

<?php include 'includes/footer.php'; ?>
