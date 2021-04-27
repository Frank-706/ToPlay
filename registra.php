<!DOCTYPE html>
<html>
<title>TO PLAY: LOGIN/REGISTRAZIONE</title>
<head>
        
        <style>
            body {
           background-color: #99deff;
           padding:10px;
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
<body onload="document.getElementById('nome').focus();">
<h1>Registrazione</h1>
<?php
include "config.php";
//var_dump($_SERVER);
// connessione al DB
$CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-paswd"], $CONFIG["db-name"]);
if ($CN->connect_error)
	die("Connection failed: " . $CN->connect_error);

if ($_GET["azione"] == "insert") {
	// trattamento dei dati ricevuti da GET: var_dump($_GET) se interessa indagare
	$nome=$_GET['nome'];
    $cognome=$_GET['cognome'];
    $email=$_GET['email'];
    $pwd=$_GET['pwd'];
    $cf=$_GET['cf'];
    $numero = md5(rand(1,100));
	// verifica se l'email è vuota
	$sql = "SELECT COUNT(*) AS registrato FROM tp_utenti WHERE email='$email'";
	$RS = $CN->query($sql); 	// esecuzione della query di insert sul DB
	$row = $RS-> fetch_assoc();	// da $RS estraggo una riga
    if ($row["registrato"]>=1) {			// testo il campo "registrato" della riga
    	$msg = "Questa email: '$email' già esiste! ";
    }
    else if ($email == "") {
    	$msg = "Email non specificata, inserire email...";
    }
    else {
      $sql = "INSERT INTO tp_utenti(pk,
                         nome,
                        cognome,
                        email,
                        `password`,
                        cf,
                        is_enabled,
                        registrazione
                      ) VALUES (
                          null,
                          '$nome',
                          '$cognome',
                          '$email',
                          md5('$pwd'),
                          UPPER('$cf'),
                          0,
                          '$numero'
                      )";
// ciao password
      $CN->multi_query($sql); // esecuzione della query di insert sul DB
      $msg = "inserimento dell'utente '$nome' avvenuto con successo";
      $nome_mittente = "Francesco Fulvio Di Nisio";
$mail_mittente = "francescofulvio.dinisio@italessandrini.edu.it";
$mail_destinatario = $email;

// definisco il subject ed il body della mail
$mail_oggetto = "Conferma registrazione";
$mail_corpo = "Per attivare l'account clicca sul link:\n http://". $_SERVER["SERVER_NAME"]. "/wapp/toplay/confirm.php?n_casuale=$numero";

// aggiusto un po' le intestazioni della mail
// E' in questa sezione che deve essere definito il mittente (From)
// ed altri eventuali valori come Cc, Bcc, ReplyTo e X-Mailer
$mail_headers = "From: " .  $nome_mittente . " <" .  $mail_mittente . ">\r\n";
$mail_headers .= "Reply-To: " .  $mail_mittente . "\r\n";
$mail_headers .= "X-Mailer: PHP/" . phpversion();

mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers);
    }
}
?>
  <form method="GET" action="">
    <input type='hidden' 	name='azione' id='azione' value='insert'>
     <fieldset>
    <legend>Registrazione:</legend>
    Nome: <input type='text' name='nome' id='nome' placeholder='inserire il nome...'> <br>
    Cognome: <input type='text' name='cognome' id='cognome' placeholder='inserire il cognome...'> <br>
    Email: <input type='email' name='email' id='email' placeholder='inserire una email...'> <br>
    Password: <input type="password" id="pwd" name="pwd" placeholder="password"><br>
    Codice Fiscale: <input type="text" id="cfs" name="cf" placeholder="carta..."><br>
    <input type='submit' value='Registrati'> o accedi <a href="http://frankmoses.altervista.org/wapp/toplay/index.php">qui</a>!
    </fieldset>
  </form>
<?php
echo $msg;
$CN->close();
?>
</body>
</html>