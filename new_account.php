<html>

<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="login-page">
    <div class="form">
      <form method="post" action="./new_account.php" class="login-form">
        <input type="text" name="nome" placeholder="Nome" required/>
        <input type="text" name="cognome" placeholder="Cognome" required/>
        <input type="date" name="data_nascita" placeholder="Data di nascita" required/>
        Genere: <select name="genere" required>
          <option value="M">Maschio</option>
          <option value="F">Femmina</option>
          <option value="other">Altro</option>
        </select>
        <input type="text" name="device" placeholder="MAC del device" required/>
        <input type="text" name="username" placeholder="username" required/>
        <input type="password" name="password" placeholder="password" required/>
        <input type="submit" />
      </form>
    </div>
  </div>

</body>

<?php

include "db_pass.php";
$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);

if (isset($_POST['nome']) and isset($_POST['cognome'])) {
  $nome = $_POST['nome'];
  $cognome = $_POST['cognome'];
  $genere = $_POST['genere'];
  $data_nascita = $_POST['data_nascita'];
  $id_device = $_POST['id_device'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $statement = $db->prepare("INSERT INTO Utenti(Nome,Cognome,Genere,Data_Nascita,Professore,id_device,username,password)
                              VALUES (:nome,:cognome,:genere,:data_nascita,0,:id_device,:username,:password);");
  $statement->bindParam(":nome", $nome, PDO::PARAM_STR);
  $statement->bindParam(":cognome", $cognome, PDO::PARAM_STR);
  $statement->bindParam(":genere", $user, PDO::PARAM_STR);
  $statement->bindParam(":data_nascita", $data_nascita, PDO::PARAM_STR);
  $statement->bindParam(":id_device", $id_device, PDO::PARAM_STR);
  $statement->bindParam(":username", $username, PDO::PARAM_STR);
  $statement->bindParam(":password", $password, PDO::PARAM_STR);
  $statement->execute();
}else {
  echo "<script> alert('Errore: inserire tutti i campi');</script>";
}

?>

</html>
