<?php 
session_start();
$dbh = new PDO("mysql:host=".$_SESSION["DB_HOST"].";dbname=".$_SESSION["DB_NAME"], $_SESSION["DB_USER"], $_SESSION["DB_PASS"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
include('../includes/functions.php');
	$tablename = $_SESSION['TB_NAME'];
	$idcolumnname = $_REQUEST['idcolumnname'];
	$id = $_REQUEST['id'];
	$sql = "DELETE FROM {$tablename} WHERE {$idcolumnname} = ?";
	$result = pdoDB($dbh,$sql,[$id])->rowcount();
header('location:../table.php?name='.$_SESSION['TB_NAME']);
	exit;
?>