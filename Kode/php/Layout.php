<?php
require 'config.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_COOKIE["user"])) {
			$bruker = $_COOKIE["user"];
			$dato = $tid = "";
			$ant = $rom = 0;
			$proj = false;
			$dato = test_input($_POST["bday"]);
			$tid1 = test_input($_POST["from_time"]);
			$tid2 = test_input($_POST["to_time"]);
			$ant = test_input($_POST["quantity"]);
			$rom = test_input($_POST["rom"]);
			//echo $bruker . "<br>" . $dato . "<br>" . $tid1 . "<br>" . $tid2 . "<br>" . $ant . "<br>" . $rom . "<br>";
			if ($_POST["Prosjektor"] == "Ja") {
				//echo "Prosjektor ja<br>";
				$prosjektor = 1;
			} else {
				//echo "Prosjektor nei<br>";
				$prosjektor = 0;
			}
			$sql = $database->prepare("SELECT antall, dato, fratid, tiltid, prosjektor FROM reservasjon where romnummer = $rom AND dato = '$dato';");
			$sql->setFetchMode(PDO::FETCH_OBJ);
			$sql->execute();
			$count = 0;
			while ($test = $sql->fetch()) {
				if (strtotime($tid1) <= strtotime($test->fratid) && strtotime($tid2) <= strtotime($test->tiltid) && strtotime($test->fratid) <= strtotime($tid2) || strtotime($tid1) >= strtotime($test->fratid) && strtotime($tid2) >= strtotime($test->tiltid) && strtotime($test->tiltid) >= strtotime($tid1) || strtotime($tid1) >= strtotime($test->fratid) && strtotime($tid2) <= strtotime($test->tiltid) || strtotime($tid1) <= strtotime($test->fratid) && strtotime($tid2) >= strtotime($test->tiltid)) {
					$count += $test->antall;
					if ($ant + $count > 4) {
						echo "Rommet har ikke plass! <br>";
						$rom = "";
					}
					if ($prosjektor == 1 && $test->prosjektor == 1) {
						echo "Noen har allerede reservert prosjektoren på denne tiden<br>";
						$tid1 = "";
					}
				}
			}
			if ($dato == "" || $tid1 == "" || $tid2 == "" || $rom == 0 || $ant == 0 || $bruker == "") {
				echo "Noe gikk galt!";
			} else {
				if ($tid1 < $tid2) {
					if ($dato > date("Y-m-d") || $dato == date("Y-m-d") && strtotime($tid1) > time()) {
						$sql = $database->prepare("INSERT INTO reservasjon (romnummer, dato, fratid, tiltid, student, antall, prosjektor) VALUES ('$rom', '$dato', '$tid1', '$tid2', '$bruker', '$ant', $prosjektor);");
						$sql->execute();
						header("refresh: 1; url=../html/Layout.html");
					} else {
						echo "Bookingen er for tidlig.";
					}
				} else {
					echo "Start-tiden er etter slutt-tiden!";
				}
			}
		} else {
			echo "Du er ikke logget inn, du vil bli sendt til login-siden om noen litt. <br>";
			header("refresh: 5; url=login.php");
			echo "<br><a href='login.php'>Klikk her</a> om du ikke blir sendt automatisk.";
		}
		echo "<br><a href='../html/Layout.html'>Tilbake!</a>";
	}
?>