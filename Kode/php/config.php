<?php

$db_host = "127.0.0.1";
$db_name = "rom";
$db_user = "root";
$db_pass = "";

$database = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
