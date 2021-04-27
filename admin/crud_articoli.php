<?php
//die("disabled");
session_start();
include "../config.php";
//var_dump($_POST);
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error); 
/////////////////////////////
if(isset($_SESSION["pkb"]))
{
?>
<!DOCTYPE html>
<html>
	<title>CRUD: ARTICOLI</title>
	<head>
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
<h1>CRUD: ARTICOLI</h1>
<br><a href="http://frankmoses.altervista.org/wapp/toplay/admin/index.php">Home CRUD</a><br>
<?php
if ($_POST["azione"] == "update") {
    $campi = $_POST["campi"];
  $nome = $_POST["nome"];
  $prezzo = (double)$_POST["nome"];
  $visibile=$_POST["is_visibile"];
  if($campi=="codice"){
  $sql = "UPDATE tp_articoli SET
                          $campi = $nome
                 WHERE pk = ".$_POST["pk"];
                 $conn->query($sql); // esecuzione della query sul DB
  }
  if(isset($visibile)){
    $sql = "UPDATE tp_articoli SET
                            is_visibile = 1
                   WHERE pk = ".$_POST["pk"];
                   $conn->query($sql); // esecuzione della query sul DB
    }
    if(!isset($visibile)){
      $sql = "UPDATE tp_articoli SET
                              is_visibile = 0
                     WHERE pk = ".$_POST["pk"];
                     $conn->query($sql); // esecuzione della query sul DB
      }
    if($campi=="fk_sottocategorie"){
      $sql = "UPDATE tp_articoli SET
                              $campi = $nome
                     WHERE pk = ".$_POST["pk"];
                     $conn->query($sql); // esecuzione della query sul DB
      }
    if($campi=="qta"){
      $sql = "UPDATE tp_articoli SET
                              $campi = $nome
                     WHERE pk = ".$_POST["pk"];
                     $conn->query($sql); // esecuzione della query sul DB
      }
  if($campi=="descrizione")
  {
    $sql = "UPDATE tp_articoli SET
                          $campi = '$nome'
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
  if($campi=="prezzo_cata" and $prezzo>=0)
  {
    //$nome=(double)$_POST["nome"];
    $sql = "UPDATE tp_articoli SET
                          $campi = $prezzo
                 WHERE pk = ".$_POST["pk"];
                 echo $sql;
    $conn->query($sql); // esecuzione della query sul DB
    }
  if($campi=="nome")
  {
    $sql = "UPDATE tp_articoli SET
                          $campi = '$nome'
                 WHERE pk = ".$_POST["pk"];
    $conn->query($sql); // esecuzione della query sul DB
  }
// gestione immagine
    $check = getimagesize($_FILES["immagine"]["tmp_name"]);
    if($check !== false) {
      if ($check["mime"]=="image/png") {
        $da = $_FILES["immagine"]["tmp_name"];
        $a = "../img/upload/articolo_" . $_POST["pk"] . ".png";
        move_uploaded_file($da, $a);
	  }
      else
        echo "File is not a PNG. Upload failed!";
    }
    else
      echo "File is not an image. Upload failed!";
////////////////////////////////////

  $msg = "aggiornamento dell'articolo '$nome' avvenuto con successo";
}
if ($_POST["azione2"] == "insert") {
//die("disabled");
	// trattamento dei dati ricevuti da POST: var_dump($_POST) se interessa indagare
  $s_categorie=$_POST['scat'];
  $quantita=$_POST['qt'];
  $visibile=$_POST['visibile'];
  $numero=(double)$_POST['num'];
  $codice=$_POST['codice'];
  $descrizione=$_POST['descr'];
	$nome = $_POST["nome"];
  if($numero>=0){
    $sql = "SELECT COUNT(*) AS n FROM tp_articoli WHERE nome='$nome'";
    $RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
    $row = $RS->fetch_assoc();	// da $RS estraggo una riga
      if ($row["n"]>=1) {			// testo il campo "n" della riga
        $msg = "L'email '$nome' esistente, impossibile inserire";
          echo $msg."<br>";
      }
      else if ($nome == "") {
        $msg = "Articolo non specificato, impossibile inserire";
          echo $msg."<br>";
      }
      else
    $sql = "INSERT INTO tp_articoli (
                          pk,
                          nome,
						             prezzo_cata,
                         codice,
                         is_visibile,
                         qta,
                         descrizione,
                         fk_sottocategorie
                      ) VALUES (
                             null,
                          '$nome',
                          $numero,
                          '$codice',
                          $visibile,
                          $quantita,
                          '$descrizione',
                          $s_categorie
                      )";
    $conn->query($sql); // esecuzione della query di insert sul DB
    //echo $sql;  
// gestione immagine
    $check = getimagesize($_FILES["immagine"]["tmp_name"]);
    if($check !== false) {
      if ($check["mime"]=="image/png") {
        $da = $_FILES["immagine"]["tmp_name"];
        $a = "../img/upload/articolo_" . mysqli_insert_id($conn) . ".png";
        move_uploaded_file($da, $a);
	  }
      else
        echo "File is not a PNG. Upload failed!";
    }
    else
      echo "File is not an image. Upload failed!";
////////////////////////////////////

	  $msg = "inserimento dell'articolo '$nome' avvenuto con successo";
  }
  else{
    ?>
    <script>
       alert("Inserire un prezzo reale e non inferiore a 0 o una parola/lettera!");
    </script>
    <?php
  }
}
/*if ($_POST["azione"] == "delete") {
	$sql = "DELETE FROM tp_articoli WHERE pk = " . $_POST["pk"];
	$conn->query($sql);
    if (file_exists("../img/upload/articolo_".$_POST["pk"].".png"))
    	unlink("../img/upload/articolo_".$_POST["pk"].".png");
}*/

$sql = "
		SELECT  s.nome as 'Sotto categoria',a.pk as 'pk', a.nome as 'Nome', a.prezzo_cata as 'Prezzo', a.is_visibile as 'Visibilità', a.qta as 'QTA', a.codice AS 'Codice', a.descrizione as 'Descrizione'
		FROM 	tp_articoli a
        join tp_sottocategorie s on a.fk_sottocategorie = s.pk
       order by a.nome ASC
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>
	<table border='1'>
      <tr>
        <th>Articolo</th>
        <th>immagini</th>
        <th>Prezzo</th>
        <th>Visibilit&agrave;</th>
        <th>Quantit&agrave;</th>
        <th>Codice</th>
        <th>Descrizione</th>
        <th>Sotto categorie</th>
        <th>comandi</th>
      </tr>
<?php
	while($row = $result->fetch_assoc()) {
    	$fn = "../img/upload/articolo_" . $row["pk"] . ".png";
?>
		<tr>
          <td	id	= 'nome_<?php echo $row["pk"]; ?>' 
          		name= 'nome_<?php echo $row["pk"]; ?>'><?php echo $row["Nome"]; ?></td>
          <td align="center"	id	= 'immagine_<?php echo $row["pk"]; ?>' 
          		name= 'immagine_<?php echo $row["pk"]; ?>'>
                <?php if (file_exists($fn)) { ?>
                	<a 	href="<?php echo $fn; ?>"
                    	target="_blank">
                        <?php /* https://www.scriptarticle.com/php-prevent-image-caching-prevent-browser-caching-using-http-headers/#:~:text=Simple%20way%20to%20disable%20image,eg.&text=By%20this%20browser%20understand%20a,jpg'. */ ?>
                    	<img src="<?php echo $fn; ?>?nocache=<?php echo md5(time()) ?>">
                    </a>
                <?php } ?>
          </td>
          <td	id	= 'prezzo_<?php echo $row["pk"]; ?>' 
          		name= 'prezzo_<?php echo $row["pk"]; ?>'><?php echo $row["Prezzo"]; ?></td>
           <td align="center"	id	= 'visibile_<?php echo $row["pk"]; ?>' 
          		name= 'visibile_<?php echo $row["pk"]; ?>'><?php echo $row["Visibilità"]; ?></td>
          <td	id	= 'qta_<?php echo $row["pk"]; ?>' 
                name= 'qta_<?php echo $row["pk"]; ?>'><?php echo $row["QTA"]; ?></td>
          <td	id	= 'codice_<?php echo $row["pk"]; ?>' 
                name= 'codice_<?php echo $row["pk"]; ?>'><?php echo $row["Codice"]; ?></td>
          <td	id	= 'descrizione_<?php echo $row["pk"]; ?>' 
                name= 'descrizione_<?php echo $row["pk"]; ?>'><?php echo $row["Descrizione"]; ?></td>
          <td	id	= 'sCat_<?php echo $row["pk"]; ?>' 
                name= 'sCat_<?php echo $row["pk"]; ?>'><?php echo $row["Sotto categoria"]; ?></td>     
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
    Nome: <input type='text' name='nome' id='nome' min=0 placeholder="nome dell'articolo..." ><br>
    Prezzo: <input type='text' name='num' id='num' placeholder="prezzo dell'articolo..." ><br>
    Visibilit&agrave;: <input type='number' name='visibile' id='visibile'min=0 max=1 ><br>
    Quantit&agrave;: <input type='number' name='qt' id='qt'min=0 ><br>
    Codice: <input type='text' name='codice' id='codice'><br>
    <?php
   echo "Sotto Categorie: <select id='scat' name='scat'>\n";
   echo " <option value='' label='Seleziona una sotto categoria' selected disabled/>"; 
   $sql = "SELECT *  from tp_sottocategorie ";
   $RS = $conn->query($sql);     // esecuzione della query di insert sul DB
   while ($row = $RS->fetch_assoc())
       echo "<option value='".$row["pk"]."'>" . $row["nome"] . "</option>\n"; 
       echo "</select>\n";
  ?>
    <br>Descrizione: <textarea id="descr" name="descr" rows="2" cols="50" placeholde="Descrizione..."></textarea>
    <br><input type='file' 		name='immagine' 	id='immagine' > Immagine <br>
<br><input type='submit' id="azione2" name="azione2" value='insert'><br><br>

</form>
<form 	action	= ""
		enctype	= "multipart/form-data" 
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
            <option value='prezzo_cata' label='prezzo'>
            <!--<option value='is_visibile' label='visibilità'>-->
            <option value='qta' label='quantità'>
            <option value='codice' label='codice'>
            <option value='descrizione' label='descrizione'>
            <option value='codice' label='codice'>
            <option value='fk_sottocategorie' label='SottoCategorie'>
    </select>
    <input type='text' 		name='nome' 		id='nome' > Valore <br>
    Visibilit&agrave;: <input type="checkbox" id='is_visibile' name='is_visibile'>
    <input type='file' 		name='immagine' 	id='immagine' > Immagine <br>
	<input type="submit" 	value="inserisci" >
</form>
</body>
</html>
<?php
}
$conn->close();
?>