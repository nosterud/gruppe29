<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/Login.css">
<?php
	require 'config.php';
	require 'header.php';
	$studentnummer = $passord = $bruker = "";
	$studFeil = $passFeil = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["studentnummer"])) {
			$studFeil = "Obligatorisk!";
		} else {
			$studentnummer = test_input($_POST["studentnummer"]);
		}
		if (empty($_POST["passord"])) {
			$passFeil = "Obligatorisk!";
		} else {
			$passord = test_input($_POST["passord"]);
		}
		if ($studFeil == "" && $passFeil == "") {
			$sql = $database->prepare("SELECT * FROM bruker WHERE studentnummer='$studentnummer' AND passord='$passord';");
			$sql->setFetchMode(PDO::FETCH_OBJ);
			$sql->execute();
			while ($testvar = $sql->fetch()) {
				$bruker = $testvar->studentnummer;
			}
			if ($bruker == "") {
				echo "Ingen bruker";
			} else {
				setcookie("user", $bruker, time() + 3600, "/");
				header("Location: ../html/Layout.html");
			}
		}
	}
?>
</head>
<body>

<section class="wrapper">
	<div id="Logo"><img src="../../Bilder/westerdals.png">


<form id="login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" accept-charset="utf-8">
<table>
	<tr>
		<td>Studentnummer:</td>
		<td><input type="text" name="studentnummer"><span class="error">*</span></td>
	</tr> 
	<tr>
		<td><span class="error"><?php echo "$studFeil"; ?></span></td>
	</tr>
	<br><br>
	<tr>
		<td>Passord:</td>
		<td><input id="passord" type="password" name="passord"><span class="error">*</span></td>
	</tr> 
	<tr>
		<td><span class="error"><?php echo "$passFeil"; ?></span></td>
	</tr>
	<br><br>
	<tr>
		<td><input type="submit"></td>
	</tr>
</table>
</form>
<br>
<form action="registrer.php"><input value="Registrer deg" type="submit"></form>



</section>	
</body>
</html>
