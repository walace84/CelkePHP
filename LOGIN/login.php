<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>Área de login</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	   <link rel="stylesheet" href="css/style.css">

	</head>

	<body class="fundo">

		<div class="container">

		 <div class="login">
		 	<div class="head">
		 	   <h1>Tela de Login</h1>
		 	</div>
		 	
		 	<form action="validaLogin.php" method="POST">
			  <div class="form-group">
			    <label for="usuario">Usuário:</label>
			    <input type="text" class="form-control" name="usuario" autofocus="" required="">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Senha:</label>
			    <input type="password" class="form-control" name="senha" required="">
			  </div>
			  <button type="submit" class="btn btn-primary btn-block">Entrar</button>
			</form> 

		 </div>

		</div>

	</body>

</html>