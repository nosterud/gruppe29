<?php
require 'config.php';
$nummer = test_input($_GET["nummer"]);
$sql = $database->prepare("SELECT romnummer, dato, fratid, tiltid, student, prosjektor, antall as num FROM reservasjon WHERE romnummer = '$nummer' ORDER BY dato, fratid ASC;");
$sql->setFetchMode(PDO::FETCH_OBJ);
$sql->execute();
$count = 0;
while ($item = $sql->fetch()) {
	if ($item->dato == date("Y-m-d")) {
		if (strtotime($item->fratid) < time() && time() < strtotime($item->tiltid)) {
			$count += $item->num;
			if ($item->prosjektor == 1) {
				echo "<p>Prosjektoren er opptatt! <br /></p>";
			}
		}
	}
}
echo "<p>Rom $nummer</p>";
echo "<p>$count / 4</p>";
if ($count == 4) {
	echo "<style>body{background-color:red;}</style>";
} else if($count > 0) {
	echo "<style>body{background-color:yellow;}</style>";
}
?>
