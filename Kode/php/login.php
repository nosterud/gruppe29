<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php
	require 'config.php';
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
				header("Location: loggedin.php");
			}
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
	Passord: <input type="text" name="passord"><span class="error">* <?php echo $passFeil; ?><br><br>
	<input type="submit">
</form>
<br>
<form action="registrer.php"><input value="Registrer deg" type="submit"></form>

</body>
</html>
