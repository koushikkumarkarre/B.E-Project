<?php 
$db_host="localhost";
$db_name="cconsultdb";
$db_username="root";
$db_passowrd="";
$conn=mysql_connect($db_host,$db_username,$db_passowrd) or die("Can't Connect");
$db=mysql_select_db("projcrypt",$conn) or die("Can't Connect to db");
?>