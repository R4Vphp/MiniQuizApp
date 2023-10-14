<?php
require_once("classes/Database.class.php");
require_once("classes/Notification.class.php");
require_once("classes/LogInOut.class.php");
session_start();
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
<h3>Powodzenia!</h3>
</div>
<form method="post" action="includes/start.inc.php">
<div class="holder">
<h2>Rozpocznij Quiz</h2>
<h4>Wpisz swój nick</h4>
<hr />
<input type="text" name="nickname" autocomplete="off" autofocus/>
<p class="learn-more">Nick może zawierać tylko litery <b>(bez znaków specjalnych)</b>, cyfry i podkreślenie.</p>
</div>
<button type="submit" name="quizStart">Start</button>
</form>
<div class="footer">
<p>Wersja <b>2.0</b></p>
<?php LogInOut::loginManifest(); ?>
</div>
<?php
new Notification;
?>
</body>
</html>