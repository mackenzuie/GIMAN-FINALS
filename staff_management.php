<?php
session_start();
require '../db_connect.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_staff'])) {
    $firstName = trim(mysqli_real_escape_string($conn, $_POST['first_name']));
    $lastName = trim(mysqli_real_escape_string($conn, $_POST['last_name']));
    $role = trim(mysqli_real_escape_string($conn, $_POST['role']));
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $contactNumber = trim(mysqli_real_escape_string($conn, $_POST['contact_number']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));

    $checkQuery = $conn->prepare("SELECT id FROM staff WHERE username = ? OR email = ?");
    $checkQuery->bind_param("ss", $username, $email);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username or Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO staff (first_name, last_name, role, username, password, contact_number, email) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstName, $lastName, $role, $username, $password, $contactNumber, $email);

        if ($stmt->execute()) {
            header("Location: staff.php?success=added");
            exit();
        } else {
            $error_message = "Error adding staff: " . $conn->error;
        }
        $stmt->close();
    }
    $checkQuery->close();
}

$staffQuery = $conn->query("SELECT id, first_name, last_name, role, username, contact_number, email FROM staff ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
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
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
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
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-container {
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        .btn {
            padding: 12px;
            background-color: #ffcc00; /* Yellow primary color */
            color: black;
            border: none;
            cursor: pointer;
            text-align: center;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #e6b800;
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
            padding: 6px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Staff Management</h1>

    <?php if (isset($error_message)): ?>
        <p class="message error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'added'): ?>
        <p class="message success-message">Staff added successfully!</p>
    <?php endif; ?>

    <div class="form-container">
        <h2>Add New Staff</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="first_name" required>

            <label>Last Name:</label>
            <input type="text" name="last_name" required>

            <label>Role:</label>
            <input type="text" name="role" required>

            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Contact Number:</label>
            <input type="text" name="contact_number" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <button type="submit" name="add_staff" class="btn">Add Staff</button>
        </form>
    </div>

    <div class="table-container">
        <h2>Staff List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Username</th>
                <th>Contact</th>
                <th>Email</th>
            </tr>
            <?php while ($row = $staffQuery->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['contact_number']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
