<?php

if ($_GET['q'] == 'logout') {
  setcookie("user_id", '', time()-1);
  setcookie("professore", '', time()-1);
  header("Location:login.php");
}elseif (isset($_COOKIE['user_id'])) {
?>

<html>

<head>
  <title>Calendario</title>
</head>

<body>


<?php //tabella calendario

?>


<?php //bottoni per professore
if (isset($_COOKIE['professore'])) {
?>

<button onclick="window.open('dati.php', '_self');">Statistiche lezioni</button>
<button onclick="window.open('nuova_lezione.php', '_self');">Nuova lezione</button>
<button onclick="window.open('elim_lezione.php', '_self');">Elimina lezione</button><br /><br />

<?php } ?>

<a href="index.php?q=logout">Logout</a>

<?php
}else {
  header("Location:login.php");
}
?>

</body>

</html>
