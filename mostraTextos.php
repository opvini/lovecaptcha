<?php

$con = mysql_connect("localhost", "root","");
mysql_select_db("lovecaptcha", $con);

$SQL = mysql_query("SELECT * FROM captchas WHERE id <= 2566;", $con);
while($row = mysql_fetch_object($SQL)) echo $row->texto.". ";

mysql_close($con);

?>