<?php
//var_dump($_SERVER);
//die("disabled");
session_start();
include "config.php";
//var_dump($_POST);
$conn = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pass"], $CONFIG["db-name"]);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
?>
<!DOCTYPE html>
<html>
	<head>
    <title>TO PLAY: CARRELLO</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <style>
            td img {
            	width:32px;
            	height:32px;
            }
            img {
                float: right;
            }
        	body {
            	padding:10px;
                background-color: grey;  
                }
        	.comando {
            	width:50px;
            	height:50px;
            }
            table{
                margin: auto;
                border: solid black;
                width: 50%;
                background-color: #62a0ff;
                color:black;
                border-style: ridge;
            }
            th {
                background-color: #ffc753;
            	color:#530053;
                text-align: center;
            }
        </style>
        <script>
        function elimina(pk, nome ) {
            if (confirm("sei sicuro di voler eliminare l'articolo "+ nome +" dal carrello?")) {
                    document.getElementById('azione').value = "delete";
                    document.getElementById('pk').value = pk;
                    document.getElementById("cancellatore").submit();
                }
                return;
            }
        </script>
</head>
<body>
<!--<h1>TO PLAY: CARRELLO</h1>
<br><a href="index.php">Ritorna al catalogo</a><br>-->
<form action='' method="POST" >
<input type="submit" id="checkout" name="checkout" value="checkout">
<a href="index.php">Ritorna al catalogo</a>
</form>
<?php
if ($_POST["azione"] == "delete") {
    //die("disabled");
        $sql = "DELETE FROM tp_carrelli WHERE fk_articoli = " . $_POST["pk"];
        $conn->query($sql);
        //echo $sql;
    }
    if ($_POST["checkout"] == "checkout") {
            $sql = "SELECT o.pk as 'fko', c.prezzo_vend as 'prezzo', c.fk_articoli as 'fka'
                    FROM tp_ordinati orr
                    JOIN tp_ordini o ON o.pk = orr.fk_ordini
                    JOIN tp_utenti u ON u.pk = o.fk_utenti
                    JOIN tp_carrelli c ON u.pk = c.fk_utenti ";
           $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                $art=$row['fka'];
                $fko=$row['fko'];
                $prezzoV = $row['prezzo'];
            }
            $sql = "INSERT INTO tp_ordinati(qta, fk_ordini, fk_articoli, prezzo_vend) VALUES( 1,$fko, $art, $prezzoV)";
            $conn->query($sql);
           // echo $sql;
            $sql = "DELETE FROM tp_carrelli WHERE fk_utenti = " . $_SESSION["pkf"];
            $conn->query($sql);
            //echo $sql;
        }
$pk=$_SESSION['pkf'];
//echo $pk; from_unixtime(c.dt)
$sql="SELECT c.pk as 'Id',a.nome as 'Articolo', c.dt as 'Data' , a.prezzo_cata as 'Prezzo', c.qta as 'Qta', c.fk_articoli as 'fk_art' FROM tp_carrelli c
     join tp_articoli a on a.pk = c.fk_articoli
     where c.fk_utenti=$pk"; 
    // echo $sql;
    $result=$conn->query($sql);
    //var_dump($result);
    if ($result->num_rows > 0) 
    {
    echo "<table border='2'>";
    echo "<tr>";
    echo "<th>Articolo</th>";
    echo "<th>Prezzo</th>";
    echo "<th>Quantit&agrave;</th>";
    echo "<th>Data</th>";
   echo  "<th>comandi</th>";
   echo "</tr>";
   echo "<tr>";
    while($row = $result->fetch_assoc()) {
        //$carrello=$row['Id'];
        echo "<tr>\n";
            echo "<td align='center'>".$row["Articolo"]."</td>\n";
            echo "<td align='center'>".$row["Prezzo"]."</td>\n";
            echo  "<td align='center'>".$row["Qta"]."</td>\n";
            echo "<td align='center'>".date("d/M/Y", $row["Data"])."</td>\n";;
?>
         <td align='center'>
         <button onclick="elimina('<?php echo $row["fk_art"]?>','<?php echo $row["Articolo"]?>')">elimina</button>
        </td>
    <?php
        echo '</tr>';
    }
    echo "</table><br>";
}
else {
        echo "Nessun risultato";
    }    
?>
<form id="cancellatore" name="cancellatore" method="POST" action="">
         <input type="hidden" id="azione" name="azione" value="">
         <input type="hidden" name="pk" id="pk" value="">
</form>
</body>
</html>
<?php 
$conn->close();
?>