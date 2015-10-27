<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>
<head><title>Study Titles: ALpha list</title>
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">

<!--<a href="http://dataarchives.ss.ucla.edu/">Back to main</a>&nbsp;-&nbsp;-&nbsp;<a href="http://dataarchives.ss.ucla.edu/da_catalog_index.php">Data Archive: Index</a><br> -->

</head>
<body>
<h1 id="siteName"><a href="../index.php"><img src="../_images/logo75.jpg" width="75" height=""></a> Social Science Data Archive: Eve Fielder Collection</h1> 
 
<div id"container">

<?php  include("../SSDA_menubar.php");   
//-----------------------------------------
//   SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
//------------------------------------------

?>

<div id="content" align="left">
<H1 align="center">Search Results</H1><br>

<?php
	
		$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_fielder/";	
		include("SSDA_librarydatabase.php"); 
// Define configuration
// define info pulled from SSDA_librarydatabase.php
define("DB_HOST", $db_host);
define("DB_PORT", $db_port);
define("DB_USER", $db_username);
define("DB_PASS", $db_password);
define("DB_NAME", $db_name);
	
// should be adding "class.Database.php";	
function __autoload($class_name) {
	// echo 'class.' . $class_name . '.php<br>';
	include 'class.' . $class_name . '.php';
}


$query_searchStuff = "select title, recordID, author, subject from (select fielderBibRecord.title, fielderBibRecord.ID as recordID, fielderSubjectFull.subject as subject, fielderAuthorFull.author  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID) as searchStuff  where ((title like '%" . $searchTerm . "%') or (author like '%" . $searchTerm . "%') or (subject like '%" . $searchTerm . "%')) order by title";
	
 

	
	// check, if NOT set 
	if (!isset($_GET['searchTerm'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
		
	$searchTerm =  $_GET['searchTerm']; 
	


// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($query_searchStuff);   	
// execute query
$result = $db->executeQuery();	 
	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
		}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging
		
	
	echo "<H1>Results of Search in Data Archives Studies</H1><br>";
	
	echo "Search term(s): <strong>" .  $searchTerm . "</strong><br>";
	
	echo "<ul>";
	$row_index = 0;

		while ($row = $db->getRow())   {
		
			$title = $row[ "title" ];
			$recordID = $row["recordID"];
			
			
			
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_titleRecord.php?ID=" . $recordID . "'>" . $title . "</a></li>";
			
			//  
			
			$row_index++;
			
		}
	echo "</ul>";
	if ($row_index < 1) {
			
			echo "<li class='alphaTitleList'>No items found for search term: $searchTerm</li>";
			
	}
	
	// _destructor class closes connection
	// close the connection		
	//$PDO_connection = null;
	
	?>
    </div>
    
 </div> <!-- end content-->
 

</body></html>
