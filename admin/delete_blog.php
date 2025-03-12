<?php
require './sql/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->execute([$id]);

    echo "<script>alert('Blog deleted!'); window.location='edit_blog.php';</script>";
}
?>
