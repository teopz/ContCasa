<?php
	function connect(){
		$database = new mysqli("localhost", "root", "","contabilita");
		if($database->connect_errno){
			printf ("Non è stato possibile connettersi al DB: %s\n", $database->connect_error);
			exit();
		}
		return $database;
	};
	
	function estrai_movimenti($id_conto, $anno, $mese, $tipo_spesa, $mag, $min, $database){
		$str_anno="";
		$str_mese="";
		$str_spesa="";
		$str_mag="";
		$str_min="";
		if(isset($id_conto)){
			if(isset($anno) and $anno<>"" and $anno<>"Tutto"){$str_anno=" AND DATE_FORMAT(DATA_CONTABILE,'%Y')=".$anno;}
			if(isset($mese) and $mese<>"" and $mese<>"Tutto"){$str_mese=" AND DATE_FORMAT(DATA_CONTABILE,'%m')=".$mese;}
			if(isset($tipo_spesa) and $tipo_spesa<>"" and $tipo_spesa<>"Tutto"){$str_spesa=" AND TIPO_SPESA='".$tipo_spesa."'";}
			if(isset($mag) and $mag<>""){$str_mag=" AND IMPORTO>".$mag;}
			if(isset($min) and $min<>""){$str_min=" AND IMPORTO<".$min;}

			$query="SELECT 
						DATA_CONTABILE, 
						IMPORTO, 
						CAUSALE, 
						TIPO_SPESA 
					FROM MOVIMENTO M 
						INNER JOIN TIPO_SPESA T 
						ON M.ID_TIPO_SPESA=T.ID_SPESA 
					WHERE ID_CONTO=".$id_conto."".$str_anno."".$str_mese."".$str_spesa."".$str_mag."".$str_min."
					ORDER BY DATA_CONTABILE DESC";
					
			echo "<table><tr><th>DATA</th><th>CAUSALE</th><th>TIPO_SPESA</th><th>IMPORTO</th></tr>";
			if ($result=$database->query($query,MYSQLI_STORE_RESULT)){
				while ($row=$result->fetch_array(MYSQLI_ASSOC)){
					printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>"
					,$row['DATA_CONTABILE'],$row['CAUSALE'],$row['TIPO_SPESA'],$row['IMPORTO']);
				}
				$result->close();
			}
			echo "</table>";
		}
	};
?>