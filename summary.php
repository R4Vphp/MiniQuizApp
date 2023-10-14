<?php

require_once("classes/Database.class.php");
require_once("classes/QuizSession.class.php");
require_once("classes/Question.class.php");
require_once("classes/Answer.class.php");
require_once("classes/Guest.class.php");
require_once("classes/Ranking.class.php");
require_once("classes/Notification.class.php");
require_once("classes/LogInOut.class.php");
session_start();

$session = $_SESSION["QuizSession"] ?? false;
if(!$session OR $session->getState() === QuizSession::STATE_ACTIVE){
	header("Location: index.php");
	exit();
}
$guest = $session->getGuest();
$ranking = new Ranking;

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
<form method="post" action="includes/reset.inc.php">
<div class="holder">
<h2>UKOŃCZONO</h2>
<h4>Twój wynik to:</h4>
<hr />
<h2><span><?= $session->getGuestScore(); ?></span>/<?= $session->getMaxScore(); ?></h2>
<div class="grade"><?= $session->getGrade(); ?></div>
<h4>Czas: <?= $session->getSessionLenght(); ?></h4>
</div>
<?php

if(!$session->isPerfectScore()){

?>

<div class='holder questionReview'><h2>Podgląd</h2><h4>Błędne odpowiedzi:</h4><hr />

<?php

$session->printQuestions();

?>

</div>

<?php

}

?>

<div class="holder">
<h2>Ranking</h2>
<h4>Najwyższe wyniki:</h4>
<hr />
<?php
$ranking->loadTop10();
?>
<br /><p class="learn-more">Aby odświeżyć ranking kliknij <b>F5</b>.</p>
</div>
<button type="submit" name="quizFinish">Wróć</button>
</form>
<div class="footer">
<p>Wersja <b>2.0</b></p>
<?php LogInOut::loginManifest(); ?>
</div>
</body>
</html>