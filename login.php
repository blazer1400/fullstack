<?php
session_start();
$sql = new mysqli("localhost","root","","joetoep");
if (!empty($_POST['submitLogin'])) {
    $query = "SELECT * FROM accounts WHERE email='".$_POST['email']."' AND password='".$_POST['password']."'";
    $output = mysqli_query($sql, $query);
    if ($output) {
        $data = mysqli_fetch_array($output);
        if ($data['email'] === $_POST['email'] && $data['password'] === $_POST['password']) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['login'] = "";
        } else {
            $_SESSION['login'] = "<p style='color:#9b0000;text-align:center;'>E-mail or password incorrect</p>";
        }
    }
}
header("Location: index.php");