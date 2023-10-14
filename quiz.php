<?php

require_once("classes/Database.class.php");
require_once("classes/QuizSession.class.php");
require_once("classes/Question.class.php");
require_once("classes/Answer.class.php");
require_once("classes/Guest.class.php");
require_once("classes/Notification.class.php");
require_once("classes/LogInOut.class.php");
session_start();

$session = $_SESSION["QuizSession"] ?? false;
if(!$session OR $session->getState() !== QuizSession::STATE_ACTIVE){
	header("Location: index.php");
	exit();
}
$guest = $session->getGuest();

?>
<html>
<head>
<meta charset="UTF-8">
<title>QuickQuizQuest</title>
<link rel="stylesheet" href="style.css">
<link rel="shortcut icon" href="images/favicon.svg">
</head>
<body>
<div class="header">
<a href='./'><img src="images/logo.png" /></a>
<h1>Przykładowy Quiz</h1>
<h3 info="<?= $guest->getId()."/".$session->getIp(); ?>">
<img src="images/guest.svg" width="20px" />
<?= $guest->getNickname(); ?>
</h3>
</div>
<form method="post" action="includes/finish.inc.php">
<?php
$session->printQuestions();
?>
<button type="submit" name="FINISH" value="true">Sprawdź</button>
</form>
<div class="footer">
<p>Wersja <b>2.0</b></p>
<?php LogInOut::loginManifest(); ?>
</div>
</body>
</html>