<?php
include "includes/db.php";

// Fetch blogs from the database
$stmt = $pdo->prepare("SELECT * FROM blogs ORDER BY date DESC");
$stmt->execute();
$blogs = $stmt->fetchAll();
?>

<section class="blog spad">
    <div class="container">
        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <!-- <div class="blog__item__pic set-bg" data-setbg="<?= $blog['image_path']; ?>"></div> -->
                        <div class="blog__item__text">
                            <span><img src="<?php echo 'admin/' . $blog['image_path']; ?>" alt="Blog Image">
                            <?= date('d F Y', strtotime($blog['date'])); ?></span>
                            <h5><?= htmlspecialchars($blog['title']); ?></h5>
                            <p><?= substr(htmlspecialchars($blog['description']), 0, 50); ?>...</p>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
