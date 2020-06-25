<?php 
session_start();
include('includes/functions.php');
 // if session exists, then make the  input fields uneditable and fill their values. enable "Disconnect" button. Else load the following code, with Disconnect button disabled. 
if(isset($_POST['connect'])) {
	$_SESSION['DB_HOST'] = $_POST['dbhost'];
	$_SESSION['DB_USER'] = $_POST['dbuname'];
	$_SESSION['DB_PASS'] = $_POST['dbpass'];
	$_SESSION['DB_NAME'] = $_POST['dbname'];
}
if(isset($_GET['utn']))
{
	unset($_SESSION['TB_NAME']);
}
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
	<?php include('includes/header.php');	
		if(strlen($_SESSION['DB_HOST']) != 0) { 
			try
			{
			$dbh = new PDO("mysql:host=".$_SESSION["DB_HOST"].";dbname=".$_SESSION["DB_NAME"], $_SESSION["DB_USER"], $_SESSION["DB_PASS"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			}

			catch (PDOException $e)
			{
			echo "<b> Something is wrong! press Disconnect button and try again</b> <br> <br> more info on the error: <br>";
			exit("Error: " . $e->getMessage()); 
			}
		$sql= "SHOW TABLES FROM ".$_SESSION['DB_NAME'];
		$result = pdoDB($dbh,$sql)->fetchall(PDO::FETCH_OBJ); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-8 mx-auto">
					<h4 class="text-center">Tables List</h4>
					<div class="list-group"> <?php
						$name= "Tables_in_".$_SESSION['DB_NAME']; 
						foreach($result as $row) {
						echo "<a href='../table.php?name=".$row->$name."' class=' text-center list-group-item list-group-item-action'>Edit table : ".$row->$name." </a>";
						}
					?></div>
				</div>
			</div>
		</div>
	<?php } else { ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-8 mx-auto text-sm-center">
				<h1 class="mt-5"> Tables - The PHPonly <br>MySQL database editor </h1>
				<h4 class="mt-5">Disclaimer:</h3>
				<p class="text-sm-left">This project started as a exercise, in order to bring a rusty programmer back to life. The project is based on 2 basic principles: <br> <b>A)</b> To be based only on php/mysql/bootstrap. No custom Javascript is used. <br> <b>B)</b> not to save any user data. All variables used are session variables, and when you Disconnect ,session is destroyed. <br><br>
				Have fun! </p>
				<h4>Todo List:</h4>
				<p>error manipulation. Fix ugly error when you insert wrong credentials. </p>
				<p>pagination on tables</p>
			</div>
		</div>
	</div>


<?php	} ?>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	</body>
</html>
