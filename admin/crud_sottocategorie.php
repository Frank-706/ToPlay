<?php
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
	<title>CRUD: SOTTO CATEGORIE</title>
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
                return;
}
        </script>
</head>
<body>
<h1>CRUD: SOTTO CATEGORIE</h1>
<br><a href="http://frankmoses.altervista.org/wapp/toplay/admin/index.php">Home CRUD</a><br>
<?php
if ($_POST["azione"] == "update") {
    $categorie = $_POST["categoria"];
    $nome = $_POST["nome"];
    $visibilita=$_POST["visibile"];
    //echo $visibilita;
  if(isset($visibilita)){
    $sql = "UPDATE tp_sottocategorie SET
							nome = '$nome',
							fk_categorie=$categorie,
                            is_visibile = 1
                   WHERE pk = ".$_POST["pk"];
                   $conn->query($sql); // esecuzione della query sul DB
                   echo $sql;
    }
    else{
			$sql = "UPDATE tp_sottocategorie SET
							nome = '$nome',
							fk_categorie=$categorie,
                            is_visibile = 0
                   WHERE pk = ".$_POST["pk"];
                   $conn->query($sql); // esecuzione della query sul DB
                   echo $sql;
        }
}
if ($_POST["azione"] == "insert") {
//die("disabled");
	// trattamento dei dati ricevuti da POST: var_dump($_POST) se interessa indagare
  $visibile=$_POST['visibile'];
	$nome = $_POST["nome"];
    $categorie=$_POST["categoria"];
  if($numero>=0){
    $sql = "SELECT COUNT(*) AS n FROM tp_sottocategorie WHERE nome='$nome'";
    $RS = $conn->query($sql); 	// esecuzione della query di insert sul DB
    $row = $RS->fetch_assoc();	// da $RS estraggo una riga
      if ($row["n"]>=1) {			// testo il campo "n" della riga
        $msg = "La Sotto Categoria '$nome' esistente, impossibile inserire";
          echo $msg."<br>";
      }
      else if ($nome == "") {
        $msg = "Sotto Categoria non specificata, impossibile inserire";
          echo $msg."<br>";
      }
      else
		  if(isset($_POST['visibile'])){
    $sql = "INSERT INTO tp_sottocategorie (
                          pk,
                          nome,
                         is_visibile,
                         fk_categorie
                      ) VALUES (
                             null,
                          '$nome',
                          1,
                          $categorie
                      )";
    $conn->query($sql); // esecuzione della query di insert sul DB
    echo $sql;
		  }
		  else{
			      $sql = "INSERT INTO tp_sottocategorie (
                          pk,
                          nome,
                         is_visibile,
                         fk_categorie
                      ) VALUES (
                             null,
                          '$nome',
                          0,
                          $categorie
                      )";
    $conn->query($sql); // esecuzione della query di insert sul DB
    echo $sql;
		  }
    //echo $sql;  
// gestione immagine
////////////////////////////////////

	  $msg = "inserimento della categoria '$nome' avvenuto con successo";
  }
}

$sql = "
		SELECT  s.nome as 'Sotto Categoria',s.pk as 'pk',s.is_visibile as 'Visibilità', c.nome as 'Categoria'
		FROM 	tp_sottocategorie s
        join tp_categorie c on s.fk_categorie=c.pk
        order by s.nome ASC
        ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>
	<table border='1'>
      <tr>
        <th>Sotto Categoria</th>
        <th>Visibilit&agrave;</th>
        <th>Categoria</th>
        <th>comandi</th>
      </tr>
<?php
	while($row = $result->fetch_assoc()) {
?>
		<tr>
          <td	id	= 'nome_<?php echo $row["pk"]; ?>' 
          		name= 'nome_<?php echo $row["pk"]; ?>'><?php echo $row["Sotto Categoria"]; ?></td>
                  <td align="center" id='visibile_<?php echo $row["pk"]; ?>' 
          		name= 'visibile_<?php echo $row["pk"]; ?>'><?php echo $row["Visibilità"]; ?></td>
            <td	id	= 'categorie_<?php echo $row["pk"]; ?>' 
                name= 'categorie_<?php echo $row["pk"]; ?>'><?php echo $row["Categoria"]; ?></td>
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
<form 	action	= "crud_sottocategorie.php"
		method	= "POST" 
        id		= "insupddel" 
        name	= "insupddel" 
        style	= "display:none;">
        <input type="hidden" name="azione" id="azione" value="insert">
<input type="hidden" name="pk" id="pk" value="">
	Nome: <input type='text' name='nome' id='nome' placeholder="nome della Sotto Categoria..."><br>
    Visibilit&agrave;: <input type='checkbox' name='visibile' id='visibile'><br>
    <?php
   echo "Categoria: <select id='categoria' name='categoria'>\n";
   echo " <option value='' label='Seleziona una categoria' selected disabled/>"; 
   $sql = "SELECT * from tp_categorie where is_visibile=1";
   $RS = $conn->query($sql);     // esecuzione della query di insert sul DB
   while ($row = $RS->fetch_assoc())
       echo "<option value='".$row["pk"]."'>" . $row["nome"] . "</option>\n"; 
       echo "</select>\n";
  ?>
	<input type="submit" value="inserisci">
</form>
</body>
</html>
<?php
}
$conn->close();
?>