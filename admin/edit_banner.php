<?php
// Database connection using PDO
 include './sql/config.php';

// Handle file upload and update banner
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['b_id'])) {
        $b_id = $_POST['b_id'];
        $b_des = $_POST['b_des'];

        // Handle file upload
        if (isset($_FILES['b_img']) && $_FILES['b_img']['error'] == 0) {
            $uploadDir = 'uploads/'; // Directory to store uploaded images
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
            }

            $fileName = basename($_FILES['b_img']['name']);
            $uploadFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($_FILES['b_img']['tmp_name'], $uploadFilePath)) {
                // Update the database with the new image path
                $stmt = $pdo->prepare("UPDATE banner SET b_img = ?, b_des = ? WHERE b_id = ?");
                $stmt->execute([$uploadFilePath, $b_des, $b_id]);

                echo "<script>alert('Banner updated successfully!'); window.location='edit_banner.php';</script>";
            } else {
                echo "<script>alert('Failed to upload image.');</script>";
            }
        } else {
            // If no new image is uploaded, update only the description
            $stmt = $pdo->prepare("UPDATE banner SET b_des = ? WHERE b_id = ?");
            $stmt->execute([$b_des, $b_id]);

            echo "<script>alert('Banner description updated successfully!'); window.location='edit_banner.php';</script>";
        }
    }
}

// Delete banner if delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $b_id = $_POST['b_id'];

    $stmt = $pdo->prepare("DELETE FROM banner WHERE b_id = ?");
    $stmt->execute([$b_id]);

    echo "<script>alert('Banner deleted successfully!'); window.location='edit_banner.php';</script>";
}

// Fetch all banners
$stmt = $pdo->prepare("SELECT b_id, b_img, b_des FROM banner ORDER BY b_id ASC");
$stmt->execute();
$banners = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Banners</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 60px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            margin: 40px auto;
            width: 65%;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            padding-left: 30px;
        }
        img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }
        input[type="text"], input[type="file"] {
            padding: 8px;
            width: 60%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 5px 0;
        }
        button {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button[type="submit"][name="delete"] {
            background-color: #dc3545;
            margin-left: 5px;
        }
        button:hover {
            opacity: 0.9;
        }
        .file-input {
            margin-top: 10px;
        }
        .edit {
            background-color: #28a745;
            color: white;
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .delete {
            background-color: #dc3545;
            color: white;
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .edit:hover {
            background-color: #218838;
            color: #ddd;
        }
        .delete:hover {
            background-color: #c82333;
            color: #ddd;
        }
    </style>
</head>
<body>
<?php include 'includes/head.php'; ?>
<?php include 'includes/nav.php'; ?>
    <h2>Edit Banners</h2>
    
    <table>
        <tr>
            <th>Image</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php foreach ($banners as $banner): ?>
        <tr>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="b_id" value="<?php echo $banner['b_id']; ?>">
                <td>
                    <img src="<?php echo $banner['b_img']; ?>" alt="Banner">
                    <div class="file-input">
                        <input type="file" name="b_img" accept="image/*">
                    </div>
                </td>
                <td><input type="text" name="b_des" value="<?php echo $banner['b_des']; ?>"></td>
                <td>
                    <button type="submit">Update</button> |
                    <button type="submit" name="delete">Delete</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>