<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php
	require 'config.php';
	$studentnummer = $passord1 = $passord2 = "";
	$studFeil = $passFeil1 = $passFeil2 = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["studentnummer"])) {
			$studFeil = "Obligatorisk!";
		} else {
			$studentnummer = test_input($_POST["studentnummer"]);
			echo $studentnummer;
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
			echo "Bruker registrert.";
			sleep(3);
			header("Location: login.php");
		} else {
			$passFeil1 = "Passordene må være like.";
		}
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" accept-charset="utf-8">
	Studentnummer: <input type="text" name="studentnummer"><span class="error">* <?php echo $studFeil; ?><br><br>
	Passord: <input type="text" name="passord1"><span class="error">* <?php echo $passFeil1; ?><br><br>
	Skriv passord på nytt: <input type="text" name="passord2"><span class="error">* <?php echo $passFeil2; ?><br><br>
	<input type="submit">
	</form>

</body>
</html>
