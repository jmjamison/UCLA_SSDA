<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Eve Fielder Collection: Search by Title</title>



<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
</head>

<body>

<h1 id="siteName"><a href="../index.php"><img src="../_images/logo75.jpg" width="75" height=""></a> Social Science Data Archive: Eve Fielder Collection</h1> 
 
<div id="container">

<?php  
	include("../_includes/SSDA_menubar.php");  
//
// SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
//
?>



<div id="content" style="padding: 30px 50px 30px 50px;">  
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
	if (!isset($_GET['ID'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
	 
	$recordID =  $_GET['ID']; 
	
	// database name
	$fielder_query = "select fielderBibRecord.*, fielderSubjectFull.*, fielderSubjectCode.*, fielderAuthorCode.*, fielderAuthorFull.*  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID where fielderBibRecord.ID = '" . $recordID . "'";
	
	//echo "<br>" . $fielder_query . "<br>";
			
// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($fielder_query);   	
	
	 // PDO - execute the query
$result = $db->executeQuery();	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
				}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging
				
				
		// the mobilityData 
		$fielder_record=array();

	$row_index = 0;
	while ($row = $db->getRow()) {
		
		 $fielder_record[$row_index]["title"] = $row["title"];
		 $fielder_record[$row_index]["titleArticle"] = $row["titleArticle"];
		 $fielder_record[$row_index]["edition"] = $row["edition"]; 
		 $fielder_record[$row_index]["published"] = $row["published"];
		 $fielder_record[$row_index]["description"] = $row["description"];
		 $fielder_record[$row_index]["series"] = $row["series"];
		 $fielder_record[$row_index]["othernames"] = $row["othernames"];
		 $fielder_record[$row_index]["notes"] = $row["notes"];
		 $fielder_record[$row_index]["copies"] = $row["copies"];
		 $fielder_record[$row_index]["voyagerBibRecord"] = $row["voyagerBibRecord"];
		 $fielder_record[$row_index]["voyagerCatalogLink"] = $row["voyagerCatalogLink"];
		 //
		 $fielder_author[$row_index] = $row["author"] . ";" . $row["authorID"];
		 //
		 $fielder_subject[$row_index] = $row["subject"]. "; " . $row["subjectID"]; 
		 
		
		//echo "<br>Row count: " . $row_index;
		 
		 
	 	$row_index++;
	 
 		}
	
	// 150814jmj: SORT-REGULAR  for array-to-string error
	$fielder_record = array_unique($fielder_record, SORT_REGULAR);  // toss out duplicate bib records
	$fielder_author = array_unique($fielder_author, SORT_REGULAR);  // toss out duplicate subject terms
	sort($fielder_author);
	//print_r($fielder_author);
	$fielder_subject = array_unique($fielder_subject, SORT_REGULAR);  // toss out duplicate subject/index terms
	sort($fielder_subject);
	//print_r($fielder_subject);
	
	
	// author or authors
	echo "<br><br><strong>Author:</strong> ";   
		//for ($row_index = 0; $row_index < count($fielder_author); $row_index++ ) {	
		
			// break up the author line if it contains more than one author
		
			for ($i = 0; $i < count($fielder_author); $i++) {
				
				list($author, $authorID) = explode(";", $fielder_author[$i]);
				
				echo "<A HREF= '" . $currentHTTP . "fielder_byAuthorList.php?author=" . htmlentities($author, ENT_QUOTES ). "&authorID=" . $authorID  . "'>" . $author . "</a>   " ;
			
				}
				
		//}
		
		echo "<br><br>";
	
	for ($row_index = 0; $row_index < count($fielder_record); $row_index++ ) {		
	
		$title = $fielder_record[$row_index]['title'];
		$titleArticle = $fielder_record[$row_index]['titleArticle'];
		$edition = $fielder_record[$row_index]['edition'];
		$published = $fielder_record[$row_index]['published'];
		$description = $fielder_record[$row_index]['description'];
		$series = $fielder_record[$row_index]['series'];
		$othernames = $fielder_record[$row_index]['othernames'];
		$notes = $fielder_record[$row_index]['notes'];
		$copies = $fielder_record[$row_index]["copies"];
		$voyagerBibRecord = $fielder_record[$row_index]["voyagerBibRecord"];
		$voyagerCatalogLink = $fielder_record[$row_index]["voyagerCatalogLink"];
		
		}
		
		//echo "<br><br>";
		
		echo "<strong>Title: " . $titleArticle . " " . htmlspecialchars($title, ENT_COMPAT) . "</strong><br><br>";

		if (!empty($edition)) { echo "<strong>Edition: </strong>" . $edition . "<br>"; }
		if (!empty($series)) { echo "<strong>Series: </strong>" . $series . "<br>"; }
		if (!empty($description)) { echo "<strong>Description: </strong>" . $description . "<br>"; }
		if (!empty($published)) { echo "<strong>Published: </strong>" . $published . "<br>"; }
		if (!empty($notes)) { echo "<strong>Notes: </strong>" . $notes . "<br>"; }
		if (!empty($othernames)) { echo "<strong>Other names: </strong>" . $othernames . "<br><br>"; }
		if (!empty($copies)) { echo "<strong>Avaliable copies: </strong>" . $copies . "<br><br>"; }
		if ($voyagerBibRecord >= 1) { echo "<strong>Voyager Record Number: </strong>" . $voyagerBibRecord . "<br><br><strong>Voyager Catalog Link: </strong>" . "<A HREF= '" . $voyagerCatalogLink . "'>Link to Voyager catalog</a><br><br>"; }
		
		
		// subject or subjects
		echo "<strong>Subject:</strong> "; 
		// subject or index term(s)
		//for ($row_index = 0; $row_index < count($fielder_subject); $row_index++ ) {	
		
			// break up the author line if it contains more than one author
			//print_r($fielder_subject) . "<br>";
		
		
		$fielder_subject_count = count($fielder_subject);
		//echo "<br>" . $fielder_subject_count  . "<br>";
		
		$fielder_subjectTemp = array();
		$row_index = 0;
		
	for ($row_index = 0; $row_index < $fielder_subject_count; $row_index++) {
				
				//echo "<br>Row #: " . $row_index;
				
				list($subject, $subjectID) = explode(";", $fielder_subject[$row_index]);
				
				//echo $subject . " / " . $subjectID . " / " . $row_index . "<br>";
echo "<A HREF= '" . $currentHTTP . "fielder_bySubjectList.php?subject=" . $subject . "&subjectID=" . $subjectID  . "'>" . $subject . "</a>   ";
				}
				
		
		//}	
				
		
		
		
		echo "<br>";
		
		
		//--------------------------------------------------------------------------------------------
	//  Section for sharing links
	//  07/23/2011
	//
	//--------------------------------------------------------------------------------------------
	
	echo "<br>";
	
	echo "<div align='left' class='socialLinks' >";   
	
	echo "<span  class='st_twitter' ></span><span  class='st_facebook' ></span><span  class='st_email' ></span><span  class='st_sharethis' ></span>";
	
	echo "</div>";
	
	echo "<br>";
	
		echo "<br><br>";
	
// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
?>    
  </div>
 </div>


  </body></html>