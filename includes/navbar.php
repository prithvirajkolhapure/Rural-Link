
<body>
    <!-- Loading screen -->
     <!-- <div id="loader_block"> -->
        <!-- <span></span> -->
        <!-- <span></span> -->
        <!-- <span></span> -->
    <!-- </div>  -->

    <!-- Top of the page -->
    <!-- <div id="top-loc"></div> -->

    <!-- Menu bar -->
    <nav id="navbar-wrap">
        <!-- Desktop Menu -->
        <div id="navbar">
            <div data="fade-down" id="logo" class="reverse">
                <div class="mobile-btn" style="font-size:30px;cursor:pointer; font-weight:bold;" onclick="openNav()">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </div>
                 <div class="logo"><a href="index.php"><img
                        src="./assets/rural.jpeg"></a>
                </div> 
                
            </div>
            <div id="links" data="fade-down">
                <a href="farmer_dashboard.php">Home</a>
               
                <a href="addmanage.php">Add/Manage Products</a>
                <a href="OrderHistroy.php">Order History</a>
                <a href="Regfarmer.php">Registered Shopkeepers</a>
                
                
                <a href="notification.php"><i class="fa-solid fa-bell"></i></a>
                
                <a href="./signup.php" class="btn btn-green my-2 my-sm-0"
                   type="submit" style="font-weight:bolder;color:white;">
                Logout</a>
                 <a href="contact.php">Contact Us</a>
                
            </div>
            
        </div>


        <!-- Mobile Menu -->
        <div id="mySidenav" class="sidenav">
            <a style="cursor:pointer;" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="farmer_dashboard.php">Home</a>
               
                <a href="addmanage.php">Add/Manage Products</a>
                <a href="OrderHistroy.php">Order History</a>
                <a href="Regfarmer.php">Registered Farmers</a>
                
                
                <a href="notification.php"><i class="fa-solid fa-bell"></i></a>
                
                <a href="./signup.php" class="btn btn-green my-2 my-sm-0"
                   type="submit" style="font-weight:bolder;color:white;">
                Logout</a>
                 <a href="contact.php">Contact Us</a>
            
        </div>
<div id="google_element"></div>
<script src="http://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate"></script>
<script>
function loadGoogleTranslate(){
new google.translate.TranslateElement(
"google_element");
}
</script>
        
    </nav>