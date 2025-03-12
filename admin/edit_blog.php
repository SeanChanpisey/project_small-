<!DOCTYPE html>
<?php
require './sql/config.php';
include 'includes/head.php';
include 'includes/nav.php';
include 'includes/footScript.php';

// Fetch all blogs
$stmt = $pdo->prepare("SELECT * FROM blogs ORDER BY id DESC");
$stmt->execute();
$blogs = $stmt->fetchAll();

// Handle form submission for adding a blog
if (isset($_POST['submit'])) {  // Check if button is clicked
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = date('Y-m-d');

    if (!empty($title) && !empty($description)) {
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $fileName = basename($_FILES['image']['name']);
            $filePath = $uploadDir . $fileName;

            move_uploaded_file($_FILES['image']['tmp_name'], $filePath);

            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO blogs (title, description, image_path, date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $description, $filePath, $date]);

            echo "<script>alert('Blog added successfully!'); window.location='edit_blog.php';</script>";
        } else {
            echo "<script>alert('Error uploading image');</script>";
        }
    } else {
        echo "<script>alert('Title and Description are required');</script>";
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-container {
            width: 65%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .title-input {
            font-size: 1.5em;
            font-weight: bold;
            padding: 12px;
        }

        /* .image-preview {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            display: none;
            border-radius: 5px;
        } */

        button {
            padding-top: 10px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        /* Table Styling - Restored */
        table {
            width: 70%;
            margin: 40px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            max-width: 100px;
            border-radius: 5px;
        }

        .edit,
        .delete {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }

        .edit {
            background: #28a745;
        }

        .delete {
            background: #dc3545;
        }

        .edit:hover {
            background: #218838;
        }

        .delete:hover {
            background: #c82333;
        }
    </style>

    <!-- TinyMCE Script -->
    
</head>

<body>
    <h2>Manage Blogs</h2>

    <div class="form-container">
        <h3>Add New Blog</h3>
        <form method="POST" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" class="title-input" name="title" required>

            <label>Description:</label>
            <textarea class="textarea-tiny" name="description" required></textarea>

            <label>Upload Image:</label>
            <input type="file" name="image" required onchange="previewImage(event)">
            <img id="imagePreview" class="image-preview" alt="Image Preview">

            <button type="submit" name="submit" onclick="tinymce.triggerSave();">Add Blog</button>
        </form>

    </div>

    <table>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($blogs as $blog): ?>
            <tr>
                <td><img src="<?php echo $blog['image_path']; ?>" alt="Blog Image" style="max-width: 100px; border-radius: 5px;"></td>
                <td><?php echo $blog['title']; ?></td>
                <td><?php echo substr($blog['description'], 0, 50) . '...'; ?></td>
                <td>
                    <a href="update_blog.php?id=<?php echo $blog['id']; ?>" class="edit">Edit</a>
                    <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>