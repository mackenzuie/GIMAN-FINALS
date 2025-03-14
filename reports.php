<?php
session_start();
require '../db_connect.php';
//include 'includes/header.php'; DIKO SURE IF MAGANDA MAY GANTO OR WALA

// 4 report
$salesQuery = $conn->query("
    SELECT p.name AS product_name, 
           SUM(s.quantity) AS total_quantity, 
           SUM(s.total_amount) AS total_sales, 
           DATE(s.created_at) AS sale_date 
    FROM sales s 
    JOIN products p ON s.product_id = p.id 
    GROUP BY p.name, DATE(s.created_at) 
    ORDER BY s.created_at ASC");

$salesData = [];
while ($row = $salesQuery->fetch_assoc()) {
    $salesData[] = $row;
}
?>

<div class="container">
    <h1>Sales Reports</h1>

    <div class="chart-container">
        <h2>Sales Overview</h2>
        <canvas id="salesChart"></canvas>
    </div>

    <div class="chart-container">
        <h2>Sales Trend Over Time</h2>
        <canvas id="trendChart"></canvas>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Total Quantity Sold</th>
                    <th>Total Sales</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salesData as $sale): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                        <td><?php echo number_format($sale['total_quantity']); ?></td>
                        <td>₱<?php echo number_format($sale['total_sales'], 2); ?></td>
                        <td><?php echo $sale['sale_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="back-button">
        <a href="sales.php" class="btn-back">Back to Sales</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const salesData = <?php echo json_encode($salesData); ?>;

    // pang extract
    const productLabels = salesData.map(sale => sale.product_name);
    const salesAmounts = salesData.map(sale => sale.total_sales);
    const saleDates = salesData.map(sale => sale.sale_date);

    new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'Total Sales (₱)',
                data: salesAmounts,
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Total Sales by Product' }
            }
        }
    });

    new Chart(document.getElementById('trendChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: saleDates,
            datasets: [{
                label: 'Sales Over Time (₱)',
                data: salesAmounts,
                borderColor: 'rgba(40, 167, 69, 1)',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Sales Trend Over Time' }
            },
            scales: {
                x: { title: { display: true, text: 'Date' } },
                y: { title: { display: true, text: 'Total Sales (₱)' } }
            }
        }
    });
});
</script>

<style>
    * {
        box-sizing: border-box;
    }
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #f8f9fa;
    }
    .container {
        width: 90%;
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
    h1, h2 {
        text-align: center;
        color: #333;
    }
    .chart-container {
        text-align: center;
        margin: 20px 0;
    }
    .table-container {
        overflow-y: auto;
        max-height: 500px;
        margin-top: 20px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    .table th {
        background: #ffc107;
        color: white;
    }
    .btn-back {
        display: block;
        width: fit-content;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        text-align: center;
    }
    .btn-back:hover {
        background-color: #0056b3;
    }
</style>
