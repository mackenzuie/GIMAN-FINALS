<?php 
session_start();
include 'includes/header.php'; 
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
            padding: 25px;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .welcome-section h1 {
            font-size: 34px;
            color: #333;
            margin-bottom: 10px;
        }
        .welcome-section p {
            font-size: 18px;
            color: #555;
            margin-bottom: 25px;
        }

        .quick-links h2 {
            font-size: 22px;
            color: #444;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .link-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }
        .link-buttons a {
            text-decoration: none;
            background: #ff6600;
            color: white;
            padding: 14px 24px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .link-buttons a:hover {
            background: #cc5500;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

    <div class="header">DESIGN WELL DITO hahadhaAHAHSASAHA ANAGSAN MO ILALALAGAY PLS</div>

    <div class="container">
        <div class="welcome-section">
            <h1>Welcome, Admin! DAPAT NAME, OR ANO?</h1>
            <p>Stay in control. Manage staff, products, and sales with ease.</p>
        </div>

        <div class="quick-links">
            <h2>Quick Access</h2>
            <div class="link-buttons">
                <a href="dashboard.php">Dashboard</a>
                <a href="staff_management.php">Staff</a>
                <a href="inventory.php">Inventory</a>
                <a href="sales.php">Sales</a>
            </div>
        </div>
    </div>

</body>
</html>

<?php include 'includes/footer.php'; ?>
