<?php 
session_start();
$dbh = new PDO("mysql:host=".$_SESSION["DB_HOST"].";dbname=".$_SESSION["DB_NAME"], $_SESSION["DB_USER"], $_SESSION["DB_PASS"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
include('../includes/functions.php');
	$keys= implode (", ", array_slice(array_keys($_REQUEST),0,-2));
	$args = array_slice($_REQUEST, 0, -2);
	foreach ($args as &$value) {
    	$value = "'".$value."'";
	}
	unset($value);
	$args= implode (", ", $args);
	$sql = "INSERT INTO {$_SESSION['TB_NAME']} ({$keys}) VALUES ({$args})";
	print_r($sql);
	$insert = pdoDB($dbh,$sql)->rowcount();
	header('location:../table.php?name='.$_SESSION['TB_NAME']);
	exit;

?>