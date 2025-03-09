<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    $index = $_POST['index'];
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    } else {
        unset($_SESSION['cart'][$index]); // Remove if quantity is 0
    }
}

header("Location: cart.php");
exit;
?>
