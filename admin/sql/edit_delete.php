<?php
require './config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $label = $_POST['label'];

    
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "img/product/";
    
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        } else {
            echo "<script>alert('Error uploading file!');</script>";
            $image = $product['image']; 
        }
    } else {
        $image = $product['image']; 
    }
    

    $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, category=?, label=?, image=? WHERE id=?");
    $stmt->execute([$name, $price, $category, $label, $image, $id]);

    echo "<script>alert('Product Updated Successfully!'); </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .edit-container {
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        img {
            width: 100px;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="edit-container">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Product Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']); ?>" required>

        <label>Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category']); ?>" required>

        <label>Label</label>
        <input type="text" name="label" value="<?= htmlspecialchars($product['label']); ?>" required>

        <label>Product Image</label>
        <input type="file" name="image">
        <img src="<?= htmlspecialchars($product['image']); ?>" alt="Product Image" onerror="this.style.display='none'">

        <button type="submit">Update</button>
    </form>
    <a class="back-link" href="../form.php">← Back to Products</a>
</div>

</body>
</html>
