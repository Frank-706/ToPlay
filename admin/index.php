<?php
/* admin
ciao, trax, bigmike
----
utenti
ciao, hello, casa, cicale, insiemeBello
 */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Login: ADMIN</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="autosalone, login, admin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Pagina di login">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
         body {
           background-color: #99deff;
         } 
         fieldset {
           background-color: #006a9d;
         } 
         legend{
           color: #a400a4;
           background-color: goldenrod;
         } 
        </style>
</head>
<body>
<h1>TO PLAY: Login</h1>
<form method='post' action=''>
<fieldset>
<legend><b>Inserimento dati:</b></legend>
<input type="hidden" id="azione" name="azione" value="login">
<strong>Admin:</strong> <input type="email" id='ema' name="ema" placeholder="email@toplay.com"><br>
<strong>Password:</strong> <input type="password" id='pswd' name="pswd" placeholder="password"><br>
<input type="submit" value="accedi">

<?php
include "../config.php";
  $CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pswd"], $CONFIG["db-name"]);
  if ($CN->connect_error)
      die("Connection failed: " . $CN->connect_error);
      //  sql INJECTION ';1 'OR' 1 '=' 1;'
      // ';delete from u_login;select'
 	 if($_POST["chiusura"] == "logout"){
        echo "Logout effettuato.";
        unset($_SESSION["pkb"]);
        session_destroy();
        $msg="";
      }
   // $RS = $CN->multi_query($sql);
  if ($_POST["azione"] == "login") {		
      $sql="SELECT l.pk as 'pkb', l.is_enabled as 'Abilitato', l.nome as 'Nome', l.email as 'Email' FROM tp_admin l WHERE l.password = '".md5($_POST['pswd'])."' and l.email='".$_POST['ema']."'";
     $RS = $CN->query($sql);
    // echo $sql;
    $row = $RS->fetch_assoc();
      if($RS->num_rows==1 and $row['Abilitato']=1){
         $_SESSION['Abilitato']=$row['Abilitato'];
         $_SESSION['pkb']=$row['pkb'];
         $_SESSION['Email']=$row['Email'];
         $msg = "Benvenuto " . $row['Nome']." !";
         /*header*/ include("header.php");
        // echo $msg.'<br>';
        }
        else{
          $msg ="Accesso negato!";
         }
   }
   //echo $msg.'<br>';
   $CN->close();
?>
</fieldset>
</form>
</body>
</html> 