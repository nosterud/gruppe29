<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php
	require 'config.php';
	$brukernavn = $passord = $bruker = "";
	$brukerFeil = $passFeil = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["brukernavn"])) {
			$brukerFeil = "Obligatorisk!";
		} else {
			$brukernavn = test_input($_POST["brukernavn"]);
		}
		if (empty($_POST["passord"])) {
			$passFeil = "Obligatorisk!";
		} else {
			$passord = test_input($_POST["passord"]);
		}
		if ($brukerFeil == "" && $passFeil == "") {
			$sql = $database->prepare("SELECT * FROM bruker WHERE brukernavn='$brukernavn' AND passord='$passord';");
			$sql->setFetchMode(PDO::FETCH_OBJ);
			$sql->execute();
			while ($testvar = $sql->fetch()) {
				$bruker = $testvar->brukernavn;
			}
			if ($bruker == "") {
				echo "Ingen bruker";
			} else {
				setcookie("user", $bruker, time()+ (86400 * 30), "/");
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
	Brukernavn: <input type="text" name="brukernavn"><span class="error">* <?php echo $brukerFeil; ?><br><br>
	Passord: <input type="text" name="passord"><span class="error">* <?php echo $passFeil; ?><br><br>
	<input type="submit">
</form>
<br>
<form action="registrer.php"><input value="Registrer deg" type="submit"></form>

</body>
</html>
