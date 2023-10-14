<?php

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: ../");
    exit();
}

require_once("../classes/Database.class.php");
require_once("../classes/LogInOut.class.php");

session_start();

$controler = new LogInOut;

$controler->logoutAdmin();
header("Location: ../admin/authorization.php");