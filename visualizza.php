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
			<div>
			<br/>
				<div class="mainTitle">
					<h2><i>Contabilità</i></h2>
				</div>
			</div>
		</div>
		<form method="post" action="visualizza.php">
		<?php
			//Azzero le variabili per evitare errori a schermo in caso non siano settate
			if(!isset($_POST['id_conto'])){$_POST['id_conto']="";}
			if(!isset($_POST['anno_'.$_POST['id_conto']])){$_POST['anno_'.$_POST['id_conto']]="";}
			if(!isset($_POST['mese_'.$_POST['id_conto']])){$_POST['mese_'.$_POST['id_conto']]="";}
			if(!isset($_POST['tipo_spesa_'.$_POST['id_conto']])){$_POST['tipo_spesa_'.$_POST['id_conto']]="";}
			if(!isset($_POST['mag_'.$_POST['id_conto']])){$_POST['mag_'.$_POST['id_conto']]="";}
			if(!isset($_POST['min_'.$_POST['id_conto']])){$_POST['min_'.$_POST['id_conto']]="";}
			
			$anno=$database->query("SELECT DISTINCT DATE_FORMAT(DATA_CONTABILE,'%Y') AS ANNO, ID_CONTO FROM MOVIMENTO",MYSQLI_STORE_RESULT);
			$mese=$database->query("SELECT DISTINCT DATE_FORMAT(DATA_CONTABILE,'%m' ) AS MESE, ID_CONTO FROM MOVIMENTO ORDER BY DATE_FORMAT(DATA_CONTABILE,'%m') ASC",MYSQLI_STORE_RESULT);
			$tipo_spesa=$database->query("SELECT TIPO_SPESA FROM TIPO_SPESA",MYSQLI_STORE_RESULT);
			$valore_maggiore=0;
			$valore_minore=0;
				
			echo "<table><tr><th>Conto corrente</th><th>Filtro per Anno</th><th>Filtro per Mese</th><th>Filtro per Tipo Spesa</th><th>Filtro per Valore Maggiore</th><th>Filtro per Valore Minore</th></tr>";
			if ($result=$database->query("SELECT * FROM CONTO",MYSQLI_STORE_RESULT)){
				while ($row=$result->fetch_array(MYSQLI_ASSOC)){
					echo "<tr><td><input type=\"radio\" name=\"id_conto\" value=".$row['ID_CONTO']."> Banca:".$row['BANCA'].", Tipo Conto:".$row['TIPO_CONTO'].", Intestatario:".$row['INTESTATARIO']." </input></td>
						<td><select name=\"anno_".$row['ID_CONTO']."\">";
							echo "<option>Tutto</option>";
							$anno->data_seek(0);
							while ($row_select=$anno->fetch_array(MYSQLI_ASSOC)){
								if ($row_select['ID_CONTO']==$row['ID_CONTO']) {echo "<option>".$row_select['ANNO']."</option>";}
							}
					echo "</select></td>
						<td><select name=\"mese_".$row['ID_CONTO']."\">";
							echo "<option>Tutto</option>";
							$mese->data_seek(0);
							while ($row_select=$mese->fetch_array(MYSQLI_ASSOC)){
								if ($row_select['ID_CONTO']==$row['ID_CONTO']) {echo "<option>".$row_select['MESE']."</option>";}
							}
					echo "</select></td>
						<td><select name=\"tipo_spesa_".$row['ID_CONTO']."\">";
							echo "<option>Tutto</option>";
							$tipo_spesa->data_seek(0);
							while ($row_select=$tipo_spesa->fetch_array(MYSQLI_ASSOC)){echo "<option>".$row_select['TIPO_SPESA']."</option>";}
					echo "</select></td>
						<td><input type=\"text\" name=\"mag_".$row['ID_CONTO']."\" placeholder=\"Valori maggiori di\"></input></td>
						<td><input type=\"text\" name=\"min_".$row['ID_CONTO']."\" placeholder=\"Valori minori di\"></input></td></tr>";
				}
				$result->close();
			}
			$anno->close();
			$mese->close();
			$tipo_spesa->close();
			echo "</table>";
		?>
		<input type="submit" value="Esegui Query" class="button"></input>
		</form>
		<?php
			estrai_movimenti(
				$_POST['id_conto'],
				$_POST['anno_'.$_POST['id_conto']],
				$_POST['mese_'.$_POST['id_conto']],
				$_POST['tipo_spesa_'.$_POST['id_conto']],
				$_POST['mag_'.$_POST['id_conto']],
				$_POST['min_'.$_POST['id_conto']], 
				$database
			);
		?>
	</body>
</html>