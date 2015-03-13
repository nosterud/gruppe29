<?php
require 'config.php';
if(isset($_COOKIE["user"])) {
	$bruker = $_COOKIE["user"];
}

echo "Logged in as $bruker";

?>