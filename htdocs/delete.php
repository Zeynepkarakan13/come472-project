<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page1.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "video_management");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Videoyu is_deleted olarak işaretleyin
    $query = "UPDATE videos SET is_deleted=1 WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        header("Location: page2.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: page2.php");
}

$conn->close();
?>

