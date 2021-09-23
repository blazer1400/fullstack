<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="search.css">
</head>
<body>
    <?php include("header.php"); ?>
    <div class="container">
        <div class="videos">
            <h2>Videos</h2>
            <?php
            $query = "SELECT * FROM videos WHERE name LIKE '%".$_GET['search']."%'";
            $output = mysqli_query($sql, $query);
            while ($data = mysqli_fetch_assoc($output)) {
                echo "<div class='videoContainer'>
                    <img src='".$data['thumbnailpath']."'>
                    <a href='".$data['path']."'><h3>".$data['name']."</h3></a>
                </div>
                ";
            }
            ?>
        </div>
        <hr>
        <div class="accounts">
            <h2>Accounts</h2>
            <?php
            $query = "SELECT * FROM accounts WHERE username LIKE '%".$_GET['search']."%'";
            $output = mysqli_query($sql,$query);
            while ($data = mysqli_fetch_assoc($output)) {
                echo "<div class='accountContainer'>
                    <img src='account/".$data['id']."/".$data['avatarpath']."'>
                    <a href='account/".$data['id']."'><h3>".$data['username']."</h3></a>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>