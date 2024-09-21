<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h3 {
            font-size: 24px;
            color: #333;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .message.success {
            border-left: 5px solid #28a745;
        }

        .message.error {
            border-left: 5px solid #dc3545;
        }

        .message {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .message.success h3 {
            color: #28a745;
        }

        .message.error h3 {
            color: #dc3545;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Use your database password
$dbname = "certificate_verification";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the certificate number from the form
$certificate_number = $_POST['certificate_number'];
$name = $_POST['name'];
$date_of_birth =  $_POST['date_of_birth'];



// Prepare and execute SQL query
$sql = "SELECT * FROM certificates WHERE certificate_number = ? AND name = ? AND date_of_birth = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $certificate_number, $name, $date_of_birth);
$stmt->execute();
$result = $stmt->get_result();

// Check if certificate exists
if ($result->num_rows > 0) {
    // Certificate found
    $row = $result->fetch_assoc();
    echo "<div class='container'><div class='message success'>";
    echo "<h3>Certificate Found</h3>";
    echo "<p>Name: " . $row['name'] . "</p>";
    echo "<p>Course: " . $row['course'] . "</p>";
    echo "<p>Grade:  " . $row['grade'] . "</p>";
    echo "<p>Issue Date: " . $row['issue_date'] . "</p>";
    echo "<p>Date Of Birth: " . $row['date_of_birth'] . "</p>";
    echo "<a href='index.html' class='btn'>Verify Another</a>";
    echo "</div></div>";
} else {
    // Certificate not found
    echo "<div class='container'><div class='message error'>";
    echo "<h3>Certificate Not Found</h3>";
    echo "<p>The certificate number you entered is invalid.</p>";
    echo "<a href='index.html' class='btn'>Try Again</a>";
    echo "</div></div>";
}

// Close the database connection
$stmt->close();
$conn->close();
?>

</body>
</html>
