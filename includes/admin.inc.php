<?php

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: ../");
    exit();
}

require_once("../classes/Database.class.php");
require_once("../classes/LogInOut.class.php");
require_once("../classes/Admin.class.php");

session_start();

if(!LogInOut::isLogged()){
    header("Location: ../");
    exit();
}

$controler = new Admin;
$controler->grabInput();
$controler->execute();

header("Location: ../admin");