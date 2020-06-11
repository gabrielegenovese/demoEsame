<?php
include "../db_pass.php";
$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);

//se non si è professori non si può accedere a questa pagina
if (!isset($_COOKIE['professore'])) {
  header("Location:../index.php");
}

//script per eliminare una lezione
if (isset($_POST['n_lezione'])) {
  $statement = $db->prepare("DELETE FROM Lezione WHERE Data_ora = :data_ora");
  $statement->bindParam(":data_ora", $_POST['n_lezione'], PDO::PARAM_STR);
  $is_done = $statement->execute();
  $is_done = $is_done ? 'Lezione eliminata con successo' : 'Errore: qualcosa è andato storto. Data: '. $input_date;
  echo "<script> alert('$is_done'); </script>";
}
?>

<html>
  <head>
    <title>Elimina lezione</title>
  </head>

  <body>

    <?php
    echo "<h1>Le tue lezioni programmate</h1>";
    $prof = $_COOKIE['user_id'];
    $statement = $db->prepare("SELECT * FROM Lezione WHERE id_professore = :prof");
    $statement->bindParam(":prof", $prof, PDO::PARAM_STR);
    $statement->execute();
    $data_lezione = array();
    $count = 1;
    echo "<table border=1><tr><th>Numero</th><th>Data ora</th><th>Materia</th><th>Argomento</th><th>Ore</th><th>Alunni Presenti</th><th>Classe</th></tr>";
    foreach ($statement as $record) {
      echo "<tr><td>$count</td><td>$record[0]</td><td>$record[2]</td><td>$record[3]</td><td>$record[4]</td><td>$record[5]</td><td>$record[6]</td></tr>";
      $data_lezione[$count] = $record[0];
      $count += 1;
    }
    echo "</table>";
    ?>
    <h1>Elimina una lezione</h1>
    <form method="post" action="./elim_lezione.php">
      Lezione da eliminare:
      <select name='n_lezione'>
        <?php
          for ($i= 1; $i < $count; $i++) {
            echo "<option value='$data_lezione[$i]'>$i</option>";
          }
        ?>
      </select><br /><br />
      <input type="submit" />
    </form>

    <a href="../index.php">Torna indietro</a>

  </body>
</html>
