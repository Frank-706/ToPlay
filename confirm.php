<?php
include "config.php";
//$numero = rand(1,100);
//echo $_GET['n_casuale'];
//session_start();
$CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-paswd"], $CONFIG["db-name"]);
if ($CN->connect_error)
	die("Connection failed: " . $CN->connect_error);
//if(isset($_SESSION['email'])){
    //var_dump($_SESSION);
    $n=$_GET['n_casuale'];
    //$email=$_GET['email'];
  $sql = "update tp_utenti r set r.is_enabled=1 where r.registrazione='$n'";
  //echo $sql;
  $CN->query($sql); // esecuzione della query di insert sul DB
  $msg="Conferma avvenuta con successo";
  //echo $msg.'<br>';     
//}

/*else{
    $msg= 'Nessuna sessione';
}*/
?>
<!DOCTYPE html>
<html>
<title>REGISTRAZIONE : Confirm </title>
<head> 
        <style>
        	body {
            	padding:10px;
            }  
        </style>
</head>
<body>
<h1>Registrazione</h1>
<?php
// connessione al DB
  //echo $_SESSION['email'];
    //echo $sql;
  echo $msg;
  ?>
  <br><a href="http://frankmoses.altervista.org/wapp/toplay/index.php">Torna alla home del catalogo</a>
<?php
    $CN->close();
?>
</body>
</html>