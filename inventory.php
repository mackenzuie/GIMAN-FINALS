<?php
session_start();
require '../db_connect.php';
include 'includes/header.php';

// inve data
$inventory = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<div class="container">
    <h1 class="center">Inventory Management</h1>
    
    <div class="center">
        <a href="inventory_log.php" class="log-btn">View Inventory Log</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <p class="success">
            <?php echo $_GET['success'] === 'updated' ? "Stock updated successfully!" : "Product deleted successfully!"; ?>
        </p>
    <?php endif; ?>

    <table class="inventory-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Last Restock</th>
                <th>Expiry Date</th>
                <th>Reorder Level</th>
                <th>Date of Inventory</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $inventory->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>₱<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo $row['last_restock_date'] ?? 'N/A'; ?></td>
                    <td><?php echo $row['expiry_date'] ?? 'N/A'; ?></td>
                    <td><?php echo $row['reorder_level'] ?? 'N/A'; ?></td>
                    <td><?php echo date("Y-m-d"); ?></td>
                    <td>
                        <a href="update_stock.php?id=<?php echo $row['id']; ?>&action=subtract" class="btn btn-danger btn-sm">-</a>
                        <a href="update_stock.php?id=<?php echo $row['id']; ?>&action=add" class="btn btn-success btn-sm">+</a>
                        <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<style>
    .container { max-width: 1000px; margin: auto; padding: 20px; font-family: Arial, sans-serif; position: relative; min-height: 100vh; }
    .center { text-align: center; }
    .inventory-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .inventory-table th, .inventory-table td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    .inventory-table th { background: #007bff; color: white; }
    .success { color: green; font-weight: bold; text-align: center; margin-bottom: 10px; }
    .log-btn { display: inline-block; margin-bottom: 15px; padding: 10px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
    .log-btn:hover { background: #218838; }
    .btn { padding: 5px 10px; border-radius: 5px; text-decoration: none; font-weight: bold; margin: 0 3px; }
    .btn-danger { background: #dc3545; color: white; }
    .btn-danger:hover { background: #c82333; }
    .btn-success { background: #28a745; color: white; }
    .btn-success:hover { background: #218838; }
    .btn-warning { background: #ffc107; color: black; }
    .btn-warning:hover { background: #e0a800; }
    .footer { position: absolute; bottom: 0; width: 100%; background: #007bff; color: white; text-align: center; padding: 10px 0; }
</style>

<?php include 'includes/footer.php'; ?>