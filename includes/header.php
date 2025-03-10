<?php
require 'includes/db.php';

// Fetch the current logo path
$stmt = $pdo->query("SELECT logo_path FROM logo_settings WHERE id = 1");
$logo = $stmt->fetch(PDO::FETCH_ASSOC);
$logo_path = $logo ? $logo['logo_path'] : '';
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3">
            <div class="header__logo">
                <div>
                    <?php if ($logo_path): ?>
                        <img src="<?= htmlspecialchars($logo_path) ?>" alt="Website Logo" style="max-width: 200px;">
                    <?php else: ?>
                        <p>No logo available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <nav class="header__menu mobile-menu">
                <ul>
                    <li <?= ($p == "home" ? " class='active'" : "") ?>><a href="./index.php">Home</a></li>
                    <li <?= ($p == "shop" ? " class='active'" : "") ?>><a href="./index.php?p=shop">Shop</a></li>
                    <li><a href="./index.php?p=pages">Pages</a>
                        <ul class="dropdown">
                            <li><a href="./index.php?p=about">About Us</a></li>
                            <li><a href="./index.php?p=shop-details">Shop Details</a></li>
                            <!-- <li><a href="./index.php?p=shopping-cart">Shopping Cart</a></li> -->
                            <li><a href="./index.php?p=checkout">Check Out</a></li>
                            <li><a href="./index.php?p=blog-details">Blog Details</a></li>
                        </ul>
                    </li>
                    <li <?= ($p == "blog1" ? " class='active'" : "") ?>><a href="./index.php?p=blog1">Blog</a></li>
                    <li <?= ($p == "contact" ? " class='active'" : "") ?>><a href="./index.php?p=contact">Contacts</a></li>
                </ul>
            </nav>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="header__nav__option">
                <a href="#" class="search-switch"><img src="img/icon/search.png" alt=""></a>
                <a href="#"><img src="img/icon/heart.png" alt=""></a>
                <?php
                session_start();
                $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                ?>
                <a href="cart.php"><img src="img/icon/cart.png" alt=""> <span id="cart-count"><?= $cart_count; ?></span></a>

                <div class="price">$0.00</div>
            </div>
        </div>
    </div>
    <div class="canvas__open"><i class="fa fa-bars"></i></div>
</div>
<script>
    function addToCart(id, name, price, image) {
        let formData = new FormData();
        formData.append("product_id", id);
        formData.append("product_name", name);
        formData.append("product_price", price);
        formData.append("product_image", image);

        fetch("cart_handler.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("cart-count").innerText = data;
                alert("Product added to cart!");
            })
            .catch(error => console.error("Error:", error));
    }
</script>