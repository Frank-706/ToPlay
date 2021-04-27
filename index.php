<?php
session_start();
include "config.php";
  $CN = new mysqli($CONFIG["db-host"], $CONFIG["db-user"], $CONFIG["db-pswd"], $CONFIG["db-name"]);
  if ($CN->connect_error)
      die("Connection failed: " . $CN->connect_error);
?>
<!DOCTYPE html>
<html>
<head>
<title>Login: UTENTI</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="toplay, login, utenti">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Pagina di login">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
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
                
            }
        </style>
</head>
<body>
<h1>To Play: Login</h1>
<?php 
if($_POST["chiusura"] == "logout"){
   echo "Logout effettuato.";
   unset($_SESSION["pkf"]);
   session_destroy();
 }
 if ($_POST["azione"] == "accedi") {		
    $sql="SELECT l.pk as 'pkf',l.nome as 'Nome' FROM tp_utenti l WHERE l.password = '".md5($_POST['pswd'])."' and l.email='".$_POST['ema']."' and l.is_enabled=1";

   $RS = $CN->query($sql); 
    if($RS->num_rows==1){
       $row = $RS->fetch_assoc();
       $_SESSION['pkf']=$row['pkf'];
       $_SESSION['ema']=$row['ema'];
       if(isset($_SESSION['pkf'])){
          $msg = "Benvenuto " . $row['Nome']." !";
       }
       //echo $msg.'<br>';
  }
  else{
    $msg ="Accesso negato!";
    //echo $msg.'<br>';
   }
 }
 ?>
<form action="" method="POST">
<fieldset>
<legend>Inserimento dati:</legend>
<strong>Email:</strong> <input type="email" id='ema' name="ema" placeholder="email"><br>
<strong>Password:</strong> <input type="password" id='pswd' name="pswd" placeholder="password"><br>
<input type="submit"  id="azione" name="azione" value="accedi"> oppure <a href="http://frankmoses.altervista.org/INFORMATICA/wapp/ToPlay/registra.php"> clicca qui</a> per registrarti
<?php
//
if(isset($_SESSION["pkf"]))
{
?>
<br><br><strong>Ricerca: </strong> <input type='text' name='nome' id='nome' placeholder='categorie,articoli,...'> 
<input type='submit' name="azione2" id="azione2" value='Ricerca'> 
<br><input type="submit" id="chiusura" name="chiusura" value="logout">
<?php
}
?>
</form>
</fieldset>
<?php
 if ($_POST["azione2"] == "Ricerca")
    {
    $tipo = $_POST["nome"];
    //$select = $_POST["filtro"];
    /*echo $select;
    echo $tipo;*/
    $sql = "
            SELECT 
            a.pk as 'Id',
            c.nome as 'Categoria',
            a.codice as 'Code',
            s.nome as 'SottoCategoria',
            a.nome as 'Articoli',
            a.prezzo_cata as 'Prezzo',
            a.descrizione as 'Descrizione',
            a.qta as 'Quantità'
            FROM tp_articoli a
            join tp_sottocategorie s on a.fk_sottocategorie = s.pk
            join tp_categorie c on s.fk_categorie = c.pk
            where a.qta > 0 and a.is_visibile=1
            or a.codice like '%$tipo%' and a.is_visibile=1
            or c.nome like '%$tipo%' and a.is_visibile=1
            or s.nome like '%$tipo%' and a.is_visibile=1 
            or a.nome like '%$tipo%' and a.is_visibile=1
            or a.prezzo_cata like '%$tipo%' and a.is_visibile=1
            or a.qta like '%$tipo%' and a.is_visibile=1
            order by c.nome, s.nome";
            $result = $CN->query($sql);
        }
        else 
        {
            $sql = "
            SELECT 
            a.pk as 'Id',
            a.codice as 'Code',
            c.nome as 'Categoria',
            a.descrizione as 'Descrizione',
            s.nome as 'SottoCategoria',
            a.nome as 'Articoli',
            a.prezzo_cata as 'Prezzo',
            a.qta as 'Quantità'
            FROM tp_articoli a
            join tp_sottocategorie s on a.fk_sottocategorie = s.pk
            join tp_categorie c on s.fk_categorie = c.pk
            where a.qta > 0 and a.is_visibile=1
            order by c.nome, s.nome ";
            $result = $CN->query($sql);
        }
            if ($result->num_rows > 0) 
            {
            echo "<table border='2'>";
            echo "<tr>";
            echo "<th>Categoria</th>";
            echo "<th>Sotto Categoria</th>";
            echo "<th>Codice</th>";
            echo "<th>Articoli</th>";
            echo "<th>Prezzo</th>";
            echo "<th>Quantit&agrave;</th>";
            echo "<th>Descrizione</th>";
            echo "<th>Immagini</th>";
            echo "</tr>"; 
        while($row = $result->fetch_assoc()) {
            $pk=$row['Id'];
            echo "<tr>\n";
                echo "<td align='center'>".$row["Categoria"]."</td>\n";
                echo "<td align='center'>".$row["SottoCategoria"]."</td>\n";
                echo "<td align='center'>".$row["Code"]."</td>\n";
                echo "<td align='center'>".$row["Articoli"]."</td>\n";
                echo "<td align='center'>".$row["Prezzo"]."€</td>\n";
                echo "<td align='center'>".$row["Quantità"]."</td>\n";
                echo "<td align='center'>".$row["Descrizione"]."</td>\n";
               echo "<td align='center'>" . "<a href='http://frankmoses.altervista.org/INFORMATICA/wapp/ToPlay/img/upload/articolo_$pk.png'> "."<img class='comando' src='img/upload/articolo_$pk.png'></a>"."</td>";
               echo "</tr>";
           // echo "</tr>";
        }
        echo "</table><br>";
        //echo $msg;
    } 
    else {
            echo "Nessun risultato";
        }    
   	   
	echo $msg."<br>";
   $CN->close();
?>
</body>
</html> 