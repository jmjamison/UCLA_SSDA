<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Eve Fielder Collection: Search by Author</title>
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



<div id="content" align="center">
<H1 align="center">Author [Surname] That Begin With The Letter...</H1><br>

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
$query = "select fielderAuthorFull.*, Left(fielderAuthorFull.author,1) AS firstLetterIndex from fielderAuthorFull order by firstLetterIndex;";

	// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($query);   	
// execute query
$result = $db->executeQuery();	 
	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
		}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging

		
		$indexList=array();
		// first letter of indext term list
		$indexFirstLetterList=array();
	 
		//echo "<table id='alphaList' align='center'> ";
		//echo "<tr>";  // start a row
		
		$itemCount = 1;	  // count off the number of items in the alpha-block, 5 letters across
		
		$row_index = 0;
		
		while ($row = $db->getRow())  {
			$indexList[$row_index]["author"] = $row['author'];
			$indexList[$row_index]["authorID"] = $row['authorID'];
			$indexList[$row_index]["firstLetterIndex"] = $row['firstLetterIndex'];
	 		$indexFirstLetterList[$row_index] = $row['firstLetterIndex'];
	 		$row_index++;
	 		}
	
		$totalRows = count($indexFirstLetterList);
		
		$indexFirstLetterList = array_unique($indexFirstLetterList);
		sort($indexFirstLetterList);
		
		// first letter list horizontal
		foreach($indexFirstLetterList as $key => $value) {
		
			echo "| <A HREF='#$value'>&nbsp;$value&nbsp;</A>";
			//echo " | $index_letter ";
			}
			echo " | ";
	
//----------------------------------------------------------------------------
//
//  begin the for-loop to read through the entire array
//
//----------------------------------------------------------------------------	
		
	//print_r($indexFirstLetterList);
	
	$totalFirstLetters = count($indexFirstLetterList);
	$firstLetterPrevious = NULL;
	
	// start unordered vertical list of first letters
	echo "<ul  style='text-align: left; margin: 30; margin-left: 50;'>";      // start of the ul list	 
	foreach($indexFirstLetterList as $key => $value) {
		
		echo "<br><br><h2 style='text-align: left;'><a id='" . $value . "'>" . $value . "</a></h2>"; // end previous 
		
		for ($row_index = 0; $row_index < count($indexList); $row_index++ ) {	
					
	 		//$firstLetterIndex = $indexFirstLetterList[$row_index]["firstLetterIndex"];
			$author = $indexList[$row_index]["author"];
			$authorID = $indexList[$row_index]["authorID"];
			$firstLetterIndex = $indexList[$row_index]["firstLetterIndex"];
			
			//echo $firstLetterIndex;
			
			if ($firstLetterIndex == $value) {
						
				//echo $author . "<br>";
				echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_byAuthorList.php?author=" . htmlentities($author, ENT_QUOTES ) . "&authorID=" .  $authorID . "'>" . $author  . "</a></li>";
				
				}
		
	  		}
		
		}
		
		echo "</ul>";      // end of the ul list
//----------------------------------------------------------------------------
//
//   end of the for-loop
//
//----------------------------------------------------------------------------
		
		//echo "</ul>";      // end of the ul list
		// put link to return to top of page ---	
		echo "<a href='#top'>Return to top of the page</a>";
		

//----------------------------------------------------------------------------
//
//   end of the for-loop
//
//----------------------------------------------------------------------------
	//echo "</table>";
	
	// _destructor class closes connection
	// close the connection		
	//$PDO_connection = null;
		
	?>
 </div>

  </body></html>