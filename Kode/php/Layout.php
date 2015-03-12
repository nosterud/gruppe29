<?php
require 'config.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_COOKIE["user"])) {
			$bruker = $_COOKIE["user"];
			$dato = $tid = "";
			$ant = $rom = 0;
			$proj = false;
			$dato = $_POST["bday"];
			$tid1 = $_POST["from_time"];
			$tid2 = $_POST["to_time"];
			$ant = $_POST["quantity"];
			$rom = $_POST["rom"];
			echo $bruker . "<br>" . $dato . "<br>" . $tid1 . "<br>" . $tid2 . "<br>" . $ant . "<br>" . $rom . "<br>";
			if ($_POST["Prosjektor"] == "Ja") {
				echo "Prosjektor ja<br>";
				$prosjektor = true;
			} else {
				echo "Prosjektor nei<br>";
				$prosjektor = false;
			}
			if ($tid1 < $tid2) {
				if ($dato > date("Y-m-d") || $dato == date("Y-m-d") && strtotime($tid1) > time()) {
					$sql = $database->prepare("INSERT INTO reservasjon (romnummer, dato, fratid, tiltid, student, prosjektor) VALUES ('$rom', '$dato', '$tid1', '$tid2', '$bruker', $prosjektor);");
					$sql->execute();
				} else {
					echo "DATOEN ER FEIL";
				}
			} else {
				echo "TIDEN ER FEIL!";
			}
		} else {
			header("Location: login.php");
		}
	}
?>