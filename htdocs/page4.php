<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page1.php");
}

$conn = new mysqli("localhost", "root", "", "video_management");
$id = $_GET['id'];

$query = "SELECT * FROM videos WHERE id=$id";
$result = $conn->query($query);
$video = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = $_POST['link'];
    $description = $_POST['description'];

    if (!empty($link) && !empty($description)) {
        $query = "UPDATE videos SET link='$link', description='$description' WHERE id=$id";
        $conn->query($query);
        header("Location: page2.php");
    } else {
        echo "<script>alert('Please fill in all fields');</script>";
    }
}
$thumbnail_url = "";
if (!empty($video['link'])) {
    $video_id = substr($video['link'], strrpos($video['link'], '/') + 1);
    $thumbnail_url = "https://img.youtube.com/vi/$video_id/default.jpg";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Video</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <button class="close-button" onclick="window.location.href='page2.php'">&times;</button>
        <div class="header">Update Video</div>
        <form method="post" action="">
            <input type="url" name="link" value="<?php echo $video['link']; ?>" required oninput="updateThumbnail(this.value)">
            <input type="text" name="description" value="<?php echo $video['description']; ?>" required>
            <button type="submit">Save</button>
            <a href="page2.php">Cancel</a>
        </form>
        <a id="video-link" href="<?php echo $video['link']; ?>" target="_blank"><img id="thumbnail" class="thumbnail" src="<?php echo $thumbnail_url; ?>" alt="Video Thumbnail"></a>
    </div>
    <script>
        function updateThumbnail(url) {
            const videoId = url.split('/').pop();
            const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/default.jpg`;
            document.getElementById('thumbnail').src = thumbnailUrl;
            document.getElementById('video-link').href = url;
        }
    </script>
</body>
</html>
