<?php
require './sql/config.php';

// Set how many products to display per page
$limit = 5;

// Get the current page number from URL, default is 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure page is always 1 or higher

// Calculate the starting point
$start = ($page - 1) * $limit;

// Fetch total number of products
$totalQuery = $pdo->query("SELECT COUNT(*) FROM products");
$totalProducts = $totalQuery->fetchColumn();
$totalPages = ceil($totalProducts / $limit);

// Fetch products for the current page
$sql = "SELECT * FROM products ORDER BY id DESC LIMIT :start, :limit";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recently Added Products</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 40px auto;
            width: 65%;
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
            background-color: #007bff;
            color: white;
            padding-left: 30px; 
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

        .pagination {
            text-align: center;
            margin: 20px 0;
            position: relative;
            
            display: block !important;
           
            z-index: 1000;
           
        }

        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            margin: 5px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }

        .pagination a:hover {
            background: #0056b3;
            color: #ddd;
        }
    </style>
</head>
<?php include 'includes/head.php'; ?>

<body>

    <?php include 'includes/nav.php'; ?>

    <div>
        <h1 class="text-center">Recently Added Products</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']); ?></td>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td>$<?= number_format($product['price'], 2); ?></td>
                    <td><?= htmlspecialchars($product['category']); ?></td>
                    <td>
                        <img src="<?= htmlspecialchars($product['image']); ?>" width="50" height="50" onerror="this.src='img/product/';">
                    </td>
                    <td>
                        <a class="edit" href="./sql/edit_delete.php?id=<?= htmlspecialchars($product['id']); ?>">Edit</a> |
                        <a class="delete" href="./sql/delete.php?id=<?= htmlspecialchars($product['id']); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>">← Previous</a>
            <?php endif; ?>

            <span>Page <?= $page; ?> of <?= $totalPages; ?></span>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1; ?>">Next →</a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>