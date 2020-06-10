<html>

<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="login-page">
    <div class="form">
      <form method="post" action="./login.php" class="login-form">
        <input type="text" name="username" placeholder="username" />
        <input type="password" name="password" placeholder="password" />
        <input type="submit" />
      </form>
    </div>
  </div>

</body>
<?php
include "db_pass.php";
$db = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);

if (isset($_POST["username"]) && isset($_POST["password"])) {
  $user =  $_POST['username'];
  $pass =  $_POST["password"];
  $statement = $db->prepare("SELECT id, id_device, password FROM user WHERE username=:user");
  $statement->bindParam(":user", $user, PDO::PARAM_STR);
  $statement->bindParam(":pass", $pass, PDO::PARAM_STR);
  $statement->execute();
  if ($statement->rowCount() != 0) {
    foreach ($statement as $record) {
      $user_id = $record[0];
      if (password_verify($_POST["password"], $record[2])) {
        setcookie("user_id", $user_id, time()+(60*60*6)); //time out di 6 ore
        //controllo sul device
        if (1==1) { //getIdDevice == record[1]
          echo "<script> alert('Login effettuato correttamente');
                  window.open('./index.php', '_self'); </script>";
        }else {
          echo "<script> alert('Device non registrato'); </script>";
        }

      } else {
        echo "<script> alert('Lo username $user non esiste nel nostro database oppure hai sbagliato la password'); </script>";
      }
    }
  } else {
      echo "<script> alert('Lo username $user non esiste nel nostro database oppure hai sbagliato la password'); </script>";
  }
}

?>
</html>
