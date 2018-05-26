<?php
	include_once 'funzioni.php';
	$database=connect();
?>

<html>
	<head>
		<title>Contabilità</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" title="style" href="style.css" />
	</head>
	<body>
    	<div id="header" class="header">
			<div class="mainTitle">
				<h2><i>Contabilità</i></h2>
			</div>
		</div>
		<input type="button" class="menubuttons" value="Visualizza" onclick="document.location='visualizza.php'"></input>
		<form method="post" action="carica.php">
		<input type="text" class="text" name="path" placeholder="Inserisci il percorso"></input>
		<?php
			if (!isset($_POST['path']) or $_POST['path']=="" or $_POST['path']=="Inserisci il percorso"){
				echo "Inserisci il percorso del file dati da caricare</br>";
			}
			
			echo "<ul>";
			if ($result=$database->query("SELECT * FROM CONTO",MYSQLI_STORE_RESULT)){
				while ($row=$result->fetch_array(MYSQLI_ASSOC)){
					printf("<li><input type=\"radio\" name=\"id_conto\" value=".$row['ID_CONTO']."></input> ID: %s, Banca: %s, Tipo Conto: %s, Intestatario: %s \r\n</li>"
					,$row['ID_CONTO'],$row['BANCA'],$row['TIPO_CONTO'],$row['INTESTATARIO']);
				}
				$result->close();
			}
			echo "</ul>";
			if (!isset($_POST['id_conto'])){
				echo "Seleziona il conto su cui caricare i dati</br>";
			}
		?>
		
		<?php/*
			$csv = array_map('str_getcsv', file('c:\data.csv'));
			echo $csv;*/
		?>
		<input type="submit" value="Carica" class="button"></input>
		</form>
	</body>
</html>