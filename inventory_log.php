<?php
session_start();
require '../db_connect.php';
// include 'includes/header.php';

// inv logs
$logs = $conn->query("SELECT inventory_log.id, products.name AS product_name, inventory_log.description, inventory_log.date 
                       FROM inventory_log 
                       LEFT JOIN products ON inventory_log.product_id = products.id 
                       ORDER BY inventory_log.date DESC");
?>

<div class="container">
    <h1 class="title">Inventory Log</h1>
    
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search logs..." class="search-bar" onkeyup="filterLogs()">
        <span class="search-icon">&#128269;</span>
    </div>
    
    <a href="inventory.php" class="back-btn">Back to Inventory</a>

    <table class="log-table" id="logTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $logs->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['product_name'] ? $row['product_name'] : 'Unknown Product'; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo date("F d, Y h:i A", strtotime($row['date'])); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<style>
    .container { max-width: 900px; margin: auto; padding: 20px; font-family: Arial, sans-serif; text-align: center; }
    .title { font-size: 28px; font-weight: bold; margin-bottom: 20px; }
    .search-container { position: relative; display: inline-block; }
    .search-bar { width: 250px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .search-icon { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 18px; }
    .back-btn { display: inline-block; margin-bottom: 15px; padding: 10px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
    .back-btn:hover { background: #218838; }
    .log-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .log-table th, .log-table td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    .log-table th { background: #007bff; color: white; position: sticky; top: 0; }
    .log-table tr:nth-child(even) { background: #f2f2f2; }
</style>

<script>
    function filterLogs() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("logTable");
        let rows = table.getElementsByTagName("tr");
        
        for (let i = 1; i < rows.length; i++) {
            let product = rows[i].getElementsByTagName("td")[1];
            let date = rows[i].getElementsByTagName("td")[3];
            if (product || date) {
                let txtValue = product.textContent || product.innerText;
                let dateValue = date.textContent || date.innerText;
                rows[i].style.display = (txtValue.toLowerCase().indexOf(filter) > -1 || dateValue.toLowerCase().indexOf(filter) > -1) ? "" : "none";
            }
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
