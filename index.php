<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Joetoep</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php include("header.php") ?>
    <h3>Recent videos</h3>
    <div class="container">
        <?php
            $query = "SELECT * FROM videos";
            $output = mysqli_query($sql, $query);
            if ($output) {
                while ($data = mysqli_fetch_assoc($output)) {
                    echo '<div class=videoContainer>
                <img src='.$data['thumbnailpath'].'>
                <a href=http://localhost/joetoep2.0/'.$data['path'].'><h4>'.$data['name'].'</h4></a>
                <a href=http://localhost/joetoep2.0/account/' . $data['accountid'] . '>' . $data['videousername']. '</a>
              </div>';
                }
            }
        ?>
    </div>
</body>
</html>