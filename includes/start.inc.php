<?php

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: ../");
    exit();
}

require_once("../classes/Database.class.php");
require_once("../classes/Start.class.php");
require_once("../classes/QuizSession.class.php");
require_once("../classes/Question.class.php");
require_once("../classes/Answer.class.php");
require_once("../classes/Guest.class.php");
require_once("../classes/LogInOut.class.php");

session_start();

$controler = new Start;
$controler->grabInput();
if($controler->handleErrors() === Database::ADMIN_REQUEST){
    
    header("Location: ../admin");

}elseif(!$controler->handleErrors()){

    header("Location: ../");

}elseif($nickname = $controler->handleErrors()){

    session_regenerate_id();
    new QuizSession(
        new Guest($nickname)
    );
    header("Location: ../quiz.php");
}