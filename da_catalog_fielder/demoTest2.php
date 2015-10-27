<html>
<head><title>Eve Fielder Library Test</title>
<link href="../da_catalogLib/2col_leftNav.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #333333}
body {
	background-color: #FFFBEC;
}
.style2 {
	font-size: large;
	font-weight: bold;
}
.style5 {color: #333333; font-weight: bold; }
-->
</style>

</head>
<body>

<?php

//include the login file - ISSRDA_login.php
	// data archive in-house login
include("../da_catalogLib/ISSRDA_login.php");

// Define configuration
define("DB_HOST", $db_host);
define("DB_USER", $db_username);
define("DB_PASS", $db_password);
define("DB_NAME", $db_name);

/**
 * define autoloader
 *  @parm string class name
 */

function __autoload($class_name) {
	echo 'class.' . $class_name . '.php<br>';
	include 'class.' . $class_name . '.php';
}


$testThing = new testClass();
$testThing->someString = "Hello Objects!";

var_dump($testThing);

echo "<br><br>" . $testThing->getString();

//
?>

<h2>Instantiating Address</h2>
test<br>
</body></html>