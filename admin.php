<?php
// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$host = 'localhost';
$dbname = 'certificate_verification';
$username = 'root'; // change as per your MySQL config
$password = ''; // change as per your MySQL config
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Add Certificate
if (isset($_POST['add_certificate'])) {
    $certificate_number = $_POST['certificate_number'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $grade = $_POST['grade'];
    $issue_date = $_POST['issue_date'];
    $date_of_birth = $_POST['date_of_birth'];
    
    $sql = "INSERT INTO certificates (certificate_number, name, course, grade, issue_date, date_of_birth) VALUES (:certificate_number, :name, :course, :issue_date)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['certificate_number' => $certificate_number, 'name' => $name, 'course' => $course, 'grade' => $grade, 'issue_date' => $issue_date, 'date_of_birth' =>  $date_of_birth]);

}

// Delete Certificate
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM certificates WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// Fetch Certificates
$sql = "SELECT * FROM certificates";
$stmt = $conn->prepare($sql);
$stmt->execute();
$certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Module</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }
        form input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form input[type="submit"] {
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .certificates {
            margin-top: 20px;
        }
        .certificates ul {
            list-style-type: none;
            padding: 0;
        }
        .certificates li {
            background-color: #f4f4f4;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }
        .certificates a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .certificates a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Module - Manage Certificates</h1>

    <h2>Add a New Certificate</h2>
    <form action="admin.php" method="POST">
        <input type="text" name="certificate_number" placeholder="Certificate Number" required>
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="course" placeholder="Course" required>
        <input type="text" name="grade" placeholder="Grade" required>
        <input type="date" name="issue_date" placeholder="Issue Date YYYY-MM-DD" required>
        <input type="date" name="date_of_birth" placeholder="Date of Birth" required>

        <input type="submit" name="add_certificate" value="Add Certificate">
    </form>

    <div class="certificates">
        <h2>Existing Certificates</h2>
     <ul>
        <?php foreach ($certificates as $cert): ?>
            <li>
                <?= $cert['name'] ?> - <?= $cert['course'] ?> - <?= $grade['grade'] ?> - <?= $cert['issue_date'] ?> - <?= $cert['date_of_birth'] ?>


               
                <div>
                     <a href="admin.php?delete=<?= $cert['id'] ?>">[Delete]</a>
                     <a href="edit.php?id=<?= $cert['id'] ?>">[Edit]</a>
                </div>
                
            </li>
        <?php endforeach; ?>
     </ul>
    </div>
    

    <a href="admin_landing_page.php">Back to Home</a>
</div>

</body>
</html>
// (<?= $cert['status'] ?>)