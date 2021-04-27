<?php
include "../config.php";
session_start();
?>

<html>
<head>
<title>Login: HEADER</title>
  <meta charset="UTF-8">
  <meta name="keywords" content="toplay, login, admin">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Pagina di login">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style> 
     nav{
          text-align:center;
      }
     /* fieldset{
          background-color: whitesmoke;
          color:black;
      } */
      span{
        color:whitesmoke;
      }
      a{
         color:whitesmoke;
      }
      .testobianco{
         color:whitesmoke;
      }
      .testonero{
         color:black;
      }
  </style>
</head>
     
<body>

<H1 align="center" class="testobianco"> CRUD TOPLAY</H1>
<?php
 $conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pswd"], $CONFIG["db-name"]);
 if ($conn->connect_error)
     die("Connection failed: " . $conn->connect_error);
 if(isset($_SESSION['pkb'])){
    echo "<span>Benvenuto " . $_SESSION['Email']." !</span>"; 
     //var_dump($_SESSION);
?>
   <br>
   <nav>
      <span class="testonero"><a href="http://frankmoses.altervista.org/wapp/toplay/admin/crud_admin.php"><b>ADMIN</b></a> |
      <a href="http://frankmoses.altervista.org/wapp/toplay/admin/crud_utenti.php"><b>UTENTI</b></a> |
      <a href="http://frankmoses.altervista.org/wapp/toplay/admin/crud_articoli.php"><b>ARTICOLI</b></a> |
      <a href="http://frankmoses.altervista.org/wapp/toplay/admin/crud_categorie.php"><b>CATEGORIE</b></a> |
      <a href="http://frankmoses.altervista.org/wapp/toplay/admin/crud_sottocategorie.php"><b>SOTTO CATEGORIE</b></a> |
      <a href="http://frankmoses.altervista.org/wapp/toplay/admin/crud_ordini.php"><b>ORDINI</b></a> </span>
 </nav><br><br>
    <form action="http://frankmoses.altervista.org/wapp/ToPlay/admin/index.php" method="POST">
    <input type="hidden" id="azione2" name="azione2" value="logout">
    <input type="submit"  value="logout"><br>
    </form>
<?php
}
//var_dump($_SESSION); 
if($_SERVER['REQUEST_METHOD'] == "POST" and $_POST["azione2"] == "logout"){
  echo "L'utente non è autorizzato";
  unset($_SESSION["ema"]);
  session_destroy();
}
  $conn->close();
?>
</body>
</html>