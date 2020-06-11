<?php
include "../db_pass.php";
$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);

//se non si è professori non si può accedere a questa pagina
if (!isset($_COOKIE['professore'])) {
  header("Location:../index.php");
}

$prof = $_COOKIE['user_id'];
?>

<html>
<head>
  <title>Dati lezioni</title>
  <script>
    function update_data(str){
      var selected = str.split(",");
      var classe = selected[1];
      var materia = selected[0];
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("dati").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "../ajax/ajax_dati.php?classe=" + classe + "&materia=" + materia, true);
      xmlhttp.send();
    }
  </script>
</head>
<body>
  <h1>Selezionare materia e classe</h1>
  <select id="classe_materia" onchange="update_data(this.value)">
    <?php
    $statement = $db->prepare("SELECT Materia, Classe FROM Insegnante WHERE id_professore=:prof");
    $statement->bindParam(":prof", $prof, PDO::PARAM_STR);
    $statement->execute();
    echo "<option> - - - - - - </option>";
    foreach ($statement as $record) {
      echo "<option value='$record[0],$record[1]'>". $record[0] ." in ". $record[1] ."</option>";
    }
     ?>
  </select>
  <br /><br />
  <div id="dati"></div>
  <br /><br /><a href="../index.php">Torna indietro</a>
</body>
</html>
