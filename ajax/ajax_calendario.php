<?php

include "../db_pass.php";
$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);

$classe = $_GET['classe'];

$query = "SELECT DISTINCT Data_ora, Materia, Argomento, Ore_effettuate, CONCAT(Nome, ' ', Cognome) as Prof
          FROM Lezione
          join Classe on Codice = Classe
          join Utente on id_professore=n_matricola
          WHERE Classe = :classe";
$statement = $db->prepare($query);
$statement->bindParam(":classe", $classe, PDO::PARAM_STR);
$statement->execute();
$lezioni = null;
foreach ($statement as $value) {
  $lezioni[$value[0]] = array(
    'Durata' => $value[3],
    'Materia' => $value[1],
    'Professore' => $value[4],
    'Argomento' => $value[2]
  );
}

$today = getdate();
$today_column = $today['wday'];
//cambiando giorno cambia la settimana e il Calendario
//togliere il commento per vedere che il calendario è dinamico
//$today['mday'] = 18;
for ($i=1; $i < 8; $i++) {
  $week[$i] = $today['mday']-$today_column+$i;
}


$calendario = null;
for ($i=0; $i < 6; $i++) {
  for ($j=0; $j < 7; $j++) {
    $calendario[$i][$j] = '  ';
  }
}
for ($j=0; $j < 6; $j++) {
  $calendario[$j][0] = $j+8;
}

foreach ($lezioni as $key => $value) {
  $temp = $key;
  $key = explode(' ', $key);
  $data = explode('-',substr($key[0], 5, 9));
  $ora = substr($key[1], 0, 2);
  if ($today['mon']==$data[0]) {
    for ($i=1; $i < 8; $i++) {
      if ($data[1] == $week[$i]) {
        $calendario[$ora-7][$i] = "<div id='lezione'>Lezione di ".$value['Materia']."<br />del prof ".$value['Professore']
                                  ."<br />"."durata ".$value['Durata']." ore<br /> "."argomento: ".$value['Argomento'].'</div>';
      }
    }
  }
}

echo "Mese: " . $today['month'];
echo "<table border=1><tr><th>Ore</th><th>Lun ".$week[1]."</th><th>Mar ".$week[2]."</th><th>Mer ".$week[3].
      "</th><th>Gio ".$week[4]."</th><th>Ven ".$week[5]."</th><th>Sab ".$week[6]."</th></tr>";
foreach ($calendario as $value) {

  echo "<tr>";
  foreach ($value as $record) {
    echo "<td>$record</td>";
  }
  echo "</tr>";
}
echo "</table>";

?>
