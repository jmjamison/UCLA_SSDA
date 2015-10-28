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
test <br>
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

//include "class.simpleClass.php";
echo "test<br>";

$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
$currentHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
	

echo "test<br>";
	 //$titleList = "select ID, title, description, published, series, othernames, subject, Notes, copies from fielderBibRecord where ID = '" . "8" . "' order by title";

   // echo $titleList;
        //
$fielder_query = "select fielderBibRecord.*, fielderSubjectFull.*, fielderSubjectCode.*, fielderAuthorCode.*, fielderAuthorFull.author as author ,fielderAuthorFull.*  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID where fielderBibRecord.ID = '" . "8" . "'";

$fielder_test = "select * from fielderBibRecord";

echo "<br>";

$database = new Database();
// Instantiate database.
echo "test_1<br>";
$database->getConnection();
$database->PDO_query($fielder_test);  // set the query to fielder query
$result = $database->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />". mysql_error()); 		
		}  else { echo "Successfully queried the database.<br>";   }

echo "result size: " . count($result);
echo "<br><br>";
$fielder_record=array();
$fielder_author=array();
$fielder_subject=array();


foreach ($result as $rowNum) {
	$row_index = 0;
  foreach ($rowNum as $key => $value) {
	// $fielder_record[$row_index]["title"] = $row["title"];
    echo "[$key]:  $value<br>";
	$fielder_record[$row_index]["$value"] = $row["$key"];
  }
  $row_index++;
}

echo "record count: " . count($field_record);
//print_r($fielder_record);
// echo "title: " . $row['title'] . "  author: " . $row['author'];

$rowCount = $database->rowCount();
echo "Row count: " . $rowCount;


echo "<br><br>dump of result: ";
//print_r($result);
//var_dump($result);

echo "<br><br>test_4<br>";

echo "Row count: " .  $database->rowCount() .  "<br>";

//---------------------------------------------------------------------------
	
	for ($row_index = 0; $row_index < count($fielder_record); $row_index++ ) {		
	
		$title = $fielder_record[$row_index]['title'];
		$edition = $fielder_record[$row_index]['edition'];
		$published = $fielder_record[$row_index]['published'];
		$description = $fielder_record[$row_index]['description'];
		$series = $fielder_record[$row_index]['series'];
		$othernames = $fielder_record[$row_index]['othernames'];
		$notes = $fielder_record[$row_index]['notes'];
		$copies = $fielder_record[$row_index]["copies"];
		
		}
		
		//echo "<br><br>";
		
		echo "<strong>Title: </strong>" . $title . "<br><br>";

		echo "<strong>Edition: </strong>" . $edition . "<br>";
		echo "<strong>Series: </strong>" . $series . "<br>";
		echo "<strong>Description: </strong>" . $description . "<br>";
		echo "<strong>Published: </strong>" . $published . "<br>";
		echo "<strong>Notes: </strong>" . $notes . "<br>";
		echo "<strong>Other names: </strong>" . $othernames . "<br><br>"; 
		echo "<strong>Avaliable copies: </strong>" . $copies . "<br><br>";
		
		
		
				
		
		
		
		echo "<br>";

//----------------------------------------------------------------------------


//print_r($result);

$result->close();
//
?>

<h2>Instantiating Address</h2>
test<br>
</body></html>