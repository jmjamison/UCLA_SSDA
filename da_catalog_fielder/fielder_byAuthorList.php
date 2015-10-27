<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>         
<head><title>Eve Fielder Collection: Search by Author</title>
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1 id="siteName"><a href="../index.php"><img src="../_images/logo75.jpg" width="75" height=""></a> Social Science Data Archive: Eve Fielder Collection</h1> 
 
<div id"container">

<?php  
	include("../_includes/SSDA_menubar.php");  
//
// SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
//
?>

<div id="content" align="left">
<H1 align="center">Authors</H1><br>

<?php
	
	
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_fielder/";	
	//SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	include("../_includes/SSDA_librarydatabase.php");  //SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	// class for database connections
	include "../_classes/class.Database.php";
	
// Define configuration
// define info pulled from SSDA_librarydatabase.php
define("DB_HOST", $db_host);
define("DB_PORT", $db_port);
define("DB_USER", $db_username);
define("DB_PASS", $db_password);
define("DB_NAME", $db_name);
	
// should be adding "class.Database.php";	
//function __autoload($class_name) {
	// echo 'class.' . $class_name . '.php<br>';
	//include 'class.' . $class_name . '.php';
//}
	 
	// check, if NOT set 
	if (!isset($_GET['author'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
		
	if (!isset($_GET['authorID'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
	 
	$author =  $_GET['author']; 
	$authorID =  $_GET['authorID']; 
	 
	 $titlesByAuthorQuery = "select fielderAuthorFull.*, fielderAuthorCode.*, fielderBibRecord.* from fielderAuthorFull left join fielderAuthorCode on fielderAuthorFull.authorID = fielderAuthorCode.authorID left join fielderBibRecord on fielderAuthorCode.baseCode = fielderBibRecord.ID where fielderAuthorFull.authorID = '" . $authorID . "';";
	//echo $titlesByAuthorQuery;
	
	
	// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($titlesByAuthorQuery);   	
// execute query
$result = $db->executeQuery();	 
	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
		}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging

	
	echo "<H1>" . $author  . "</H1><br>";


		 
	
	echo "<ul>";

		while ($row = $db->getRow())  {
		// Non-PDO code ---------------------
		//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			$title = $row[ "title" ];
			$titleArticle = $row[ "titleArticle" ];
			$recordID = $row[ "ID" ];
			
			//$studynum = $row[ "StudyNum" ];
			
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_titleRecord.php?ID=$recordID'>" . $titleArticle . " " . $title  . "</a></li>";
			
			
		}
	echo "</ul>";
	
	
	// _destructor class closes connection
	// close the connection		
	//$PDO_connection = null;
	
	?>
    </div>
 </div>

</body></html>