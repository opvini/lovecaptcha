<?php

set_time_limit(60);
header("Content-type: image/png");

$con = mysql_connect("localhost", "root","");
mysql_select_db("lovecaptcha", $con);

$SQL = mysql_query("SELECT tot_captchas FROM sis_totais;", $con);
$obj = mysql_fetch_object($SQL);

$rnd = rand(1, $obj->tot_captchas);

$arq = fopen("images/captchas/cpt_".$rnd.".png", "r");
$img = fread( $arq, filesize("images/captchas/cpt_".$rnd.".png"));

fclose($arq);
mysql_close($con);

echo $img;

?>