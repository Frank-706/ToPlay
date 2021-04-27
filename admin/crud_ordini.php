<?php
var_dump($_SERVER);
//die("disabled");
session_start();
include "../config.php";
//var_dump($_POST);
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
if(isset($_SESSION['pkb'])){
?>
<!DOCTYPE html>
<html>
	<title>CRUD: ORDINI</title>
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
<h1>CRUD: ORDINI</h1>
<br><a href="http://frankmoses.altervista.org/wapp/toplay/admin/index.php">Home CRUD</a><br>
<?php
if ($_POST["azione"] == "update") {
    $campi = $_POST["campi"];
    $nome = $_POST["nome"];
        //echo $password;
  if($campi=="dt"){
  $sql = "UPDATE tp_ordini SET
                          dt = '$nome'
                 WHERE pk = ".$_POST["pk"];
                 $conn->query($sql); // esecuzione della query sul DB
  }
  if($campi=="is_annullato"){
    $sql = "UPDATE tp_ordini SET
                           is_annullato = $nome
                   WHERE pk = ".$_POST["pk"];
                   $conn->query($sql); // esecuzione della query sul DB
                   echo $sql;
    }
    if($campi=="nro"){ 
        $sql = "UPDATE tp_ordini SET
        nro = $nome
    WHERE pk = ".$_POST["pk"];
   $conn->query($sql); // esecuzione della query sul DB
    echo $sql;
      }
  if($campi=="fk_utenti")
  { 
    $nome = $_POST["nome"];
    $sql = "UPDATE tp_ordini SET
                        fk_utenti = $nome
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
}
if ($_POST["azione2"] == "insert") {
//die("disabled");
	// trattamento dei dati ricevuti da POST: var_dump($_POST) se interessa indagare
  $annullato=$_POST['annullato'];
  $data=$_POST['data_d'];
  $num = $_POST["nro"];
  $utenti=$_POST["utenti"];
  $sql = "SELECT COUNT(*) AS n FROM tp_ordini WHERE nro=$num";
	$RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
	$row = $RS->fetch_assoc();	// da $RS estraggo una riga
    if ($row["n"]>=1) {			// testo il campo "n" della riga
    	$msg = "Ordine '$num' esistente, impossibile inserire";
        echo $msg."<br>";
    }
    else if ($num == "") {
    	$msg = "Ordine non specificato, impossibile inserire";
        echo $msg."<br>";
    }
    else
    $sql = "INSERT INTO tp_ordini (
                          pk,
                          dt,
						  nro,
                         is_annullato,
                         fk_utenti
                      ) VALUES (
                             null,
                          '$data',
                          $num,
                          $annullato,
                          $utenti
                      )";
    $conn->query($sql); // esecuzione della query di insert sul DB
    echo $sql;  
}
/*if ($_POST["azione"] == "delete") {
	$sql = "DELETE FROM tp_articoli WHERE pk = " . $_POST["pk"];
	$conn->query($sql);
    if (file_exists("../img/upload/articolo_".$_POST["pk"].".png"))
    	unlink("../img/upload/articolo_".$_POST["pk"].".png");
}*/

$sql = "
		SELECT  o.pk as 'pk', o.is_annullato as 'Annullare', o.nro AS 'Numero', o.dt as 'Data', u.email as 'Utenti'
		FROM 	tp_ordini o
        join tp_utenti u on o.fk_utenti=u.pk
       order by o.nro ASC
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>
	<table border='1'>
      <tr>
        <th>Numero</th>
        <th>Data</th>
        <th>Annullare?</th>
        <th>Utenti</th>
        <th>comandi</th>
      </tr>
<?php
	while($row = $result->fetch_assoc()) {
        $dt=date('d/m/Y',$row["Data"]);
?>
		<tr>
          <td	id	= 'num_<?php echo $row["pk"]; ?>' 
          		name= 'num_<?php echo $row["pk"]; ?>'><?php echo $row["Numero"]; ?></td>
          <td	id	= 'data_<?php echo $row["pk"]; ?>' 
          		name= 'data_<?php echo $row["pk"]; ?>'><?php echo /*$row["Data"];*/$dt ?></td>
           <td align="center"	id	= 'annullare_<?php echo $row["pk"]; ?>' 
          		name= 'annullare_<?php echo $row["pk"]; ?>'><?php echo $row["Annullare"]; ?></td>
                <?php
                if(isset($_SESSION["pkb"])){
                ?>
         <td	id	= 'email_<?php echo $row["pk"]; ?>' 
                name= 'email_<?php echo $row["pk"]; ?>'><?php echo $row["Utenti"]; ?></td>
                <?php
                }
                ?>
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
<h3><b>Inserimento Ordini:</b></h3>
    Numero: <input type='text' name='nro' id='nro' placeholder="inserisci un numero" ><br>
    Data: <input type='date' name='data_d' id='data_d' ><br>
    Annullato: <input type='number' name='annullato' id='annullato' min=0 max=1 ><br>
    <?php
   echo "Utenti: <select id='utenti' name='utenti'>\n";
   echo " <option value='' label='Seleziona un utente' selected disabled/>"; 
   $sql = "SELECT *  from tp_utenti ";
   $RS = $conn->query($sql);     // esecuzione della query di insert sul DB
   while ($row = $RS->fetch_assoc())
       echo "<option value='".$row["pk"]."'>" . $row["email"] . "</option>\n"; 
       echo "</select>\n";
  ?>
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
            <option value='dt' label='dt'>
            <option value='nro' label='nro'>
            <option value='is_annullato' label='is_annullato'>
            <option value='fk_utenti' label='fk_utenti'>
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