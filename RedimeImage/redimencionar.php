<?php

$altura  = "200";
$largura = "300";

echo "Altura pretendida: $altura - largura pretendida: $largura <br>";


switch ($_FILES['arquivo']['type']) {
	case 'image/jpg':
	case 'image/jpeg':	

		$image_temporaria = imagecreatefromjpeg($_FILES['arquivo']['tmp_name']);

		$largura_original = imagesx($image_temporaria);
		$altura_original = imagesy($image_temporaria);

		echo "Altura original: $altura_original - largura original: $largura_original <br>";

		$nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $largura);
		$nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $altura);

		$image_redimencionada = imagecreatetruecolor($nova_largura, $nova_altura);
		imagecopyresampled($image_redimencionada, $image_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

		imagejpeg($image_redimencionada, 'arquivo/' . $_FILES['arquivo']['name']);

		echo "<img src='arquivo/" . $_FILES['arquivo']['name'] . " '> ";

		break;

	case 'image/png':
 		$image_temporaria = imagecreatefrompng($_FILES['arquivo']['tmp_name']);

 		$largura_original = imagesx($image_temporaria);
		$altura_original = imagesy($image_temporaria);

		echo "Altura original: $altura_original - largura original: $largura_original <br>";

		$nova_largura = $largura ? $largura : floor(($largura_original / $altura_original) * $largura);
		$nova_altura = $altura ? $altura : floor(($altura_original / $largura_original) * $altura);

		$image_redimencionada = imagecreatetruecolor($nova_largura, $nova_altura);
		imagecopyresampled($image_redimencionada, $image_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

		imagepng($image_redimencionada, 'arquivo/' . $_FILES['arquivo']['name']);

		echo "<img src='arquivo/" . $_FILES['arquivo']['name'] . " '> ";

		break;	
	
	default:
			echo "Essa imagem não é válida!";
		break;

}








