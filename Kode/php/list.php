<?php
require 'config.php';

$sql = $database->prepare("SELECT romnummer, dato, fratid, tiltid FROM reservasjon ORDER BY dato, fratid ASC;");
$sql->setFetchMode(PDO::FETCH_OBJ);
$sql->execute();
echo "<table style='width:300'>";
echo "<tr><th>Rom</th><th>Dato</th><th>Fra</th><th>Til</th></tr>";
while($item = $sql->fetch()) {
	if (date("Y-m-d") < $item->dato || date("Y-m-d") == $item->dato && time() < strtotime($item->fratid)) {
		echo "<tr><td>$item->romnummer</td><td>$item->dato</td><td>$item->fratid</td><td>$item->tiltid</td></tr>";
	}
}
echo "</table>";

?>
