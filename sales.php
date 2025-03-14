<?php
session_start();
require '../db_connect.php';
include 'includes/header.php';

//  dropdown
$productQuery = $conn->query("SELECT id, name, price, stock FROM products");
$products = $productQuery->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_sale"])) { 
    $productID = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    $productPriceQuery = $conn->prepare("SELECT name, price, stock FROM products WHERE id = ?");
    $productPriceQuery->bind_param("i", $productID);
    $productPriceQuery->execute();
    $productPriceResult = $productPriceQuery->get_result();
    $productPriceRow = $productPriceResult->fetch_assoc();
    $pricePerUnit = $productPriceRow["price"] ?? 0;
    $currentStock = $productPriceRow["stock"] ?? 0;
    $productName = $productPriceRow["name"] ?? "Unknown";

    if ($currentStock >= $quantity) {
        $totalAmount = $quantity * $pricePerUnit;

        // insert sale rec
        $stmt = $conn->prepare("INSERT INTO sales (product_id, quantity, price_per_unit, total_amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iidd", $productID, $quantity, $pricePerUnit, $totalAmount);
        $stmt->execute();
        $stmt->close();

        // upd stock
        $newStock = $currentStock - $quantity;
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $newStock, $productID);
        $stmt->execute();
        $stmt->close();

        // ins inv log 
        $logDescription = "$quantity item(s) of $productName sold. Stock decreased by $quantity.";
        $stmt = $conn->prepare("INSERT INTO inventory_log (product_id, description) VALUES (?, ?)");
        $stmt->bind_param("is", $productID, $logDescription);
        $stmt->execute();
        $stmt->close();

        header("Location: sales.php?success=added");
        exit();
    } else {
        header("Location: sales.php?error=insufficient_stock");
        exit();
    }
}

$sales = $conn->query("SELECT sales.id, products.name AS product_name, sales.quantity, sales.price_per_unit, sales.total_amount, sales.created_at 
                       FROM sales JOIN products ON sales.product_id = products.id ORDER BY sales.created_at DESC");
?>

<div class="container">
    <h1>Sales Management</h1>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-message">
            <?php echo $_GET['success'] === 'added' ? "Sale added successfully!" : "Sale deleted successfully!"; ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'insufficient_stock'): ?>
        <p class="error-message">Insufficient stock available for the selected product.</p>
    <?php endif; ?>

    <form method="POST" class="form">
        <label>Product Name:</label>
        <select name="product_id" required>
            <option value="" disabled selected>Select a product</option>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo $product['id']; ?>"> <?php echo $product['name']; ?> </option>
            <?php endforeach; ?>
        </select>

        <label>Quantity:</label>
        <input type="number" name="quantity" required min="1">
        
        <button type="submit" name="add_sale" class="btn">Add Sale</button>
    </form>

    <div class="report-button">
        <a href="reports.php" class="btn-report">View Sales Reports</a>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price Per Unit</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $sales->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>₱<?php echo number_format($row['price_per_unit'], 2); ?></td>
                        <td>₱<?php echo number_format($row['total_amount'], 2); ?></td>
                        <td><?php echo date("F d, Y h:i A", strtotime($row['created_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    * {
        box-sizing: border-box;
    }
    body {
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .container {
        max-width: 1000px;
        margin: auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        flex: 1;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    .success-message, .error-message {
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .success-message {
        color: green;
    }
    .error-message {
        color: red;
    }
    .form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .form input, .form select, .btn {
        padding: 10px;
        width: 100%;
    }
    .btn {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }
    .report-button {
        text-align: center;
        margin: 20px 0;
    }
    .btn-report {
        background-color: #f39c12;
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
    }
    .table-container {
        overflow-y: auto;
        max-height: 500px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    .table th {
        background: #007bff;
        color: white;
    }
</style>
