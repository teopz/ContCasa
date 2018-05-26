<?php
	include_once 'funzioni.php';
	$database=connect();
	if(!isset($_POST['id_conto']) or !isset($_POST['path']) or $_POST['path']=="" or $_POST['path']=="Inserisci il percorso"){
		header("Location:index.php");
	}
?>
<html>
	<head>
		<title>Contabilità</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" title="style" href="style.css" />
	</head>
	<body>
    	<div id="header" class="header">
			<div>
			<br/>
				<div class="mainTitle">
					<h2><i>Contabilità</i></h2>
				</div>
			</div>
		</div>
		<?php
			echo "Dati inseriti dal file ".$_POST['path']." al conto ".$_POST['id_conto']."";
			echo "<table><tr><th>DATA</th><th>CAUSALE</th><th>TIPO_SPESA</th><th>IMPORTO</th></tr>";
			if ($result=$database->query("SELECT 
											DATA_CONTABILE, 
											IMPORTO, 
											CAUSALE, 
											TIPO_SPESA 
										FROM MOVIMENTO M 
											INNER JOIN TIPO_SPESA T 
											ON M.ID_TIPO_SPESA=T.ID_SPESA 
										WHERE ID_CONTO=".$_POST['id_conto']."
										ORDER BY DATA_CONTABILE DESC LIMIT 25
			",MYSQLI_STORE_RESULT)){
				while ($row=$result->fetch_array(MYSQLI_ASSOC)){
					printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>"
					,$row['DATA_CONTABILE'],$row['CAUSALE'],$row['TIPO_SPESA'],$row['IMPORTO']);
				}
				$result->close();
			}
			echo "</table>";
			/*
			if(isset($_POST['id_conto'])){
				echo $_POST['id_conto'];
			} 
		?>
		
		<?php
			$csv = array_map('str_getcsv', file('c:\data.csv'));
			echo $csv;*/
		?>
	</body>
</html>