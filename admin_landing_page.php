<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f4f4f4;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 1.1em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, Admin!</h1>
    <p>What would you like to do today?</p>

    <a href="admin.php" class="btn">Manage Certificates</a>
    <a href="view_logs.php" class="btn">View Logs</a> <!-- You can create this page for more admin tasks -->
    <a href="logout.php" class="btn" style="background-color: #dc3545;">Logout</a>
</div>

</body>
</html>
