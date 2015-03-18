<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
			$passFeil1 = "Passordene må være like.";
		}
	}
?>
</head>
<body>

<section class="wrapper">
	<div id="Logo"><img src="../../Bilder/westerdals.png">

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" accept-charset="utf-8">
	Studentnummer: <input type="text" name="studentnummer"><span class="error">* <?php echo $studFeil; ?></span><br><br>
	Passord: <input id="passord" type="password" name="passord1"><span class="error">* <?php echo $passFeil1; ?></span><br><br>
	Bekreft passord: <input id="passord2" type="password" name="passord2"><span class="error">* <?php echo $passFeil2; ?></span><br><br>
	<input type="submit">
	</form>

</section>

<img id="pointer" src="../../Bilder/pointer.jpg">

</body>
</html>
