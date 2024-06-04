<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page1.php");
}

$conn = new mysqli("localhost", "root", "", "video_management");
$query = "SELECT * FROM videos WHERE is_deleted=0";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Video Management Portal</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">Welcome, <?php echo $_SESSION['username']; ?></div>
        <a href="page3.php" class="navbar">Add New Video</a>
        <table>
            <tr>
                <th>Video</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td>
                    <a href="<?php echo $row['link']; ?>" target="_blank">
                        <img src="https://img.youtube.com/vi/<?php echo substr($row['link'], strrpos($row['link'], '/') + 1); ?>/default.jpg" alt="Video Thumbnail">
                    </a>
                </td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <a href="page4.php?id=<?php echo $row['id']; ?>">Update</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this video?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>


