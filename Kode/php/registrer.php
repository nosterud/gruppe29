<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/login.css">
<link rel="stylesheet" type="text/css" href="../css/register.css">
<?php
	require 'config.php';
	include 'header.php';
	$studentnummer = $passord1 = $passord2 = "";
	$studFeil = $passFeil1 = $passFeil2 = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["studentnummer"])) {
			$studFeil = "Obligatorisk!";
		} else {
			$studentnummer = test_input($_POST["studentnummer"]);
		}
		if (empty($_POST["passord1"])) {
			$passFeil1 = "Obligatorisk!";
		} else {
			$passord1 = test_input($_POST["passord1"]);
		}
		if (empty($_POST["passord2"])) {
			$passFeil2 = "Obligatorisk!";
		} else {
			$passord2 = test_input($_POST["passord2"]);
		}
		if (is_numeric($studentnummer) && $passord1 == $passord2 && $passord1 != "" && $passord2 != "" ) {
			$sql = $database->prepare("INSERT INTO bruker (studentnummer, passord) VALUES ('$studentnummer', '$passord1');");
			$sql->execute();
			echo "Bruker registrert, du vil bli sendt tilbake til login siden.";
			header("refresh: 5; url=login.php");
		} else {
			$passFeil1 = "Ikke lik.";
		}
	}
?>
</head>
<body>

<section class="wrapper">
	<div id="Logo"><img src="../../Bilder/westerdals.png">

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" accept-charset="utf-8">
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
		<td><input id="passord" type="password" name="passord1"><span class="error">*</span></td>
	</tr>
	<tr>
		<td><span class="error"><?php echo "$passFeil1"; ?></span></td>
	</tr>
	<br><br>
	<tr>
		<td>Bekreft passord:</td>
		<td><input id="passord2" type="password" name="passord2"><span class="error">*</span></td>
	</tr>
	<tr>
		<td><span class="error"><?php echo "$passFeil2"; ?></span></td>
	</tr>
	<br><br>
	<tr>
		<td><input type="submit">
		</td>
	</tr>
</table>
</form>
</section>

<img id="pointer" src="../../Bilder/pointer.jpg">

</body>
</html>
