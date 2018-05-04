<?php 

class Sql {
    
	const HOSTNAME = "localhost";
	const USERNAME = "root";
	const PASSWORD = "";
	const DBNAME = "fullcalender";

	private $conn;

	public function __construct()
	{
		$this->conn = new \PDO(
			"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME,Sql::USERNAME,Sql::PASSWORD
		);
	}
	//========================================================
	// Seta os parametros percorendo os dados com um array
	// e exucutando a chamda bindParam()
	//=======================================================	
	private function setParams($statement, $parameters = array())
	{
		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);
		}
	}
	
	//===================================================
	// prepara a query e passa para o bindParam()
	//===================================================
	private function bindParam($statement, $key, $value)
	{
		$statement->bindParam($key, $value);
	}
	//==================  EXECUTA  ======================
	// faz o prepare, chama o setParams() que é bindParam
	// e depois executa
	//===================================================
	public function query($rawQuery, $params = array())
	{
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
	}
	//=================  SELECIONA  ====================
	// seleciona os dados em forma de array associativo
	//===================================================
	public function select($rawQuery, $params = array()):array
	{
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}