<?php
// Database connection using PDO
$dsn = "mysql:host=localhost;dbname=dashborad;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch banners from the database
$stmt = $pdo->prepare("SELECT * FROM banner ORDER BY b_id ASC");
$stmt->execute();
$banners = $stmt->fetchAll();
?>

<section class="banner spad">
    <div class="container">
        <div class="row">
            <?php if (!empty($banners)): ?>
                <?php foreach ($banners as $index => $banner): ?>
                    <div class="col-lg-<?php echo ($index == 1) ? '5' : '7'; ?> <?php echo ($index == 1) ? '' : 'offset-lg-4'; ?>">
                        <div class="banner__item <?php echo ($index == 1) ? 'banner__item--middle' : (($index == 2) ? 'banner__item--last' : ''); ?>">
                            <div class="banner__item__pic">
                                <img src="<?php echo htmlspecialchars($banner['b_img']); ?>" alt="">
                            </div>
                            <div class="banner__item__text">
                                <h2><?php echo htmlspecialchars($banner['b_des']); ?></h2>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No banners available.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
