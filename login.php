<?php
/**
 * Created by PhpStorm.
 * User: berka
 * Date: 5.03.2017
 * Time: 21:25
 */
include("inc/header.php");


$warningTemplate = '<div class="alert alert-danger">
  <strong>Uyarı!</strong> %s
</div>';
$warningText;

//önce login mi olmaya çalışıyoruz buna bakıyor
//sonrasında login olmaya çalışıyor (session atıyor) ve admine atıyor bizi

if (isset($_POST["username"]) && !empty($_POST["username"])) {
    session_start();
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $_POST["password"];
    header("Location: admin.php");
} else {


//TODO  buraya html göm login olmasını iste sessiona ata logout butonu koy
    if (isset($_GET["status"]) && !empty($_GET["status"])) {

        $status = $_GET["status"];
        if (strcmp($_GET["status"], "expired") == 0) {
            $warningText = "Lisans süreniz dolmuş!";
        } elseif (strcmp($_GET["status"], "userNotFound") == 0) {
            //TODO sistemde kaydınız bulunamadı
        } elseif (strcmp($_GET["status"], "logout") == 0) {

            $warningTemplate = '<div class="alert alert-info">
                                  <strong>Bilgi!</strong> %s
                                </div>';
            $warningText = "Başarıyla çıkış yapıldı!";
        } elseif (strcmp($_GET["status"], "noLogin") == 0) {
            $warningText = "Kullanıcı girişi yapılmadı!";

        }
    }
    ?>
    <!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <html>
    <head>
        <title>Login</title>
        <!--<script src="src/login.js"></script>-->
        <link rel="stylesheet" href="template/src/login.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">

    </head>
    <body>
    <div id="fullscreen_bg" class="fullscreen_bg"/>

    <div class="container">

        <form class="form-signin" method="post" action="login.php">

            <h1 class="form-signin-heading text-muted">Sign In</h1>
            <?php
            if (isset($warningText) && !is_null($warningText)) {
                echo sprintf($warningTemplate, $warningText);
            }
            ?>
            <input type="text" name="username" class="form-control" placeholder="Instagram Username" required=""
                   autofocus="">
            <input type="password" name="password" class="form-control" placeholder="Password" required="">
            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Sign In
            </button>
        </form>

    </div>
    </body>
    </html>

    <?php


}


?>