<?php
include('db.php');

if(isset($_POST['add_to_cart'])) {
    $id = $_POST['product_id'];
    
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product exists in cart, then increment
    if(isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $_POST['product_name'],
            'price' => $_POST['price'],
            'quantity' => 1
        ];
    }
    header("Location: index.php");
}

// Handle quantity buttons and removal
if(isset($_GET['action'])) {
    $id = $_GET['id'];
    if($_GET['action'] == 'increment') $_SESSION['cart'][$id]['quantity']++;
    if($_GET['action'] == 'decrement' && $_SESSION['cart'][$id]['quantity'] > 1) $_SESSION['cart'][$id]['quantity']--;
    if($_GET['action'] == 'remove') unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
}
?>