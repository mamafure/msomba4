   
<?php
include('db.php');

// Security check: must be logged in to order
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $coords = mysqli_real_escape_string($conn, $_POST['coordinates']);
    
    // Calculate Total Price from Session
    $total_amount = 0;
    if(isset($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $item) {
            $total_amount += ($item['price'] * $item['quantity']);
        }
    }

    // 1. Insert into Main Orders table
    $query = "INSERT INTO orders (user_id, total_amount, address, coordinates, status) 
              VALUES ('$user_id', '$total_amount', '$address', '$coords', 'Pending')";
    
    if (mysqli_query($conn, $query)) {
        $order_id = mysqli_insert_id($conn); // Get the ID of the order just created

        // 2. Insert each item from the cart into Order Items table
        foreach ($_SESSION['cart'] as $id => $item) {
            $p_name = $item['name'];
            $p_price = $item['price'];
            $p_qty = $item['quantity'];

            $item_query = "INSERT INTO order_items (order_id, product_name, price, quantity) 
                           VALUES ('$order_id', '$p_name', '$p_price', '$p_qty')";
            mysqli_query($conn, $item_query);
        }

        // 3. Clear the cart after successful order
        unset($_SESSION['cart']);

        // 4. Redirect to Success Page
        header("Location: order_success.php?id=" . $order_id);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}










// Inside place_order.php
$user_id = $_SESSION['user_id'];
$address = mysqli_real_escape_string($conn, $_POST['address']);
$coords = mysqli_real_escape_string($conn, $_POST['coordinates']);

// If the user used the map, 'coordinates' will have numbers. 
// If they used manual, we set a default so the database doesn't crash.
if(empty($coords)) {
    $coords = "0,0"; // Or "Manual Location"
}

// ... the rest of your INSERT query remains the same ...















?>


