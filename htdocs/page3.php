<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page1.php");
}

$conn = new mysqli("localhost", "root", "", "video_management");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = $_POST['link'];
    $description = $_POST['description'];

    if (!empty($link) && !empty($description)) {
        $date_added = date('Y-m-d H:i:s');
        $query = "INSERT INTO videos (link, description, date_added, is_deleted) VALUES ('$link', '$description', '$date_added', 0)";
        if ($conn->query($query) === TRUE) {
            header("Location: page2.php");
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Video</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <button class="close-button" onclick="window.location.href='page2.php'">&times;</button>
        <div class="header">Add New Video</div>
        <form method="post" action="">
            <input type="url" name="link" placeholder="Video Link" required>
            <input type="text" name="description" placeholder="Description" required>
            <button type="submit">Save</button>
            <a href="page2.php">Cancel</a>
        </form>
    </div>
</body>
</html>
