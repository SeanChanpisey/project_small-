<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Check if product is already in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => 1
        ];
    }

    echo "<script>alert('Product added to cart!'); window.location='cart.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/cart.css">
</head>
<body>

    <h2>Your Shopping Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-container">
            <table border="1" class="cart-table">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>

                <?php $total_price = 0; ?>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($item['image']); ?>" width="50"></td>
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td>$<?= number_format($item['price'], 2); ?></td>
                        <td>
                            <form method="POST" action="update_cart.php">
                                <input type="hidden" name="index" value="<?= $index; ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1">
                                <button type="submit" name="update_cart">Update</button>
                            </form>
                        </td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <a href="remove_cart.php?index=<?= $index; ?>" class="remove-btn">Remove</a>
                        </td>
                    </tr>
                    <?php $total_price += ($item['price'] * $item['quantity']); ?>
                <?php endforeach; ?>
            </table>

            <h3>Grand Total: $<?= number_format($total_price, 2); ?></h3>

            <!-- Buttons Section -->
            <div class="cart-buttons">
                <!-- <a href="shop.php" class="btn continue-shopping">Continue Shopping</a> -->
                <a href="index.php" class="btn home-page">Go to Home Page</a>
                <a href="checkout.php" class="btn checkout">Proceed to Checkout</a>
            </div>

        </div>
    <?php else: ?>
        <p>Your cart is empty!</p>
        <div class="cart-buttons">
            <!-- <a href="shop.php" class="btn continue-shopping">Continue Shopping</a> -->
            <a href="index.php" class="btn home-page">Go to Home Page</a>
        </div>
    <?php endif; ?>

</body>
</html>
