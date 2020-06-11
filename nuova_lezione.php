<?php
include "db_pass.php";
$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
//se non si è professori non si può accedere a questa pagina
if (!isset($_COOKIE['professore'])) {
  header("Location:index.php");
}

$prof = $_COOKIE['user_id'];

if (isset($_POST['data_ora']) and isset($_POST['materia']) and isset($_POST['ore']) and isset($_POST['argomento'])) {

  $input_date = $_POST['data_ora'];
  $data_ora = date("Y-m-d H:i:s",strtotime($input_date));

  $input_materia = explode(' in ', $_POST['materia']);
  $materia = $input_materia[0];
  $classe = $input_materia[1];
  $argomento = $_POST['argomento'];
  $ore = $_POST['ore'];
  $statement = $db->prepare("INSERT INTO `Lezione` (`Data_ora`, `id_professore`, `Materia`, `Argomento`, `Ore_effettuate`, `Alunni_presenti`, `Classe`)
                              VALUES (:data, :prof, :materia, :argomento, :ore, NULL, :classe);");
  $statement->bindParam(":data", $data_ora, PDO::PARAM_STR);
  $statement->bindParam(":prof", $prof, PDO::PARAM_STR);
  $statement->bindParam(":materia", $materia, PDO::PARAM_STR);
  $statement->bindParam(":argomento", $argomento, PDO::PARAM_STR);
  $statement->bindParam(":ore", $ore, PDO::PARAM_INT);
  $statement->bindParam(":classe", $classe, PDO::PARAM_STR);
  $is_done = $statement->execute();
  $is_done = $is_done ? 'Lezione inserita con successo' : 'Errore: inserire tutti i campi e controllare che non ci siano altre lezioni in data ' . $input_date;
  echo "<script> alert('$is_done'); </script>";
}else {
  echo "<script> alert('Inserire tutti i campi'); </script>";
}
?>
<html>
  <head>
    <title>Nuova lezione</title>
    <script src="http://code.jquery.com/jquery-1.5.js"></script>
    <script>
      function countChar(val) {
        var len = val.value.length;
        if (len >= 200) {
          val.value = val.value.substring(0, 200);
        } else {
          $('#charNum').text(200 - len);
        }
      };
    </script>
  </head>

  <body>

  <h1>Nuova lezione</h1>

  <form method="post" action="./nuova_lezione.php">

    Data e ora <input type="datetime-local" name="data_ora" /><br /><br />

    Materia e classe
    <?php
    $statement = $db->prepare("SELECT Materia, Classe FROM Insegnante WHERE id_professore=:prof");
    $statement->bindParam(":prof", $prof, PDO::PARAM_STR);
    $statement->execute();
    echo "<select name='materia'>";
    foreach ($statement as $record) {
      echo "<option>". $record[0] ." in ". $record[1] ."</option>";
    }
    echo "</select>";
    ?>

    <br /><br />

    Ore programmate
    <select name="ore">
      <option>1</option>
      <option>2</option>
      <option>3</option>
    </select>

    <br /><br />

    <textarea name="argomento" style="width:200px; height:200px; resize:none;"onkeyup="countChar(this)" maxlength="200" placeholder="Argomento (max 200 caratteri)"></textarea><br />
    <div style="display:inline;" id="charNum">200</div> caratteri rimanenti<br /><br />

    <input type="submit" />
  </form>

  <a href="index.php">Torna indietro</a>

  </body>
</html>
