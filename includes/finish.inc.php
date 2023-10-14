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

session_start();
$session = $_SESSION["QuizSession"];

if($session->getState() === QuizSession::STATE_ACTIVE){

    $session->prepareSummary();
    $session->finishQuiz();
    
}

header("Location: ../summary.php");