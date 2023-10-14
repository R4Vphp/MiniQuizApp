<?php
require_once("../classes/Database.class.php");
require_once("../classes/LogInOut.class.php");
require_once("../classes/Notification.class.php");
session_start();
?>
<html>
<head>
<meta charset="UTF-8">
<title>QuickQuizQuest</title>
<link rel="stylesheet" href="../style.css">
<link rel="shortcut icon" href="../images/favicon.svg">
</head>
<body>
<?php
new Notification;
?>
<div class="header">
<a href='../'><img src="../images/logo.png" /></a>
<h1>Przykładowy Quiz</h1>
<h3 class="admin">@ADMIN</h3>
</div>
<form method="post" action="../includes/login.inc.php">
<div class="holder">
<h2>Panel administratorski</h2>
<h4>Logowanie</h4>
<hr />
<input type="password" name="authorization" autocomplete="off" placeholder="Wpisz hasło" autofocus/>
<p class="learn-more">Dostęp do panelu administratorskiego może zostać uzyskany <b>tylko na serwerze</b>.</p>
</div>
<button type="submit">Zaloguj</button>
</form>
<div class="footer">
<p>Wersja <b>2.0</b></p>
<?php LogInOut::loginManifest(); ?>
</div>
</body>
</html>