<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['staff_name'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$staffName = $_SESSION['staff_name'];
$verse = "Commit to the Lord whatever you do, and he will establish your plans. – Proverbs 16:3";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 50px;
        }
        .welcome-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        .verse {
            font-style: italic;
            font-size: 16px;
            margin-top: 15px;
            color: #666;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: #ffcc00;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn:hover {
            background: #e6b800;
        }
    </style>
</head>
<body>

    <div class="welcome-box">
        <h1>Welcome, <?php echo htmlspecialchars($staffName); ?>!</h1>
        <p>Have a great day working! May your efforts be blessed. 😊</p>
        <p class="verse">"<?php echo $verse; ?>"</p>
        <a href="dashboard.php" class="btn">Go to Dashboard</a>
    </div>

</body>
</html>
