<?php
require './sql/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $label = $_POST['label'];
    $rating = $_POST['rating'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $targetDir = "img/product/";
    $targetFile = $targetDir . basename($image);

    // Check if the uploads directory exists, if not create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Move the uploaded file first
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // Insert product into the database
        $sql = "INSERT INTO products (name, price, image, category, label, rating) 
                VALUES (:name, :price, :image, :category, :label, :rating)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'price' => $price,
            'image' => $targetFile, // Store full path
            'category' => $category,
            'label' => $label,
            'rating' => $rating
        ]);

        // Redirect to avoid form resubmission on refresh
        header("Location: ".$_SERVER['PHP_SELF']."?success=1");
        exit();
    } else {
        echo "<script>alert('Failed to upload image. Error: " . $_FILES['image']['error'] . "');</script>";
    }
}


if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>alert('Product Added Successfully!');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1{
            text-align: center;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="file"] {
            border: none;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 15px;
            width: 100%;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/nav.php'; ?>

    <form method="POST" enctype="multipart/form-data">
    <h1>Add Product</h1>
        <label>Product Name:</label>
        <input type="text" name="name" required><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required><br>

        <label>Category:</label>
        <input type="text" name="category" required><br>

        <label>Label:</label>
        <input type="text" name="label" required><br>

        <label>Rating (0-5):</label>
        <input type="number" step="0.1" name="rating" min="0" max="5" required><br>

        <label>Product Image:</label>
        <input type="file" name="image" required><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
