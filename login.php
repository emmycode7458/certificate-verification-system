<?php
// Start session
session_start();

// Database connection
$host = 'localhost';
$dbname = 'certificate_verification';
$username = 'root'; 
$password = ''; 
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Check login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 

    // Fetch user from database
    $sql = "SELECT * FROM admins WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password (in a real app, you should use password_hash and password_verify)
    if ($admin && $admin['password'] === md5($password)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_landing_page.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 350px;
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Admin Login</h1>

    <?php if (isset($error)): ?>
        <p class="error-message"><?= $error ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
    </form>
</div>

</body>
</html>
