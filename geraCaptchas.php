<?php

set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');

function criaImagem($str, $onde){
	$imagemCaptcha = imagecreatefrompng("images/confCapCad.png") or die("Não foi possível inicializar uma nova imagem");
	$fonteCaptcha = "includes/complementos/fontMy.ttf";
	$corCaptcha = imagecolorallocate($imagemCaptcha,0,0,0);
	 
	$rndA = rand(-7,7);		// -7,7
	$rndS = rand(20,30);	// 20,30
	$rndX = rand(0,20);		// 0,20
	$rndY = 25;				// 25
	
	
	if( strlen($str) >= 4 && strlen($str) <= 6 ) {
		if( $rndA > 0 ) { $rndX = rand(0,120); $rndY = rand(35,50); }
		else 			{ $rndX = rand(0,120); $rndY = rand(25,40); }
	}
	else if( strlen($str) > 6 && strlen($str) <= 8 ) {
		if( $rndA > 0 ) { $rndX = rand(0,80); $rndY = 50; }
		else 			{ $rndX = rand(0,80); $rndY = rand(25,20); }
	}
	else if( strlen($str) > 8 ) {
		if( $rndA > 0 ) { $rndX = rand(0,10); $rndY = 50; }
		else 			{ $rndX = rand(0,10); $rndY = 25; }
	}
	
	
	imagettftext($imagemCaptcha, $rndS, $rndA, $rndX, $rndY, $corCaptcha, $fonteCaptcha, $str);
	
	for($i=1; $i <= rand(3,20); $i++){
		imageline($imagemCaptcha,rand(0,200), rand(0,50), rand(0,200), rand(0,50), $corCaptcha);
	}
	
	imagepng($imagemCaptcha, $onde);
	imagedestroy($imagemCaptcha);
}
 



$fil = "texto.txt";
$arq = fopen($fil, "r");
$res = mb_strtolower(fread($arq, filesize($fil)), "UTF-8");
$res = explode(" ",$res);


$con = mysql_connect("localhost", "root","");
mysql_select_db("lovecaptcha", $con);


for($i = 0; $i < count($res); $i++){
	if( strlen( trim(utf8_decode($res[$i])) ) >= 4){		
		echo $res[$i]." - ". strlen( trim(utf8_decode($res[$i])) ) ."<br>";		
		
		$SQLS = mysql_query("SELECT * FROM captchas WHERE texto = '".utf8_decode($res[$i])."';", $con);
		
		if(mysql_num_rows($SQLS) <= 0){	
			$SQL = mysql_query("INSERT INTO captchas SET texto = '".utf8_decode($res[$i])."', bool_usada = 0;", $con); 
			$id = mysql_insert_id();
		
			$SQL = mysql_query("INSERT INTO link_captcha_livro SET fgk_livro = 1, fgk_captcha = ".$id.";", $con); 
			criaImagem($res[$i], "images/captchas/cpt_".$id.".png");
		}
	}
}

mysql_close($con);

?>