<?php
echo "<h1>Dati statistiche</h1>";

include "../db_pass.php";
$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);

$prof = $_COOKIE['user_id'];
$classe = $_GET['classe'];
$materia = $_GET['materia'];

//array associativo degli alunni in una classe con collegate il numero lezioni che ha svolto
$classe_stud = array();
$query = "SELECT n_matricola, Nome, Cognome
          FROM Classe
          join Utente on id_studente=n_matricola
          WHERE Codice=:classe";
$statement = $db->prepare($query);
$statement->bindParam(":classe", $classe, PDO::PARAM_STR);
$statement->execute();

foreach ($statement as $record){
	$classe_stud[$record[0]]["nome"] = $record[1] . " ". $record[2];
}


$query = "SELECT Ore_effettuate, Alunni_presenti
          FROM Lezione
          WHERE id_professore =:prof AND Classe=:classe AND Materia=:materia AND Alunni_presenti IS NOT NULL";
$statement = $db->prepare($query);
$statement->bindParam(":prof", $prof, PDO::PARAM_STR);
$statement->bindParam(":materia", $materia, PDO::PARAM_STR);
$statement->bindParam(":classe", $classe, PDO::PARAM_STR);
$statement->execute();

//Numero delle lezioni
$n_lezioni = $statement->rowCount();
echo "Numero lezioni = $n_lezioni<br />";
$ore_tot_lezioni = 0;
$totale_presenze = 0;

foreach ($statement as $record){
	$ore_tot_lezioni += $record[0];
	$alunni_presenti = explode(",", $record[1]);
	foreach ($alunni_presenti as $temp){
		$classe_stud[$temp][$materia] += 1;
		$totale_presenze += 1;
	}
}

echo "Ore totali di lezione = $ore_tot_lezioni<br />";
echo "Totale presenze = $totale_presenze<br />";

$media_lezione = $totale_presenze / $n_lezioni;
echo "<br />Media presenze per lezione = $media_lezione<br />";

$media_ore = $totale_alunni / $ore_tot_lezioni;
echo "Media presenze per ora = $media_ore<br />";

echo "<br />Numero di assenze fatte da ogni studente della classe $classe per la materia $materia<br />";
foreach ($classe_stud as $studente){
	$studente['assenze'] = $n_lezioni - $studente[$materia];
  echo $studente['nome']." = ".$studente['assenze']."<br />";
}
