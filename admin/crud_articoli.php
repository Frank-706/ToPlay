<?php
session_start();
include "../config.php";
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
if(isset($_SESSION["pkb"]))
{
?>
<!DOCTYPE html>
<html>
<title>CRUD : Articoli</title>
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
        function elimina(pk, s) {
            if (confirm("sei sicuro di voler eliminare l'articolo " + s + "?")) {
            document.getElementById('azione').value = "delete";
            document.getElementById('pk').value = pk;
            document.forms["insupddel"].submit();
                }
                return;
            }

function aggiorna(pk) {
            document.getElementById('pk').value = pk;
            document.getElementById('azione').value = "update";
            document.getElementById('nome').value = document.getElementById('nome_'+pk).innerHTML;
                document.getElementById('num').value = document.getElementById('prezzo_'+pk).innerHTML;
                document.getElementById('qt').value = document.getElementById('qt_'+pk).innerHTML;
				document.getElementById('codice').value = document.getElementById('codice_'+pk).innerHTML;
				document.getElementById('descr').value = document.getElementById('descrizione_'+pk).innerHTML;
        document.getElementById('scat').value = document.getElementById('sCat_'+pk).innerHTML;
            $("#insupddel").show();
                return;
            }
            
            function inserisci() {
            $('#insupddel').toggle();
            document.getElementById('pk').value = "";
            document.getElementById('azione').value = "insert";
                if (this.value=='inserisci')
                this.value='annulla';
                else
                this.value='inserisci';
				document.getElementById('nome').value = "";
        document.getElementById('num').value = "";
        document.getElementById('qt').value = "";
				document.getElementById('codice').value = "";
				document.getElementById('descr').value = "";
                return;
}
        </script>
</head>
<body>
<h1>CRUD: ARTICOLI</h1>
<br><a href="http://frankmoses.altervista.org/wapp/toplay/admin/index.php">Home CRUD</a><br>
<?php
if ($_POST["azione"] == "update") {
  $qta = $_POST["qt"];
  $nome = $_POST["nome"];  
  $desc = $_POST["descr"];
  $codice=$_POST['codice'];
  $s_categorie=$_POST['scat'];
  if($_POST["num"]>0){
  $prezzo = (double)$_POST["num"];
  }
  if(isset($_POST['visibile'])){

  /*$sql="SELECT s.nome as 'nome', s.pk as 'pk', a.fk_articoli as 'fk_sott'  from tp_sottocategorie s
          join tp_articoli a on a.fk_sottocategorie = s.pk 
          where s.is_visibile=1 and s.nome='$s_categorie'";
		   $conn->query($sql);
		   $RS = $conn->query($sql);     // esecuzione della query di insert sul DB
   while ($row = $RS->fetch_assoc())
           $fk=$row['fk_sott'];*/
  $sql = "UPDATE tp_articoli SET
                          nome = '$nome',
						  prezzo_cata=$prezzo,
						  is_visibile=1,
						  qta = $qta,
						  descrizione='$desc',
              codice='$codice',
						  fk_sottocategorie = $s_categorie
              WHERE pk = ".$_POST["pk"];
                 $conn->query($sql); // esecuzione della query sul DB
				 echo $sql;
  }
  else{
    $sql = "UPDATE tp_articoli SET
                          nome = '$nome',
						  prezzo_cata=$prezzo,
						  is_visibile=0,
						  qta = $qta,
						  descrizione='$desc',
              codice='$codice',
						  fk_sottocategorie = $s_categorie
              WHERE pk = ".$_POST["pk"];
                 $conn->query($sql); // esecuzione della query sul DB
				 echo $sql;
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
    else{
      echo "File is not an image. Upload failed!";
    }
////////////////////////////////////

  $msg = "aggiornamento dell'articolo '$nome' avvenuto con successo";
}

if ($_POST["azione"] == "delete") {
$sql = "DELETE FROM tp_articoli WHERE pk = " . $_POST["pk"];
$conn->query($sql);
}

if ($_POST["azione"] == "insert") {
	$s_categorie=$_POST['scat'];
  $quantita=$_POST['qt'];
  if(isset($_POST['visibile'])){
  $visibile=1;
  }
  else{
    $visibile=0;
  }
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
}
$sql = "
		SELECT  s.nome as 'Sotto categoria',a.pk as 'pk', a.nome as 'Nome', a.prezzo_cata as 'Prezzo', a.is_visibile as 'Visibilità', a.qta as 'QTA', a.codice AS 'Codice', a.descrizione as 'Descrizione'
		FROM 	tp_articoli a
        join tp_sottocategorie s on a.fk_sottocategorie = s.pk
       order by a.nome ASC
        ";
$result = $conn->query($sql);
echo $sql;
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
    setlocale(LC_MONETARY, 'it_IT');
        $ppK=$row["pk"];
        echo $row["pk"];
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
          <td	id	= 'qt_<?php echo $row["pk"]; ?>' 
                name= 'qt_<?php echo $row["pk"]; ?>'><?php echo $row["QTA"]; ?></td>
          <td	id	= 'codice_<?php echo $row["pk"]; ?>' 
                name= 'codice_<?php echo $row["pk"]; ?>'><?php echo $row["Codice"]; ?></td>
          <td	id	= 'descrizione_<?php echo $row["pk"]; ?>' 
                name= 'descrizione_<?php echo $row["pk"]; ?>'><?php echo $row["Descrizione"]; ?></td>
          <td	id	= 'sCat_<?php echo $row["pk"]; ?>' 
                name= 'sCat_<?php echo $row["pk"]; ?>'><?php echo $row["Sotto categoria"]; ?></td>     
          <td>
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

<form action = "crud_articoli.php"
enctype = "multipart/form-data" 
method = "POST" 
        id = "insupddel" 
        name = "insupddel" 
        style = "display:none;">
<input type="hidden" name="azione" id="azione" value="insert">
<input type="hidden" name="pk" id="pk" value="">
    Nome: <input type='text' name='nome' id='nome' placeholder="nome dell'articolo..." ><br>
    Prezzo: <input type='text' name='num' id='num' placeholder="prezzo dell'articolo..." ><br>
    Visibilit&agrave;: <input type="checkbox" id='visibile' name='visibile'><br>
    Quantit&agrave;: <input type='text' name='qt' id='qt' ><br>
    Codice: <input type='text' name='codice' id='codice'><br>
    Descrizione: <input type='text' id="descr" name="descr"  placeholde="Descrizione..."><br>
    <?php
   echo "Sotto Categorie: <select id='scat' name='scat'>\n";
   echo " <option value='' label='Seleziona una sotto categoria' selected disabled/>"; 
   $sql = "SELECT distinct s.nome as 'nome',s.pk as 'pk', a.fk_sottocategorie as 'fk' from tp_sottocategorie s
          join tp_articoli a on s.pk=a.fk_sottocategorie
          where s.is_visibile=1";
   $RS = $conn->query($sql);     // esecuzione della query di insert sul DB
   while ($row = $RS->fetch_assoc())
       echo "<option value='".$row["pk"]."'>" . $row["nome"] . "</option>\n"; 
       echo "</select>\n";
  ?>
  <br><input type='file' 		name='immagine' 	id='immagine' > Immagine <br>
<input type="submit" value="inserisci">
</form>
</body>
</html>
<?php
}
$conn->close();
?>
