<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лента постов пользователей</title>
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
    <h1>Лента постов пользователей</h1>
    
    <?php
    require_once('../includes/db.php'); 

    $sql = "SELECT * FROM posts";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h3>{$row['title']}</h3>";
            echo "<h4>{$row['content']}</h4>";
            echo "<p>{$row['likes']}</p>";
            echo "</div>";
        }
    } else {
        echo "Постов пока нет.";
    }
    ?>

</body>
</html>
