<?php 
session_start();
if(strlen($_SESSION['DB_HOST'])==0)
	{	
	header('location:../index.php');
	}
else
{
 $dbh = new PDO("mysql:host=".$_SESSION["DB_HOST"].";dbname=".$_SESSION["DB_NAME"], $_SESSION["DB_USER"], $_SESSION["DB_PASS"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
include('includes/functions.php');
if(!isset($_SESSION["TB_NAME"])) {
	$_SESSION['TB_NAME'] = $_GET['name'];
}

//Vriskoume posa pedia exei o pinakas mas
$sql= "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = ? AND table_name = ? ";
$result = pdoDB($dbh,$sql,[$_SESSION['DB_NAME'],$_SESSION['TB_NAME']])->fetch();
$columncount = $result[0];
//Vriskoume to onoma tis kathe stilis tou pinaka (mysqlonly solution)
$sql = "DESCRIBE ".$_SESSION['TB_NAME'];
$result1 = pdoDB($dbh,$sql)->fetchall(PDO::FETCH_COLUMN);
//Fernoume ta data tou pinaka
$sql = "SELECT * FROM ".$_SESSION['TB_NAME'];
$result = pdoDB($dbh,$sql)->fetchAll(PDO::FETCH_OBJ); 
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<title>Tables-a php only editor</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
	<?php include('includes/header.php');	?>
	<a href="../index.php?utn=1" class="btn btn-info">Back to table list</a>
<table class="table table-bordered table-sm"> 
<thead>
	<tr class="text-sm-center text-uppercase">
	<?php
//Gia kathe stili tou pinaka dimiourgoume to heading
		for($x = 0; $x < $columncount; $x++){ 
			echo "<th>".$result1[$x]."</th>";	
	}

 ?>	
<th> action </th>
</tr>
</thead>
<tbody> 
 <?php
//Gia kathe grammi tou pinana fernoume ta antistoixa data :".$row->$rowtoget2."
foreach($result as $row) { ?>
	<tr>
	<form method="post" action="../includes/edit.php">
	 <?php
	for($x = 0; $x < $columncount; $x++){
		$rowtoget = $result1[$x];
		$rowtoget2 = $result1['0'];
		echo "<td><input class='form-control no-border' name='".$result1[$x]."' value='".$row->$rowtoget."'' ></td> ";
	} 	?>
	    <input type="hidden" name="rowid" value="<?php $rowtoget4 = $result1[0]; echo $row->$rowtoget4;?>">
	    <td><input type="submit" class="btn btn-sm btn-info" name="upd" value="Upd"><a href="../includes/delete.php?tablename=<?php echo $tablename; ?>&id=<?php $rowtoget3 = $result1[0]; echo $row->$rowtoget3; echo "&idcolumnname=".$rowtoget3 ; ?>" class="btn btn-sm btn-danger">Del</a></td> 
	<input type="hidden" name="tablename" value="<?php echo $tablename; ?>">
	<input type="hidden" name="idcolumnname" value="<?php echo $result1[0];?>"> 
	</form>
	</tr>
<?php 
}
?>
	<form method="post" action="../includes/insert.php" id="insertform">
	<tr class="alert-info"> <?php
	for($x = 0; $x < $columncount; $x++){
		echo "<td><input class='form-control no-border' name='".$result1[$x]."'></td>";
	}
	?>
	<td><button type="submit" form="insertform" class="btn btn-sm btn-success">Add</button></td>
	</tr> 
	<input type="hidden" name="tablename" value="<?php echo $tablename; ?>">
	<input type="hidden" name="idcolumnname" value="<?php $rowtoget3 = $result1[0]; echo $rowtoget3; ?>">
	</form>
</tbody>
</table>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>

<?php } ?>