<?php
class ContatoTicket{

/**
  *
  * Function to get the contacts from database 
  *	param {String}: code to filter the query by type of contact
  *
 **/
	public function getDataTable($assunto) {
		//LINK QUEBRADASSO
		//$link = new mysqli('mysql.hostinger.com.br', 'u832569433_arpe', 'JaQs1Jf8nyBn', 'u832569433_padar');
		$link = new mysqli('localhost', 'root', '', 'dbPadaria');
		$query = "SELECT * FROM `contatos` WHERE `CDTIPOCON` = '$assunto' ORDER BY `NRSEQUE` DESC";
		$query = mysqli_query($link, $query);
		$result = [];
	    while ($row = mysqli_fetch_array($query)) { // fetches a result row as an  array
	        //create an Object with each row returned
	        $object = new stdClass();
	        $object->CDTIPOCON = $row['CDTIPOCON'];
	        $object->NRSEQUE = $row['NRSEQUE'];
	        $result [] = $object;
	    }
    	mysqli_close($link); // close connection with database
    	header('Content-Type: application/json');
    	echo json_encode($result);
	}	

	public function saveContato($row) {
		$this->geraCodigo($row['ASSUNTO'], $row);
	}


	//----------------------------------------------------------------------------//
	protected function geraCodigo($primaryKey) {
		
	//$link = new mysqli('mysql.hostinger.com.br', 'u832569433_arpe', 'JaQs1Jf8nyBn', 'u832569433_padar');
		$link = new mysqli('localhost', 'root', '', 'dbPadaria');
		$queryContato = "SELECT * FROM newcode WHERE TABLEPK = '$primaryKey' ORDER BY NRSEQUENCIAL ASC";
		$resultTipoContato = mysqli_query($link, $queryContato); 

		$query = "SELECT * FROM newcode WHERE TABLEPK = 'CONTATO'";
		$resultado = mysqli_query($link, $queryContato);

		$sequencialMax = 0000000000;
		$sequencialMaxContato = 0000000000;
		$stop = false; 
		foreach ($resultTipoContato as $key => $value) {
			if($value['NRSEQUENCIAL'] > $sequencialMaxContato && $stop === false) {
				if($value['NRSEQUENCIAL'] - 1 === $sequencialMaxContato) {
					$sequencialMaxContato = $value['NRSEQUENCIAL'];
				}
				else {
					$sequencialMaxContato = $value['NRSEQUENCIAL'] + 1;
					$stop = true;
				}
			}
		}
		foreach ($resultado as $key => $value) {
			if($value['NRSEQUENCIAL'] > $sequencialMax && $stop === false) {
				if($value['NRSEQUENCIAL'] - 1 === $sequencialMax) {
					$sequencialMax = $value['NRSEQUENCIAL'];
				}
				else {
					$sequencialMax = $value['NRSEQUENCIAL'] + 1;
					$stop = true;
				}
			}
		}
		$sequencialContato = $sequencialMaxContato + 1;
		$sequencial = $sequencialMax + 1;

		$insert = "INSERT INTO newcode(TABLEPK, NRSEQUENCIAL) VALUES ('CONTATO', '$sequencialContato'" or die("Error in the consult.." . mysqli_error($link)); 
		$resultTipoContato = mysqli_query($link, $queryContato);
		$insertContato = $this->getQuery('INSERENEWCODEPARAM'); 
		$resultTipoContato = mysqli_query($link, $queryContato); 

	}

	protected function getQuery($nome) {
		$query = array(
			"INSERENEWCODEPARAM" => "INSERT INTO newcode(TABLEPK, NRSEQUENCIAL) VALUES ('$primaryKey', '$sequencial'" or die("Error in the consult.." . mysqli_error($link))
		);
		return $query[$nome];
	}

}
?>