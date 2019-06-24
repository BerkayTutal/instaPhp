<?php
ini_set('max_execution_time', 36000);
//increase Allowed Memory Size of this script:
ini_set('memory_limit','960M');
/**
 * Created by PhpStorm.
 * User: berka
 * Date: 4.03.2017
 * Time: 15:06
 */
session_start();
//ob_start();
include 'vendor/autoload.php';
require 'vendor/mgp25/instagram-php/src/Instagram.php';
include('functions.php');
include('connect.php');
$status;


set_time_limit(0);

$pageDebug = false;

if (isset($_GET["debug"])) {
    $pageDebug = true;
}


//login.phpde ise ve logout diye geldiyse ekrana basabilmek için logout değişkeni atar ve aynı zamanda session destroy eder
if (isset($_GET["logout"]) && strcmp(basename($_SERVER['PHP_SELF']), "login.php") == 0) {
//    echo "session aboow";
    destroySession();
    header("Location: login.php?status=logout");

}
//sessionda username falan var mı bakar
//yoksa login sayfasına atıp noLogin gönderir
if ((isset($_SESSION['username']) && !empty($_SESSION['username'])) || (isset($_GET['username']) && !empty($_GET['username']))) {
    $username;
    $password;
    if (isset($_GET['username']) && !empty($_GET['username'])) {
        connectDB();
        $usernamePassword = getUserNamePassword($_GET['username']);
        disconnectDB();
        $username = $usernamePassword['username'];
        $password = $usernamePassword['password'];
        echo "databaseden aldık";
    } else {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }

    // TODO: buraya database suer set değilse süreniz bitmiş yazısı gelsin

    $forceLogin = false;
    $debug = false;


//////////////////////

    connectDB();
    //user valid mi kontrol eder yoksa login sayfasına atar
    if (isUserValid($username, $password)) {

        //login sayfasındayız ve user valid falan yapmışız direkt admin.php
        if (strcmp(basename($_SERVER['PHP_SELF']), "login.php") == 0) {


            header("Location:admin.php");
        }

    } else {
        $yonlendir = true;
        if (isset($_GET["status"]) && !is_null($_GET["status"])) {
            if (strcmp($_GET["status"], "expired") == 0) {
                $yonlendir = false;
            }
        }
        $status = "expired";
        if ($yonlendir) {
            header("Location: login.php?status=" . $status);

        }
    }
    disconnectDB();
////
//    $location = [];
//    $location["locID"] = 15654;
//    $location["locName"] = "hakkı";
//    $location["locAddress"] = "bulut";
//    $location["locCount"] = 5;
//
//
//insertLocation($username,65498,"berkay","domaniç",25);
//
//getAllLocations($username);
//
//
//deleteLocation($username,123546);


} elseif (strcmp(basename($_SERVER['PHP_SELF']), "login.php") != 0) {

    //TODO burası giriş yapılmamış demesi için
    $status = "noLogin";
//    $_GET["status"] = "noLogin";
//    include("login.php");
//    error_reporting(E_ALL);
    header("Location: login.php?status=" . $status);
//    die();

}


?>