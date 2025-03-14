<?php
session_start();
require '../db_connect.php';
include 'includes/header.php';

// Handle staff deletion
if (isset($_GET['delete'])) {
    $staffId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM staff WHERE id = ?");
    $stmt->bind_param("i", $staffId);
    if ($stmt->execute()) {
        header("Location: staff.php?success=deleted");
        exit();
    } else {
        $error_message = "Error deleting staff: " . $conn->error;
    }
    $stmt->close();
}

$staffQuery = $conn->query("SELECT id, first_name, last_name, role, username, contact_number, email FROM staff ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .message {
            text-align: center;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #ffcc00; /* Yellow primary color */
            color: black;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .delete-btn {
            background: red;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
        .delete-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Staff List</h1>
    
    <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
        <p class="message success-message">Staff deleted successfully!</p>
    <?php endif; ?>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($staff = $staffQuery->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($staff['id']); ?></td>
                        <td><?php echo htmlspecialchars($staff['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($staff['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($staff['role']); ?></td>
                        <td><?php echo htmlspecialchars($staff['username']); ?></td>
                        <td><?php echo htmlspecialchars($staff['contact_number']); ?></td>
                        <td><?php echo htmlspecialchars($staff['email']); ?></td>
                        <td>
                            <a href="staff.php?delete=<?php echo $staff['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this staff?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>