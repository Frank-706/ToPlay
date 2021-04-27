<?php
//die("disabled");
session_start();
include "../config.php";
//var_dump($_POST);
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
if(isset($_SESSION['pkb']))
{
?>
<!DOCTYPE html>
<html>
	<title>CRUD: UTENTI</title>
	<head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <style>
        	body {
            	padding:10px;
            }
        	.comando {
            	width:32px;
            	height:32px;
            }
            td img {
            	width:32px;
            	height:32px;
            }
        </style>
        <script>
        /*	function elimina(pk, s) {
            	if (confirm("sei sicuro di voler eliminare l'articolo' " + s + "?")) {
	            	document.getElementById('azione').value = "delete";
	            	document.getElementById('pk').value = pk;
    	        	document.forms["insupddel"].submit();
                }
                return;
            }*/
            
            function setSelectedIndex(s, v) {
              for ( var i = 0; i < s.options.length; i++ )
                if ( s.options[i].value == v ) {
                  s.options[i].selected = true;
                  return;
                }
                return;
            }

			function unSelectIndexes(s) {
              for ( var i = 0; i < s.options.length; i++ )
                  s.options[i].selected = false;
              return;
            }
            
			function aggiorna(pk) {
            	document.getElementById('pk').value			= pk;
            	document.getElementById('azione').value 	= "update";
            	//document.getElementById('nome').value 		= document.getElementById('nome_'+pk).innerHTML;
            	$("#insupddel").show();
                return;
            }
            
            function inserisci() {
				$('#insupddel').toggle();
            	document.getElementById('pk').value			= "";
            	document.getElementById('azione').value 	= "insert";
                if (this.value=='inserisci')
                	this.value='annulla';
                else
                	this.value='inserisci';
				document.getElementById('nome').value 	= "";
                return;
			}
        </script>
</head>
<body>
<h1>CRUD: UTENTI</h1>
<br><a href="http://frankmoses.altervista.org/wapp/toplay/admin/index.php">Home CRUD</a><br>
<?php
if ($_POST["azione"] == "update") {
    $campi = $_POST["campi"];
    $nome = $_POST["nome"];
        //echo $password;
  if($campi=="cognome"){
    $cognome=$_POST['cognome'];
  $sql = "UPDATE tp_utenti SET
                          $campi = '$nome'
                 WHERE pk = ".$_POST["pk"];
                 $conn->query($sql); // esecuzione della query sul DB
  }
  if($campi=="is_enabled"){
    $sql = "UPDATE tp_utenti SET
                           is_enabled = $nome
                   WHERE pk = ".$_POST["pk"];
                   $conn->query($sql); // esecuzione della query sul DB
                   echo $sql;
    }
    if($campi=="password"){ 
        $sql = "UPDATE tp_utenti SET
        `password` = md5('$nome')
    WHERE pk = ".$_POST["pk"];
   $conn->query($sql); // esecuzione della query sul DB
    echo $sql;
      }
    if($campi=="registrazione")
    { 
    $nome = $_POST["nome"];
    $sql = "UPDATE tp_utenti SET
                          registrazione = '$nome'
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
  if($campi=="nome")
  { 
    $nome = $_POST["nome"];
    $sql = "UPDATE tp_utenti SET
                          $campi = '$nome'
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
  if($campi=="email")
  { 
    $sql = "UPDATE tp_utenti SET
                          $campi = '$nome'
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
  if($campi=="cf")
  { 
    $sql = "UPDATE tp_utenti SET
                          $campi = UPPER('$nome')
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
}
if ($_POST["azione2"] == "insert") {
//die("disabled");
	// trattamento dei dati ricevuti da POST: var_dump($_POST) se interessa indagare
  $password=md5($_POST['pass']);
  $abilitato=$_POST['abilitato'];
  $email=$_POST['ema'];
  $cognome=$_POST['cognome'];
  $nome = $_POST["nome"];
  $cf=$_POST["cf"];
  $sql = "SELECT COUNT(*) AS n FROM tp_utenti WHERE email='$email'";
	$RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
	$row = $RS->fetch_assoc();	// da $RS estraggo una riga
    if ($row["n"]>=1) {			// testo il campo "n" della riga
    	$msg = "L'email '$email' esistente, impossibile inserire";
        echo $msg."<br>";
    }
    else if ($email == "") {
    	$msg = "Email non specificato, impossibile inserire";
        echo $msg."<br>";
    }
    else
    $pasw='password';
    $sql = "INSERT INTO tp_utenti (
                          pk,
                          nome,
						  cognome,
                          is_enabled,
                          email,
                          cf,
                          `password`,
                          registrazione
                      ) VALUES (
                             null,
                          '$nome',
                          '$cognome',
                           0,
                          '$email',
                          UPPER('$cf'),
                          '$password',
                          null
                      )";
    $conn->query($sql); // esecuzione della query di insert sul DB
    //echo $sql;  
}
/*if ($_POST["azione"] == "delete") {
	$sql = "DELETE FROM tp_articoli WHERE pk = " . $_POST["pk"];
	$conn->query($sql);
    if (file_exists("../img/upload/articolo_".$_POST["pk"].".png"))
    	unlink("../img/upload/articolo_".$_POST["pk"].".png");
}*/

$sql = "
		SELECT  a.nome as 'Nome',a.cognome as 'Cognome',a.pk as 'pk',  a.is_enabled as 'Abilitato', a.email as 'Email', a.password AS 'Password', a.cf as 'Codice Fiscale',a.registrazione as 'Registrazione'
		FROM 	tp_utenti a
        order by a.nome ASC
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>
	<table border='1'>
      <tr>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Abilitato</th>
        <th>Email</th>
        <th>Password</th>
        <th>Codice Fiscale</th>>
        <th>Registrazione</th>
        <th>comandi</th>
      </tr>
<?php
	while($row = $result->fetch_assoc()) {
?>
		<tr>
          <td	id	= 'nome_<?php echo $row["pk"]; ?>' 
          		name= 'nome_<?php echo $row["pk"]; ?>'><?php echo $row["Nome"]; ?></td>
          <td	id	= 'cognome_<?php echo $row["pk"]; ?>' 
          		name= 'cognome_<?php echo $row["pk"]; ?>'><?php echo $row["Cognome"]; ?></td>
           <td align="center"	id	= 'abilitato_<?php echo $row["pk"]; ?>' 
          		name= 'abilitato_<?php echo $row["pk"]; ?>'><?php echo $row["Abilitato"]; ?></td>
          <td	id	= 'email_<?php echo $row["pk"]; ?>' 
                name= 'email_<?php echo $row["pk"]; ?>'><?php echo $row["Email"]; ?></td>
          <td id= 'password_<?php echo $row["pk"]; ?>' 
                name= 'password_<?php echo $row["pk"]; ?>'><?php echo $row["Password"]; ?></td>
                <td	id	= 'cf_<?php echo $row["pk"]; ?>' 
                name= 'cf_<?php echo $row["pk"]; ?>'><?php echo $row["Codice Fiscale"]; ?></td>
                <td	id	= 'registrazione_<?php echo $row["pk"]; ?>' 
                name= 'registrazione_<?php echo $row["pk"]; ?>'><?php echo $row["Registrazione"]; ?></td>
          <td>
            <!--<button onclick="elimina('<?php //echo $row["pk"]?>','<?php /*echo $row["nome"]*/?>')">elimina</button>-->
            <button onclick="aggiorna('<?php echo $row["pk"]?>')">aggiorna</button>
          </td>        
		</tr>
<?php
	}	// graffa che chiude il while
?>
	</table>
<?php
	}	// graffa che chiude l'if
?>

<?php echo $result->num_rows; ?> elementi<br>
<form action="" method="POST"  >
<h3><b>Inserimento Utenti:</b></h3>
    Nome: <input type='text' name='nome' id='nome' ><br>
    Cognome: <input type='text' name='cognome' id='cognome' ><br>
    Codice Fiscale: <input type='text' name='cf' id='cf' ><br>
   <!-- Abilitato: <input type='number' name='abilitato' id='abilitato' min=0 max=1 ><br>-->
    Email: <input type='email' name='ema' id='ema' required><br>
    Password: <input type='password' name='pass' id='pass'><br>
    <br><input type='submit' id="azione2" name="azione2" value='insert'><br><br>
</form>
<form 	action	= ""
		method	= "POST" 
        id		= "insupddel" 
        name	= "insupddel" 
        style	= "display:none;">
        <h3><b>Aggiornamento campi</h3>
	<input type="hidden" name="azione" id="azione" value="insert">
	<input type="hidden" name="pk" id="pk" value="">
    Campi: <select id='campi' name='campi'>
            <option value='' label='Seleziona un campo' selected disabled>
            <option value='nome' label='nome'>
            <option value='cognome' label='cognome'>
            <option value='is_enabled' label='is_enabled'>
            <option value='email' label='email'>
            <option value='password' label='password'>
            <option value='cf' label='cf'>
            <option value='registrazione' label='registrazione'>
    </select>
    Valore: <input type='text' 		name='nome' id='nome' ><br>
	<input type="submit" 	value="inserisci" >
</form>
</body>
</html>
<?php
}
$conn->close();
?>