<?php

$page = "main";

if (isset($_GET["page"]) && !empty($_GET["page"])) {
    $page = $_GET["page"];
}

include("template/header.php");
include("template/sidebar.php");


include("template/admin_" . $page . ".php");

include("template/footer.php");
?>