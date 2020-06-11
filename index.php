<?php
  include "db_pass.php";
  $db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
  $user = $_COOKIE['user_id'];
  if ($_GET['q'] == 'logout') {
    setcookie("user_id", '', time()-1);
    setcookie("professore", '', time()-1);
    header("Location:login.php");
  }elseif (isset($_COOKIE['user_id'])) {
    $user = $_COOKIE['user_id'];
?>

<html>

  <head>
    <title>Calendario</title>
    <script src="http://code.jquery.com/jquery-1.5.js"></script>
    <script src="./script.js" type="text/javascript"></script>
  </head>

  <body>

    <?php //bottoni per professore
    if (isset($_COOKIE['professore'])) {
    ?>

    <button onclick="window.open('dati.php', '_self');">Statistiche lezioni</button>
    <button onclick="window.open('nuova_lezione.php', '_self');">Nuova lezione</button>
    <button onclick="window.open('elim_lezione.php', '_self');">Elimina lezione</button>

  <?php
    } else {
      //tabella calendario studente
      echo "<h1>Calendario di questa settimana</h1>";
      echo "Per entrare nella videolezione clicca sulla casella<br /><br />";
      $statement = $db->prepare("SELECT Codice
                                 FROM Classe
                                 WHERE id_studente=:stud");
      $statement->bindParam(":stud", $user, PDO::PARAM_STR);
      $statement->execute();
      foreach ($statement as $value) {
        $classe = $value[0];
      }

      $query = "SELECT DISTINCT Data_ora, Materia, Argomento, Ore_effettuate, CONCAT(Nome, ' ', Cognome) as Prof
                FROM Lezione
                join Classe on Codice = Classe
                join Utente on id_professore=n_matricola
                WHERE Classe = :classe_studente";
      $statement = $db->prepare($query);
      $statement->bindParam(":classe_studente", $classe, PDO::PARAM_STR);
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
    }?>

    <br /><br />
    <a href="index.php?q=logout">Logout</a>

    <?php
    }else {
      header("Location:login.php");
    }
    ?>

  </body>

</html>
