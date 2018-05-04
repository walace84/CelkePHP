<?php


	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	$dbname = "fullcalender";

	$conn = new mysqli($servidor, $usuario, $senha, $dbname);

	if ($conn->connect_error) {
		echo "Error: " . $conn->connect_error;
	}



	

