<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - MSOMBA</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="padding: 50px;">
    <h2>Your Shopping Cart</h2>
    <table border="1" width="100%" style="border-collapse: collapse; margin-top: 20px;">
        <tr style="background: #2f3542; color: white;">
            <th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th>
        </tr>
        <?php
        $total = 0;
        if(!empty($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $id => $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
                echo "<tr>
                    <td>{$item['name']}</td>
                    <td>TSh ".number_format($item['price'])."</td>
                    <td>
                        <a href='manage_cart.php?action=decrement&id=$id'>[-]</a> 
                        {$item['quantity']} 
                        <a href='manage_cart.php?action=increment&id=$id'>[+]</a>
                    </td>
                    <td>TSh ".number_format($subtotal)."</td>
                    <td><a href='manage_cart.php?action=remove&id=$id' style='color:red;'>Remove</a></td>
                </tr>";
            }
        }
        ?>
    </table>
    
    <h3>Total: TSh <?php echo number_format($total); ?></h3>
    
    <div style="margin-top: 20px;">
        <a href="index.php" class="add-to-cart-btn" style="background: #888; text-decoration: none;">Continue Shopping</a>
        <a href="checkout.php" class="add-to-cart-btn" style="text-decoration: none;">Proceed to Checkout</a>
    </div>
</body>
</html>