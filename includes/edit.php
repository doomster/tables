<?php 
session_start();
$dbh = new PDO("mysql:host=".$_SESSION["DB_HOST"].";dbname=".$_SESSION["DB_NAME"], $_SESSION["DB_USER"], $_SESSION["DB_PASS"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
include('../includes/functions.php');
	$args= array_slice($_REQUEST, 0, -4);
	$keys= array_slice(array_keys($_REQUEST),0,-4);
	foreach ($keys as &$value) {
		$value= $value."=:".$value;
	}
	unset($value);
	$keys= implode (", ", $keys);
	$sql = "UPDATE {$_SESSION['TB_NAME']} SET {$keys} WHERE {$_REQUEST['idcolumnname']} = {$_REQUEST['rowid']}";
	$update = pdoDB($dbh,$sql,$args)->rowcount();
	header('location:../table.php?name='.$_SESSION['TB_NAME']);
	exit;
?>