<?php
require './sql/config.php';
include 'includes/head.php';
include 'includes/nav.php';
// Fetch blog details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/blogs/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        move_uploaded_file($_FILES['image']['tmp_name'], $filePath);
        $stmt = $pdo->prepare("UPDATE blogs SET title = ?, description = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$title, $description, $filePath, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE blogs SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    echo "<script>alert('Blog updated!'); window.location='edit_blog.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 50%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        textarea {
            height: 100px;
        }

        img {
            width: 100px;
            display: block;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        input[type="file"] {
            border: none;
        }

        .btn-container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        button,
        .back-btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 48%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        button:hover {
            background: #0056b3;
            
        }

        .back-btn {
            background: #6c757d;
            padding: 11px 0;
            
        }

        .back-btn:hover {
            background: #5a6268;
            color: #f8f9fa;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Blog</h2>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $blog['id'] ?>">

            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required>

            <label>Description:</label>
            <textarea name="description" required><?= htmlspecialchars($blog['description']) ?></textarea>

            <label>Current Image:</label>
            <img src="<?= $blog['image_path'] ?>" alt="Blog Image">

            <label>Upload New Image:</label>
            <input type="file" name="image">

            <div class="btn-container">
                <button type="submit">Update</button>
                <a href="edit_blog.php" class="back-btn">Back</a>
            </div>
        </form>
    </div>

</body>

</html>