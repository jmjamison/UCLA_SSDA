<html>
<head><title>Class Test #3</title>
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">


</head>
<body>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

	error_reporting(E_ALL);
ini_set('display_errors', 1);

	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog/";	
	include("SSDA_librarydatabase.php");
	include "class.Database.php";
	include "class.testClass.php";
	
// Define configuration
define("DB_HOST", $db_host);
define("DB_PORT", $db_port);
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


$testThing = new testClass("foo");
$testThing->someString = "Hello Objects!";

var_dump($testThing);

echo "<br><br>" . $testThing->getString();

//
?>

<h2>Instantiating Address</h2>
test<br>
</body></html>