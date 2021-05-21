<?php
//var_dump($_SERVER);
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
                document.getElementById('pk').value = pk;
				document.getElementById('azione').value = "update";
				document.getElementById('nro').value = document.getElementById('num_'+pk).innerHTML;
                document.getElementById('data_d').value = document.getElementById('data_'+pk).innerHTML;
                document.getElementById('utenti').value = document.getElementById('email_'+pk).innerHTML;
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
				document.getElementById('nro').value = "";
                document.getElementById('data_d').value = "";
                document.getElementById('utenti').value ="";         
				return;
			}
        </script>
</head>
<body>
<h1>CRUD: ORDINI</h1>
<br><a href="http://frankmoses.altervista.org/wapp/toplay/admin/index.php">Home CRUD</a><br>
<?php
if ($_POST["azione"] == "update") {
     $annullato=$_POST['annullato'];
  $data=$_POST['data_d'];
  $num = $_POST["nro"];
  $utenti=$_POST["utenti"];
        //echo $password;
		if(isset($_POST['annullato'])){
  $sql = "UPDATE tp_ordini SET
                           nro=$num,
                          dt = unix_timestamp('$data'),
						  is_annullato=1,
						  fk_utenti=$utenti
                 WHERE pk = ".$_POST["pk"];
                 $conn->query($sql); // esecuzione della query sul DB
                 echo $sql;
  }
  else{
	  $sql = "UPDATE tp_ordini SET
                           nro=$num,
                          dt =unix_timestamp('$data'),
						  is_annullato=0,
						  fk_utenti=$utenti
                 WHERE pk = ".$_POST["pk"];
                 $conn->query($sql); // esecuzione della query sul DB
                 echo $sql;
  }
}
if ($_POST["azione"] == "insert") {
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
    if(isset($_POST['annulato'])){
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
                          1,
                          $utenti
                      )";
    $conn->query($sql); // esecuzione della query di insert sul DB
    echo $sql;  
}
else{
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
        0,
        $utenti
    )";
$conn->query($sql); // esecuzione della query di insert sul DB
echo $sql;  
}
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
        $dt=date('Y-m-d',$row["Data"]);
?>
		<tr>
          <td	id	= 'num_<?php echo $row["pk"]; ?>' 
          		name= 'num_<?php echo $row["pk"]; ?>'><?php echo $row["Numero"]; ?></td>
          <td	id	= 'data_<?php echo $row["pk"]; ?>' 
          		name= 'data_<?php echo $row["pk"]; ?>'><?php echo /*$row["Data"];*/$dt; ?></td>
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
<input type = "button"
id = "btn_cmd"
name = "btn_cmd"
value = "inserisci"
onclick = "inserisci();">
<form 	action	= "crud_ordini.php"
		method	= "POST" 
        id		= "insupddel" 
        name	= "insupddel" 
        style	= "display:none;">
	<input type="hidden" name="azione" id="azione" value="insert">
	<input type="hidden" name="pk" id="pk" value="">
    Numero: <input type='number' name='nro' id='nro' placeholder="inserisci un numero" ><br>
    Data: <input type='text' name='data_d' id='data_d' ><br>
    Annullato: <input type='checkbox' name='annullato' id='annullato'><br>
	<?php
	   echo "Utenti: <select id='utenti' name='utenti'>\n";
	   echo " <option value='' label='Seleziona un utente' selected disabled/>"; 
	   $sql = "SELECT *  from tp_utenti where is_enabled=1";
	   $RS = $conn->query($sql);     // esecuzione della query di insert sul DB
	   while ($row = $RS->fetch_assoc())
		   echo "<option value='".$row["pk"]."'>" . $row["email"] . "</option>\n"; 
		   echo "</select>\n";
  ?>
	<input type="submit" 	value="inserisci" >
</form>
</body>
</html>
<?php 
}
$conn->close();
?>