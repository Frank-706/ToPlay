<?php
//die("disabled");
session_start();
include "../config.php";
//var_dump($_POST);
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
if(isset($_SESSION["pkb"])){
?>
<!DOCTYPE html>
<html>
	<title>CRUD: CATEGORIE</title>
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
<h1>CRUD: CATEGORIE</h1>
<br><a href="http://frankmoses.altervista.org/wapp/toplay/admin/index.php">Home CRUD</a><br>
<?php
if ($_POST["azione"] == "update") {
    $campi = $_POST["campi"];
  $nome = $_POST["nome"];
  $visibile=$_POST["is_visibile"];
  if(isset($visibile)){
    $sql = "UPDATE tp_categorie SET
                            is_visibile = 1
                   WHERE pk = ".$_POST["pk"];
                   $conn->query($sql); // esecuzione della query sul DB
    }
    if(!isset($visibile)){
      $sql = "UPDATE tp_categorie SET
                              is_visibile = 0
                     WHERE pk = ".$_POST["pk"];
                     $conn->query($sql); // esecuzione della query sul DB
      }
  if($campi=="nome")
  {
    $sql = "UPDATE tp_categorie SET
                          $campi = '$nome'
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
// gestione immagine
    $check = getimagesize($_FILES["immagine"]["tmp_name"]);
}
if ($_POST["azione2"] == "insert") {
//die("disabled");
	// trattamento dei dati ricevuti da POST: var_dump($_POST) se interessa indagare
  $visibile=$_POST['visibile'];
	$nome = $_POST["nome"];
    $sql = "SELECT COUNT(*) AS n FROM tp_categorie WHERE nome='$nome'";
    $RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
    $row = $RS->fetch_assoc();	// da $RS estraggo una riga
      if ($row["n"]>=1) {			// testo il campo "n" della riga
        $msg = "La categoria '$nome' esistente, impossibile inserire";
          echo $msg."<br>";
      }
      else if ($nome == "") {
        $msg = "Categoria non specificata, impossibile inserire";
          echo $msg."<br>";
      }
      else
    $sql = "INSERT INTO tp_categorie (
                          pk,
                          nome,
                         is_visibile
                      ) VALUES (
                             null,
                          '$nome',
                          $visibile
                      )";
    $conn->query($sql); // esecuzione della query di insert sul DB
    //echo $sql;  
// gestione immagine
////////////////////////////////////

	  $msg = "inserimento della categoria '$nome' avvenuto con successo";
  }
/*if ($_POST["azione"] == "delete") {
	$sql = "DELETE FROM tp_articoli WHERE pk = " . $_POST["pk"];
	$conn->query($sql);
    if (file_exists("../img/upload/articolo_".$_POST["pk"].".png"))
    	unlink("../img/upload/articolo_".$_POST["pk"].".png");
}*/

$sql = "
		SELECT  c.nome as 'Categoria',c.pk as 'pk',c.is_visibile as 'Visibilità'
		FROM 	tp_categorie c
       order by c.nome ASC
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>
	<table border='1'>
      <tr>
        <th>Categoria</th>
        <th>Visibilit&agrave;</th>
        <th>comandi</th>
      </tr>
<?php
	while($row = $result->fetch_assoc()) {
?>
		<tr>
          <td	id	= 'nome_<?php echo $row["pk"]; ?>' 
          		name= 'nome_<?php echo $row["pk"]; ?>'><?php echo $row["Categoria"]; ?></td>
          </td>
           <td	align="center" id	= 'visibile_<?php echo $row["pk"]; ?>' 
          		name= 'visibile_<?php echo $row["pk"]; ?>'><?php echo $row["Visibilità"]; ?></td>
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
<form action="" method="POST" 	enctype	= "multipart/form-data" >
<h3><b>Inserimento Articoli:</b></h3>
    Nome: <input type='text' name='nome' id='nome' min=0 placeholder="nome della categoria..." ><br>
    Visibilit&agrave;: <input type='number' name='visibile' id='visibile'min=0 max=1 ><br>
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
    </select>
    <input type='text' 		name='nome' 		id='nome' > Valore <br>
    Visibilit&agrave;: <input type="checkbox" id='is_visibile' name='is_visibile'>
	<input type="submit" 	value="inserisci" >
</form>
</body>
</html>
<?php
}
$conn->close();
?>