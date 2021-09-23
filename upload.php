<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <link rel="stylesheet" href="upload.css">
</head>
<body>
    <?php include("header.php");
    if (empty($_SESSION['id'])) {
        header("Location: index.php");
    }
    ?>
    <div class="container">
        <h3>Upload video</h3>
        <hr>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Name: </label><input type="text" name="name" id="name"><br>
            <label for="video">Video: </label>
            <div class="forminline">
                <input type="file" name='video' id="video" accept="video/mp4">
                <label for="thumbnail">(optional) Thumbnail: </label><input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                <input type="submit" name="upload" value="Upload" id="upload">
            </div>

        </form>
        <?php
            if (!empty($_POST['upload'])) {
                $videoName = str_replace(" ", "_", $_FILES['video']['name']);
                if (!empty($_FILES['thumbnail']['name'])) {
                    $thumbnailName = str_replace(" ", "_", $_FILES['thumbnail']['name']);
                    $query = "INSERT INTO videos (accountid, name, videousername, path, thumbnailpath)
                            VALUES ('" . $_SESSION['id'] . "','" . $_POST['name'] . "',
                            '" . $_SESSION['username'] . "', 'account/" . $_SESSION['id'] . "/videos/" . $videoName . "/". $videoName ."', 
                            'account/".$_SESSION['id']."/videos/".$videoName."/".$thumbnailName."')";
                } else {
                    $query = "INSERT INTO videos (accountid, name, videousername, path, thumbnailpath)
                            VALUES ('" . $_SESSION['id'] . "','" . $_POST['name'] . "',
                            '" . $_SESSION['username'] . "', 'account/" . $_SESSION['id'] . "/videos/" . $videoName . "/". $videoName ."', 
                            'avatar/template.jpg')";
                }
                $dirPath = "account/" . $_SESSION['id'] . "/videos/" . $videoName;
                $videoPath = $dirPath . "/" ;
                mkdir($dirPath);
                if (mysqli_query($sql, $query) && move_uploaded_file($_FILES['video']['tmp_name'], $videoPath . $videoName)) {

                    if (!empty($_FILES['thumbnail']['name'])) {
                        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $videoPath . $thumbnailName)) {
                            echo "<p style='color:green'>Video and thumbnail uploaded!</p>";
                        } else {
                            echo "<p>Cannot upload thumbnail</p>";
                        }
                    } else {
                        echo "<p style='color:green'>Video uploaded!</p>";
                    }
                } else {
                    echo "<p style='color:red'>Cannot upload video</p>";
                }
            }
        ?>
    </div>
</body>
</html>