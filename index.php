<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSOMBA PHONE POINT | Home</title>
    <!-- Font Awesome for Icons -->


<!-- Put this inside the <head> section of index.php -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
<header>
    <div class="logo">
        <h1>MSOMBA <span>PHONE POINT</span></h1>
    </div>

    <div class="header-right">
        <!-- The Shopping Cart Symbol -->
        <a href="cart.php" class="cart-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge">
                <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
            </span>
        </a>

        <!-- The Menu Button -->
        <div class="menu-btn" id="menuBtn">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
</header>






    <!-- Fullscreen Dynamic Menu -->
    <div class="nav-overlay" id="navOverlay">
        <span class="close-btn" id="closeBtn">&times;</span>
        <ul class="nav-links">
            <!-- Inside your nav-overlay ul -->
<li><a href="index.php">Home</a></li>
<li><a href="#Smartphones">Smartphones</a></li>
<li><a href="#Phone Covers">Phone Covers</a></li>
<li><a href="#Chargers">Chargers</a></li>
<li><a href="#Other Accessories">Other Accessories</a></li>
    <li><a href="login.php">login</a></li>    
        
        <li><a href="#contact"><i class="fas fa-envelope"></i> Contact Us</a></li>
        </ul>
    </div>

    <!-- Hero Section / Company Image -->
    <section class="hero">
        <div class="hero-content">
            <h2>Welcome to MSOMBA PHONE POINT</h2>
            <p>Your one-stop shop for the latest mobile tech and accessories.</p>
        </div>
    </section>

    <!-- Product Section -->
    <!-- Product Section -->
<section class="products-container">
    <?php
    $categories = ['Smartphones', 'Phone Covers', 'Chargers', 'Other Accessories'];
    $isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';

    foreach($categories as $cat) {
        // Only show category header if there are products in it
        $check_prod = mysqli_query($conn, "SELECT * FROM products WHERE category='$cat'");
        if(mysqli_num_rows($check_prod) > 0) {
            echo "<h2 class='section-title' id='$cat' style='margin-top:50px; border-bottom: 2px solid #ff4757; display: inline-block;'>$cat</h2>";
            echo "<div class='product-grid'>";

            while($row = mysqli_fetch_assoc($check_prod)) {
                echo '
                <div class="product-card">
                    <div class="product-img">
                        <img src="images/'.$row['image'].'" alt="'.$row['name'].'">
                    </div>
                    <div class="product-info">
                        <h3>'.$row['name'].'</h3>
                        <p class="price">
                            <span class="old-price">TSh '.number_format($row['old_price']).'</span>
                            <span class="new-price">TSh '.number_format($row['new_price']).'</span>
                        </p>
                        <form method="POST" action="manage_cart.php">
                            <input type="hidden" name="product_id" value="'.$row['id'].'">
                            <input type="hidden" name="product_name" value="'.$row['name'].'">
                            <input type="hidden" name="price" value="'.$row['new_price'].'">
                            <button type="submit" name="add_to_cart" class="add-to-cart-btn" onclick="return checkLogin('.$isLoggedIn.')">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>';
            }
            echo "</div>"; // Close product-grid
        }
    }
    ?>
</section>

    <!-- Advanced Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>MSOMBA PHONE POINT</h3>
                <p>Leading provider of genuine smartphones and high-quality phone accessories.</p>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +255 123 456 789</li>
                    <li><i class="fas fa-envelope"></i> info@msombaphone.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Mbeya, Tanzania</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 MSOMBA PHONE POINT. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>