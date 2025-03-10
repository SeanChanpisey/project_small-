<?php
require './sql/config.php';

// Fetch the current logo path
$stmt = $pdo->query("SELECT logo_path FROM logo_settings WHERE id = 1");
$logo = $stmt->fetch(PDO::FETCH_ASSOC);
$logo_path = $logo ? $logo['logo_path'] : '';

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
    $upload_dir = 'uploads/'; // Ensure this folder exists and is accessible
    $file_name = basename($_FILES['logo']['name']);
    $file_path = $upload_dir . $file_name;

    // Move the uploaded file to the uploads directory
    if (move_uploaded_file($_FILES['logo']['tmp_name'], $file_path)) {
        // Store the correct path that works for both admin and frontend
        $db_file_path = 'uploads/' . $file_name;

        $stmt = $pdo->prepare("UPDATE logo_settings SET logo_path = ? WHERE id = 1");
        $stmt->execute([$db_file_path]);

        echo "<script>alert('Logo updated successfully!'); window.location='edit_logo.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to upload logo. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Logo</title>
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
            width: 50%;
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
        }
        img {
            max-width: 120px;
            height: auto;
            border-radius: 4px;
            margin-top: 10px;
        }
        input[type="file"] {
            padding: 8px;
            width: 80%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }
        button {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        button:hover {
            opacity: 0.9;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .file-input {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/nav.php'; ?>

    <h2>Edit Logo</h2>

    <table>
        <tr>
            <th>Current Logo</th>
            <th>Upload New Logo</th>
        </tr>
        <tr>
            <td>
                <?php if ($logo_path): ?>
                    <img src="<?= htmlspecialchars($logo_path) ?>" alt="Logo">
                <?php else: ?>
                    <p>No logo set.</p>
                <?php endif; ?>
            </td>
            <td>
                <form method="POST" enctype="multipart/form-data">
                    <div class="file-input">
                        <input type="file" name="logo" accept="image/*" required>
                    </div>
                    <button type="submit">Update Logo</button>
                </form>
            </td>
        </tr>
    </table>

</body>
</html>
