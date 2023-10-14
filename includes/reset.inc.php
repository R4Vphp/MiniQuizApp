<?php

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: ../");
    exit();
}



session_start();
if($_SESSION["QuizSession"] ?? false){
    unset($_SESSION["QuizSession"]);
}

header("Location: ../");