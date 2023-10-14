<?php

require_once("../classes/Database.class.php");
require_once("../classes/LogInOut.class.php");
require_once("../classes/Admin.class.php");
require_once("../classes/Ranking.class.php");
require_once("../classes/Notification.class.php");
session_start();

if(!LogInOut::isLogged()){
    header("Location: authorization.php");
    exit();
}

$admin = new Admin;
$ranking = new Ranking;

?>
<html>
<head>
<meta charset="UTF-8">
<title>QuickQuizQuest</title>
<link rel="stylesheet" href="../style.css">
<link rel="shortcut icon" href="../images/favicon.svg">
<meta http-equiv="refresh" content="10;URL='./'">
</head>
<body>
<div class="header">
<a href='../'><img src="../images/logo.png" /></a>
<h1>Przykładowy Quiz</h1>
<h3 class="admin">@ADMIN</h3>
</div>
<form method="post" action="../includes/admin.inc.php">
<button type="submit" class='admin' name="resetQuiz" value=1>Reset</button>

<div class="holder">
<h2>Sesja</h2>
<h4>Lista uczestników:</h4>
<hr />
<?php
if($ranking->loadGuests() === 0){
?>
<div class="load"></div>
<?php
}
?>
</div>

<div class="holder">
<h2>Ranking</h2>
<h4>Najwyższe wyniki:</h4>
<hr />
<?php
if($ranking->loadRanking() === 0){
?>
<div class="load"></div>
<?php
}
?>
</div>

</form>
<form method="post" action="../includes/logout.inc.php">
<button type="submit" name="logout">Wyloguj</button>
</form>
<div class="footer">
<p>Adres lokalny serwera: <b><?= $x = getHostByName(getHostName()); ?></b></p>
<hr />
<p>Wersja <b>2.0</b></p>
<?php LogInOut::loginManifest(); ?>
</div>
<?php
$ranking->everyoneFinished();
new Notification;
?>
</body>
</html>