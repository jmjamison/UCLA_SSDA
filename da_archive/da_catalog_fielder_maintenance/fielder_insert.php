<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="GENERATOR" content="Mozilla/4.7 [en] (Win98; U) [Netscape]">
<title>Data Archive Catalog / Fielder Collection: Insert</title>
<link rel="stylesheet" href="../2col_leftNav.css" type="text/css">
 
<script>
</script>
</head>
<body text="#000000" bgcolor="#FFFFFF" link="#0000EE" vlink="#551A8B" alink="#FF0000">

<!-- link to top of page starts here -->
<!-- link to top of page ends here -->

<div id="pageHeader" style="margin-left: 0; text-align: center">
<h1>UCLA Institute for Social Research Data Archives: Fielder Collection<br><br>Record Inserted</h1>
<h2 align="left" id="siteName"><a href="index.php" target="_self">Back to Maintenance Menu</a></h2>  

<!--<h2 align="left" id="siteName"><a href="da_catalog_edit.php" target="_self">Edit this Record</a></h2>  -->
<form action="da_catalog_fielder_maintenance/fielder_edit.php" method="post" name="editRecord" target="_self">
<input name='submitRecord' type='submit' value='Continue editing this record'>
<h2 align="left" id="siteName">Edit this Record</h2>

</form>  

</div>
 
<div id="citation" style="margin: 30; text-align: left; background-color: white;">
    <?php
	
	
	$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder_maintenance/";
	
	//include the login file - ISSRDA_login.php
	// data archive in-house login
	include("../da_catalogLib/ISSRDA_login.php");
	
	
	// PDO connect  
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
	
	try	{
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password); 
		
		} catch(PDOException $e)	{
			echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
			die();
			}
		
	
		
	//$dateadded = $_POST['dateadded'];
	$dateadded = date('Y-m-d h:i:s');
	//$dateadded = "7/21/2009";
	$lastupdated = "";
	//$lastupdated = "";
	
	$dateadded = date('Y-m-d h:i:s');
	// 
	//$lastupdated = $_POST['lastupdated'];
	$lastupdated = "";  // format for the editing/update screen
	
	if (isset($_POST['title'])) {
		$title = $_POST['title'];
	} else { $title = "";	}
	
	if (isset($_POST['edition'])) {
		$edition = $_POST['edition'];
	} else { $edition = ""; }
	
	if (isset($_POST['series'])) {
		$series = $_POST['series'];
	} else { $series= ""; }
	
	if (isset($_POST['description'])) {
		$description = $_POST['description'];
	} else { $description= ""; }
	
	if (isset($_POST['published'])) {
		$published = $_POST['published'];
	} else { $published= ""; }
	
	if (isset($_POST['notes'])) {
		$notes = $_POST['notes'];
	} else { $notes = "";	}
	
	if (isset($_POST['othernames'])) {
		$othernames = $_POST['othernames'];
	} else { $othernames = ""; }
		
	if (isset($_POST['copies'])) {
		$copies = $_POST['copies'];
	} else { $copies= ""; }
	
	if (isset($_POST['voyagerBibRecord'])) {
		$voyagerBibRecord = $_POST['voyagerBibRecord'];
	} else { $voyagerBibRecord= ""; }
	
	if (isset($_POST['voyagerCatalogLink'])) {
		$voyagerCatalogLink = $_POST['voyagerCatalogLink'];
	} else { $voyagerCatalogLink= ""; }
		
	
	if (isset($_POST['author'])) {
		$author = $_POST['author'];
	} else { $author= ""; }
	
	if (isset($_POST['subject'])) {
		$subject = $_POST['subject'];
	} else { $subject= ""; }
	
	
//------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------
	

	//
	// 1-html_entity_decode takes off the html code for single, double quotes; 
	// 2-addslashes puts in slashes for the sql queries
	//$title = addslashes(html_entity_decode($_POST['title']));    htmlentities($title, ENT_QUOTES)
	$title = addslashes(html_entity_decode($_POST['title']));
	
	echo "<h2>New baserecord submitted: " . $dateadded . "</h2>";
	echo "<br><strong>title:</strong> " . $title . " / " . $author . "<br><br>";
	
	
	echo "<strong>Fields set:</strong><br>";
	
	if ($edition != "") {echo "<strong>edition:</strong> " . $edition . "<br>";}
	if ($series != "") {echo "<strong>series:</strong> " . $series . "<br>";}
	if ($description != "") {echo "<strong>description:</strong> " . $description . "<br>";}
	if ($published != "") {echo "<strong>published:</strong> " . $published . "<br>";}
	if ($notes != "") {echo "<strong>notes:</strong> " . $notes . "<br>";}
	if ($othernames != "") {echo "<strong>othernames:</strong> " . $othernames . "<br>";}
	if ($copies != "") { echo "<strong>copies:</strong> " . $copies . "<br>"; }
	//if ($voyagerBibRecord != "") {echo "<strong>voyagerBibRecord:</strong> " . $voyagerBibRecord . "<br>";}
	//if ($voyagerCatalogLink != "") {echo "<strong>voyagerCatalogLink:</strong> " . $voyagerCatalogLink . "<br>";}
	echo "<br>";
	
	//  ----  insert query ----
// first pass insert data into TITLE, PIFULL, SHFULL

// title   // pifull   // shfull  // cite gets the citenum from title.cite

//$insert_fielderBibRecord = "INSERT INTO fielderBibRecord (author, edition, title, description, published, series, othernames, subject, notes, copies, voyagerBibRecord, voyagerCatalogLink, DateAdded, LastUpdated) VALUES ('" . $author . "', '" . $edition . "', '" . $title . "', '" . $description . "', '" . $published . "', '" . $series . "', '" . $othernames . "', '" . $subject . "', '" .$notes . "', '" . $copies . "', '"  . $voyagerBibRecord . "', '" . $voyagerCatalogLink . "', '" $DateAdded . "' , '" . $LastUpdated . "');";


$insert_fielderBibRecord = "INSERT INTO fielderBibRecord (author, edition, title, description, published, series, othernames, subject, notes, copies, voyagerBibRecord, voyagerCatalogLink, DateAdded, LastUpdated) VALUES ('$author', '$edition', '$title', '$description', '$published', '$series', '$othernames', '$subject', '$notes', '$copies', '$voyagerBibRecord','$voyagerCatalogLink', '$DateAdded', '$LastUpdated')"; 

echo $insert_fielderBibRecord . "<br>";
		
echo "<br>test line<br>";
		//----------------------------------------------------------------------------------
		// PDO - create prepared statement: insert fielder bib record
		//----------------------------------------------------------------------------------
		// prepare query
		
			$PDO_query = $PDO_connection->prepare($insert_fielderBibRecord);
		//  PDO - execute the query
			$insert_title = $PDO_query->execute();
		
		//echo "<br>title insert query: " .  $query_from_title . "<br>";

	  		if (!$insert_title) {
				die ("Could not query the database: <br />". mysql_error());
				} 	
			//echo "title table record for " . $current_studynumber .  " added";
			//echo "<br>";
		
		
		$query_FetchbaseCode = "SELECT * FROM fielderBibRecord WHERE title like '%" . $title . "%'";
		echo "<br>" . $query_FetchbaseCode  . "<br>";
					
	
 		// --------------------------------------------------------
		$PDO_query = $PDO_connection->prepare($query_FetchbaseCode);
		//$result = $PDO_query->execute();
		$result = $PDO_connection->query($query_FetchbaseCode);
	  		if (!$result ) {
				die ("Could not find the table key<br />". mysql_error());
				} 	//echo "got title table key, woopie!";
		
		// there should only be one - the key, title key or tisort, is unique
		//echo "<br>";
		$row = $result->fetch(PDO::FETCH_ASSOC);
		//echo "<br>row: ";
		print_r($row);
		//echo "<br>";
		$baseCode = $row["ID"];
		$title = $row["title"];
		
echo "<br>";
echo "<br>record ID: " . $baseCode;
echo "<br>";
	


//----------------------------------------------------------------------------------
	// pifull - the principle investigator table
	//----------------------------------------------------------------------------------	
	
	$author = $_POST['author'];
	$authorList = explode(";", $author);   // split apart the pi list
	$totalAuthor = count($authorList);		// count how many pi's
	
	print_r($authoriList);
	echo "<br>";
	//--------------------------------------------------------------------------------------
	// create an array of authors and picodes to use to create the connecting picode table
	//--------------------------------------------------------------------------------------
	$authorListAdd = array();		
	echo "<br>total author(s) = $totalAuthor<br>";
	
	//echo "<strong>Author(s): </strong>" . $authorListAdd;
	//echo "<br>Total Author(s) = " . $totalAuthor . " attached to this study.<br>";
		
	for ($row_index = 0; $row_index < $totalAuthor; $row_index++) {
		
			// NEED TO USE TRIM - otherwise spaces can throw off the search
			$individual_author = trim($authorList[$row_index]);  
			
			echo "<br>individual author [" . $row_index . "]: " . $individual_author;	
			
			$query_checkAuthordups = "SELECT * FROM fielderAuthorFull WHERE author like '%" . $individual_author . "%'";
			echo "<br>" . $query_checkAuthordups . "<br>";
			
				// prepare query
				$PDO_query = $PDO_connection->prepare($query_checkAuthordups);
				// execute query
				$result = $PDO_connection->query($query_checkAuthordups);
					if (!$result) { 
						die ("Could not query the database: <br />". mysql_error());  
					}
				// fetch query
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$rowCount = count($row);
				echo "row count: " . $rowCount . "<br>";
								
				// close query cursor
				$PDO_query->closeCursor();
				
				//     print_r($row);
				
				//if (count($row) == 0) { 
				if ((!$row ) || empty($result)) {
						// $result is FALSE, record not found or rather doesn't exist
						//die ("<br>Could not find record<br />". mysql_error());
						echo "<br>Could not find record for " . $individual_author . "<br />";
						
						// put an insert in here for PIs with no da_catalog record
						$query_insert_author = "INSERT INTO fielderAuthorFull (author) VALUES ( '" . $individual_author . "');";
						echo "<br>author insert query: " .  $query_insert_author . "<br>";
						
						// prepare query
						$PDO_query = $PDO_connection->prepare($query_insert_author);
						// execute query
						$PDO_query->execute();
							if (!$PDO_query) { die ("Could not query the database: <br />". mysql_error()); } 	 
						// close query cursor
						$PDO_query->closeCursor();
						
									
						// pull back the pi code for the added PI						
$query_getAuthorInfo = "SELECT author, authorID FROM fielderAuthorFull WHERE author like '%" . $individual_author . "%'";
						//echo "<br>" . $query_checkPIdups . "<br>";
			
						// prepare query
						$PDO_query = $PDO_connection->prepare($query_getAuthorInfo);
						// execute query
						$PDO_query->execute();
						// fetch query
						$row = $PDO_query->fetch(PDO::FETCH_ASSOC);
						// close query cursor
						$PDO_query->closeCursor();
						
						//print_r($row);
						$authorID = $row["authorID"];
						$checkAuthor = $row["author"];
						echo "<br>author: " . $checkAuthor . ";  authorID: " . $authorID;
				
						$authorListAdd[$row_index]["author"] = $row["author"];
						$authorListAdd[$row_index]["authorID"] = $row["authorID"];
						
						echo "<br>";
						echo print_r($authorListAdd);
						
						} 	 
						
				elseif ($row) { // $result is TRUE, record exists
			
					
					echo "<br>Record exists, not a dup."; 
					
					// pull back the pi code for the added PI						
$query_checkAuthordups = "SELECT author, authorID FROM fielderAuthorFull WHERE author like '" . $individual_author . "'";
			
						// prepare query
						$PDO_query = $PDO_connection->prepare($query_checkAuthordups);
						// execute query
						$PDO_query->execute();
						// fetch query
						 $row = $PDO_query->fetch(PDO::FETCH_ASSOC);
						// close query cursor
						$PDO_query->closeCursor();
					
					//print_r($row);
					$authorID = $row["authorID"];
					$checkAuthor = $row["author"];
					echo "<br>author exits - author: " . $checkAuthor . ";  authorID: " . $authorID;
				
					$authorListAdd[$row_index]["author"] = $row["author"];
					$authorListAdd[$row_index]["authorID"] = $row["authorID"];
					
			
				}  // end if-elseif-loop
				echo "<br>authorListAdd array: ";
				print_r($authorListAdd);  // there is only one entry 
				// save in piListAdd and use later to create PICODE table
		
	} // end for-loop through authorList
	
	// ---------------------------------------------------------------------------
	//   create the author list
	// 		
	// 		
	// 		
	//--------------------------------------------------------------------------
	echo "<br>baseCode number: " . $baseCode;
	print_r($authorListAdd); 
	$authorTotal = count($authorListAdd); 
	echo "<br>total authors to add: " . $authorTotal;
	
	
	for ($row_index = 0; $row_index < $totalAuthor; $row_index++) {
		
		$current_authorID = $authorListAdd[$row_index]["authorID"];
		echo "current_authorID: " . $current_authorID . "<br>";
		
		
		
		$query_insert_authorCode = "INSERT INTO fielderAuthorCode (baseCode, authorID) VALUES ('" . $baseCode . "', '" . $current_authorID . "')";
	
		echo "query_insert_authorID: " . $query_insert_authorCode . "<br>";
		// prepare query
		$PDO_query = $PDO_connection->prepare($query_insert_authorCode);
		// execute query
		$PDO_query->execute();
			if (!$PDO_query) { die ("Could not query the database: <br />". mysql_error()); } 	 
		// close query cursor
		$PDO_query->closeCursor();
		
		//echo "<br>" . $query_insert_authorCode;
	}


	//----------------------------------------------------------------------------------
	// shfull- the subject/keyword table
	//----------------------------------------------------------------------------------	
	
	
	$subject = $_POST['subject'];
	$subjectList = explode(";", $subject);   // split apart the pi list
	$totalSubject = count($subjectList);		// count how many pi's
	
	print_r($subjectList);
	echo "<br>";
	//--------------------------------------------------------------------------------------
	// create an array ofauthors and picodes to use to create the connecting picode table
	//--------------------------------------------------------------------------------------
	$subjectListAdd = array();		
	echo "<br>total subject(s) = $totalSubject<br>";
	
	//echo "<strong>Author(s): </strong>" . $authorListAdd;
	//echo "<br>Total Author(s) = " . $totalAuthor . " attached to this study.<br>";
		
	for ($row_index = 0; $row_index < $totalSubject; $row_index++) {
		
			// NEED TO USE TRIM - otherwise spaces can throw off the search
			$individual_subject = trim($subjectList[$row_index]);  
			
			echo "<br>individual subject [" . $row_index . "]: " . $individual_subject;	
			
			$query_checkSubjectdups = "SELECT * FROM fielderSubjectFull WHERE subject like '%" . addslashes($individual_subject) . "%'";
			echo "<br>" . $query_checkSubjectdups . "<br>";
			
				// prepare query
				$PDO_query = $PDO_connection->prepare($query_checkSubjectdups);
				// execute query
				$result = $PDO_connection->query($query_checkSubjectdups);
					if (!$result) { 
						die ("Could not query the database: <br />". mysql_error());  
					}
				// fetch query
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$rowCount = count($row);
				echo "row count: " . $rowCount . "<br>";
								
				// close query cursor
				$PDO_query->closeCursor();
				
				//     print_r($row);
				
				//if (count($row) == 0) { 
				if ((!$row ) || empty($result)) {
						// $result is FALSE, record not found or rather doesn't exist
						//die ("<br>Could not find record<br />". mysql_error());
						echo "<br>Could not find record for " . $individual_subject . "<br />";
						
						// put an insert in here for PIs with no da_catalog record
		$query_insert_subject = "INSERT INTO fielderSubjectFull (subject) VALUES ( '" . $individual_subject . "');";
						echo "<br>subject insert query: " .  $query_insert_subject . "<br>";
						
						// prepare query
						$PDO_query = $PDO_connection->prepare($query_insert_subject);
						// execute query
						$PDO_query->execute();
							if (!$PDO_query) { die ("Could not query the database: <br />". mysql_error()); } 	 
						// close query cursor
						$PDO_query->closeCursor();
						
						
						// pull back the pi code for the added PI						
						$query_getSubjectInfo = "SELECT subject, subjectID FROM fielderSubjectFull WHERE subject like '%" . $individual_subject . "%'";
						//echo "<br>" . $query_checkPIdups . "<br>";
			
						// prepare query
						$PDO_query = $PDO_connection->prepare($query_getSubjectInfo);
						// execute query
						$PDO_query->execute();
						// fetch query
						$row = $PDO_query->fetch(PDO::FETCH_ASSOC);
						// close query cursor
						$PDO_query->closeCursor();
						
						//print_r($row);
						$subjectID = $row["subjectID"];
						$checkSubject = $row["subject"];
						echo "<br>subject: " . $checkSubject . ";  subjectID: " . $subjectID;
				
						$subjectListAdd[$row_index]["subject"] = $row["subject"];
						$subjectListAdd[$row_index]["subjectID"] = $row["subjectID"];
						
						echo "<br>";
						echo print_r($subjectListAdd);
						echo "<br>";
						
						} 	 
						
				elseif ($row) { // $result is TRUE, record exists
			
					
					echo "<br>Record exists, not a dup."; 
					
					// pull back the pi code for the added PI						
$query_checkSubjectdups = "SELECT subject, subjectID FROM fielderSubjectFull WHERE subject like '" . $individual_subject . "'";
						//echo "<br>" . $query_checkPIdups . "<br>";
			
						// prepare query
						$PDO_query = $PDO_connection->prepare($query_checkSubjectdups);
						// execute query
						$PDO_query->execute();
						// fetch query
						$row = $PDO_query->fetch(PDO::FETCH_ASSOC);
						// close query cursor
						$PDO_query->closeCursor();
					
					//print_r($row);
					$subjectListAdd[$row_index]["subjectID"] = $row["subjectID"];
					$subjectListAdd[$row_index]["subject"] = $row["subject"];
					//echo "<br>subject exits - subject: " . $checkSubject . ";  subjectID: " . $subjectID;
				
					//$subjectListAdd[$row_index]["subject"] = $row["subject"];
					//$subjectListAdd[$row_index]["subjectID"] = $row["subjectID"];
					
			
				}  // end if-elseif-loop
				echo "<br>subjectListAdd array: ";
				print_r($subjectListAdd);  // there is only one entry 
				// save in piListAdd and use later to create PICODE table
		
	} // end for-loop through authorList
	
	// ---------------------------------------------------------------------------
	//   create the picode table
	// 		already have tisort, rectricted and picode
	// 		tisubsort is the order multiple pi's or 1 for one pi. Use the piList  $row_index+1;
	// 		loop throug the piListAdd array 
	//--------------------------------------------------------------------------
	echo "<br>baseCode number: " . $baseCode;
	print_r($subjectListAdd); 
	$subjectTotal = count($subjectListAdd); 
	echo "<br>total subject to add: " . $subjectTotal;
	
	
	for ($row_index = 0; $row_index < $totalSubject; $row_index++) {
		
		$current_subjectID = $subjectListAdd[$row_index]["subjectID"];
		echo "current_subjectID: " . $current_subjectID . "<br>";
			
		$query_insert_subjectCode = "INSERT INTO fielderSubjectCode (baseCode, subjectID) VALUES ('" . $baseCode . "', '" . $current_subjectID . "')";
	
		echo "query_insert_subjectID: " . $query_insert_subjectCode . "<br>";
		// prepare query
		$PDO_query = $PDO_connection->prepare($query_insert_subjectCode);
		// execute query
		$PDO_query->execute();
			if (!$PDO_query) { die ("Could not query the database: <br />". mysql_error()); } 	 
		// close query cursor
		$PDO_query->closeCursor();
		
		echo "<br>" . $query_insert_subjectCode;
	}
	
	
	//--------------------------------------------------------------------------
	
	
	session_start();
	
	$_SESSION['title'] = $title;
	$_SESSION['edition'] = $edition;
	$_SESSION['series'] = $series;
	$_SESSION['description'] = $description;
	$_SESSION['published'] =  $published;
	$_SESSION['notes'] = $notes;
	$_SESSION['othernames'] = $othernames;
	$_SESSION['copies'] = $copies;
	$_SESSION['voyagerBibRecord'] = $voyagerBibRecord;
	$_SESSION['voyagerCatalogLink'] = $voyagerCatalogLink;
	$_SESSION['author'] = $author;	
	$_SESSION['subject'] = $subject;
	
	
	
	//--------------------------------------------------------------------------

		
	// close the connection
	// mysql_close($connection);	  	
	$PDO_connection = null;
	
	// -------------------------------------------------------------------------------
	
	
?>

 
 
</div>

<div id="pageFooter" style="margin-left: 0; text-align: center; background-color: white;"></div>
</html>