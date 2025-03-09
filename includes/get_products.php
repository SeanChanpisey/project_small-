<?php
include 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<div class="row product__filter">
    <?php foreach ($products as $product): ?>
        <div class="col-lg-3 col-md-6 col-sm-6 mix <?= htmlspecialchars($product['category']); ?>">
            <div class="product__item <?= $product['label'] ? 'sale' : ''; ?>">
                <div class="product__item__pic set-bg" data-setbg="<?= htmlspecialchars($product['image']); ?>">
                    <?php if ($product['label']): ?>
                        <span class="label"><?= htmlspecialchars($product['label']); ?></span>
                    <?php endif; ?>
                    <ul class="product__hover">
                        <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                        <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                        <li><a href="#"><img src="img/icon/search.png" alt=""></a></li>
                    </ul>
                </div>
                <div class="product__item__text">
                    
                    <h6><?= htmlspecialchars($product['name']); ?></h6>
                    <button class="add-cart" onclick="addToCart(<?= $product['id']; ?>, '<?= htmlspecialchars($product['name']); ?>', <?= $product['price']; ?>, '<?= htmlspecialchars($product['image']); ?>')">+ Add To Cart</button>
                    

                    <div class="rating">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fa <?= $i < $product['rating'] ? 'fa-star' : 'fa-star-o'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <h5>$<?= number_format($product['price'], 2); ?></h5>
                    
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>