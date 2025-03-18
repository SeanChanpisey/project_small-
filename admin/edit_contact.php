<!DOCTYPE html>
<?php
require './sql/config.php';
include 'includes/head.php';
include 'includes/nav.php';
include 'includes/footScript.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description']; // Supports rich text
    $address_1 = $_POST['address_1'];
    $phone_1 = $_POST['phone_1'];
    $address_2 = $_POST['address_2'];
    $phone_2 = $_POST['phone_2'];

    $stmt = $pdo->prepare("UPDATE contact_page SET title=?, description=?, address_1=?, phone_1=?, address_2=?, phone_2=? WHERE id=1");
    $stmt->execute([$title, $description, $address_1, $phone_1, $address_2, $phone_2]);

    echo "<script>alert('Contact details updated!'); window.location='edit_contact.php';</script>";
}

$stmt = $pdo->query("SELECT * FROM contact_page WHERE id = 1");
$contact = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact Page</title>

    <!-- TinyMCE Integration -->
   

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
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        button {
            width: 30%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Edit Contact Page</h2>
    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($contact['title']) ?>" required>

        <label>Description:</label>
        <textarea class="textarea-tiny" name="description"><?= htmlspecialchars($contact['description']) ?></textarea>

        <label>Location 1 Address:</label>
        <input type="text" name="address_1" value="<?= htmlspecialchars($contact['address_1']) ?>">

        <label>Location 1 Phone:</label>
        <input type="text" name="phone_1" value="<?= htmlspecialchars($contact['phone_1']) ?>">

        <label>Location 2 Address:</label>
        <input type="text" name="address_2" value="<?= htmlspecialchars($contact['address_2']) ?>">

        <label>Location 2 Phone:</label>
        <input type="text" name="phone_2" value="<?= htmlspecialchars($contact['phone_2']) ?>">

        <button type="submit">Update Contact Page</button>
    </form>
</div>
</body>
</html>
