<?php
session_start();
require '../db_connect.php'; 
include 'includes/header.php'; 

if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}

$adminName = $_SESSION['staff_name'];

// tot sales
$salesQuery = $conn->query("SELECT SUM(total_amount) AS total_sales FROM sales");
$totalSales = ($salesQuery && $salesQuery->num_rows > 0) ? $salesQuery->fetch_assoc()['total_sales'] : 0;

// tot products
$productsQuery = $conn->query("SELECT COUNT(*) AS total_products FROM products");
$totalProducts = ($productsQuery && $productsQuery->num_rows > 0) ? $productsQuery->fetch_assoc()['total_products'] : 0;

// staff
$staffQuery = $conn->query("SELECT COUNT(*) AS total_staff FROM staff");
$totalStaff = ($staffQuery && $staffQuery->num_rows > 0) ? $staffQuery->fetch_assoc()['total_staff'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MARV SHAWARMA - Admin Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f4f4f4;
        }

        .header {
            background-color: #ffcc00;
            color: #333;
            padding: 20px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-info {
            font-size: 18px;
            font-weight: bold;
            margin-left: 20px;
        }

        .positive-message {
            font-size: 16px;
            font-weight: bold;
            color: #444;
            text-transform: uppercase;
            margin-right: 20px;
            padding: 10px 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .dashboard-title {
            font-size: 30px;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: #ff6600;
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            transition: 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            background: #cc5500;
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 22px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="admin-info">Welcome, <?php echo htmlspecialchars($adminName); ?>!</div>
        <div class="positive-message">😊 Smile! Hard work pays off! 💪</div>
    </div>

    <div class="container">
        <h1 class="dashboard-title">Dashboard Overview</h1>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Sales</h3>
                <p><?php echo "₱" . number_format($totalSales, 2); ?></p>
            </div>
            <div class="card">
                <h3>Total Products</h3>
                <p><?php echo $totalProducts; ?></p>
            </div>
            <div class="card">
                <h3>Total Staff</h3>
                <p><?php echo $totalStaff; ?></p>
            </div>
        </div>
    </div>

</body>
</html>

<?php include 'includes/footer.php'; ?>
