<?php

set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');

$fil = "texto2.txt";
$arq = fopen($fil, "r");

$fiL = "novoTexto.txt";
$arQ = fopen($fiL, "w");

$res = mb_strtolower(fread($arq, filesize($fil)), "UTF-8");
$str = str_replace(". ", " ", $res);
fwrite($arQ,$str);

fclose($arq);
fclose($arQ);

echo "feito!";

?>