<link rel="stylesheet" href="header.css">
<header>
    <a href="http://localhost/joetoep2.0"><h1>Joetoep</h1></a>
    <nav>
        <?php
        session_start();
        $sql = new mysqli("localhost","root","","joetoep");

        if (!empty($_SESSION['id'])) {
            echo "<p>Hello, " . $_SESSION['username'] . "</p> 
                  <a href='http://localhost/joetoep2.0/account/".$_SESSION['id']."'><button>My account</button></a>
                  <a href='http://localhost/joetoep2.0/upload.php'><button>Upload</button></a>
                  <a href='http://localhost/joetoep2.0/logout.php'><button>Logout</button></a>";
        } else {
            echo "<button onclick='loginVisible()'>Log in</button>
                      <button onclick='registerVisible()'>Register</button>";
        }
        ?>
        <div id="searchbar">
            <form method="GET" action="http://localhost/joetoep2.0/index.php/search.php">
                <input type="text" autocomplete="off" name="search" id="searchbarInput" placeholder="Type to search...">
                <input type="submit" id="searchbarSubmit" value="Search">
            </form>
        </div>
    </nav>

</header>
<?php
    if (isset($_SESSION['login'])) {
        echo $_SESSION['login'];
    }
?>
<div id="loginContainer">
    <div class="login">
        <button onclick="closeLogin()" class="close">X</button>
        <h3>Login</h3>
        <form method="POST" action="login.php">
            <label for="email">E-mail: </label><input id="email" type="email" name="email"><br>
            <label for="password">Password: </label><input id="password" type="password" name="password"><br>
            <input class="submit" type="submit" name="submitLogin" value="Login">
        </form>
    </div>
</div>

<div id="registerContainer">
    <div class="register">
        <button onclick="closeRegister()" class="close">X</button>
        <h3>Register</h3>
        <form method="POST" enctype="multipart/form-data" action="index.php">
            <label for="usernameRegister">Username: </label><input id="username" type="text" name="username"><br>
            <label for="emailRegister">Email: </label><input id="emailRegister" type="email" name="email"><br>
            <label for="passwordRegister">Password: </label><input id="passwordRegister" type="password" name="password"><br>
            <label for="repeatPassword">Repeat password: </label><input id="repeatPassword" type="password" name="repeatPassword"><br>
            <label for="avatar">Avatar: </label><input type="file" name='avatar' id="avatar" accept=image/*>
            <input class="submit" type="submit" name="submitRegister" value="Register">
        </form>
        <?php
        if (!empty($_POST['submitRegister'])) {
            if ($_POST['password'] === $_POST['repeatPassword']) {
                $query = "SELECT * FROM accounts WHERE email='".$_POST['email']."' OR username='".$_POST['username']."'";
                if (empty(mysqli_fetch_assoc(mysqli_query($sql, $query)))) {
                    $query = "INSERT INTO accounts (email, username, password) 
                                    VALUES ('".$_POST['email']."', '".$_POST['username']."', '".$_POST['password']."')";
                    if (mysqli_query($sql, $query)) {
                        $query = "SELECT * FROM accounts WHERE username='".$_POST['username']."' AND password='".$_POST['password']."'";
                        $query = mysqli_query($sql, $query);
                        if ($query) {
                            $data = mysqli_fetch_assoc($query);
                            $_SESSION['id'] = $data['id'];
                            $_SESSION['email'] = $data['email'];
                            $_SESSION['username'] = $data['username'];

                            $dirPath = "account/" . $data['id'];
                            $dirPathVideos = $dirPath . "/videos";
                            mkdir($dirPath);
                            mkdir($dirPathVideos);
                            $dollarsign = "$";
                            $filewrite = "<!DOCTYPE html>
                                    <html lang='en'>
                                    <head>
                                        <meta charset='UTF-8'>
                                        <title>".$data['username']."'s profile</title>
                                        <link rel='stylesheet' href='../../account.css'>
                                    </head>
                                    <body>
                                    <link rel='stylesheet' href='../../header.css'>
                                    <?php include('../../header.php') ?>
                                    <div class='border'></div>
                                    <div class='container'>
                                        <div class='container2'>
                                            <div class='header'>
                                                <div class='avatarContainer'>
                                                    <img src='".$_FILES['avatar']['name']."'>
                                                </div>
                                                <h3>".$data['username']."</h3>
                                            </div>
                                            <div>
                                                <h3 class='videosText'>Videos</h3>
                                                <div class='videos'>
                                                    <?php 
                                                    ".$dollarsign."query = 'SELECT * FROM videos WHERE accountid = ".$data['id']."';
                                                    include('../../video.php'); 
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </body>
                                    </html>";
                            $filename = "account/" . $data['id'] . "/index.php";
                            $fileopen = fopen($filename, "w");
                            fwrite($fileopen, $filewrite);
                            fclose($fileopen);


                            if (!empty($_FILES['avatar']['name'])) {
                                $query = "UPDATE accounts SET avatarpath = '".$_FILES['avatar']['name']."' WHERE id=".$data['id'];
                            } else {
                                $query = "UPDATE accounts SET avatarpath = '../../avatar/defaultavatar.jpg' WHERE id=".$data['id'];
                            }

                            $avatarpath = "account/" . $data['id'];
                            if (mysqli_query($sql, $query)) {

                                if (!empty($_FILES['avatar']['name'])) {
                                    $destination = "account/".$data['id']."/".$_FILES['avatar']['name'];
                                    $moveFile = $_FILES['avatar']['name'];
                                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $moveFile)) {
                                        if (rename($moveFile, $destination)) {
                                            $_SESSION['login'] = "<p style='color:green'>Account created!</p>";
                                        } else {
                                            $_SESSION['login'] = "False";
                                        }
                                    } else {
                                        $_SESSION['login'] = "False";
                                    }
                                }

                            } else {

                                $_SESSION['login'] = "Error: could not upload avatar " . mysqli_error($sql);
                                echo mysqli_error($sql);

                            }
                        } else {
                            echo("Error description: " . mysqli_error($sql));
                        }
                    } else {
                        echo("Error description: " . mysqli_error($sql));
                    }
                } else {
                    $_SESSION['login'] = "<p style='color:red'>E-mail or username is already registered</p>";
                }
            } else {
                echo "<p style='color:red'>Passwords do not match</p>";
            }
        }
        ?>
    </div>
</div>
<script src="header.js"></script>