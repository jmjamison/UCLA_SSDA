<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="GENERATOR" content="Mozilla/4.7 [en] (Win98; U) [Netscape]">
<title>Data Archive Catalog: update base record</title>
<!--<link rel="stylesheet" href="2col_leftNav.css" type="text/css"> -->
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
<script>
</script>
</head>
<body text="#000000" bgcolor="#FFFFFF" link="#0000EE" vlink="#551A8B" alink="#FF0000">

<!-- link to top of page starts here -->
<!-- link to top of page ends here -->

<div id="pageHeader" style="margin-left: 0; text-align: center">
<h1>UCLA Institute for Social Research Data Archives<br><br>Record Inserted</h1>
<h2 align="left" id="siteName"><a href="index.php" target="_self">Back to Maintenance Menu</a></h2>  
<h2 align="left" id="siteName"><a href="da_catalog_edit.php" target="_self">Edit another Record</a></h2>  
<br>
<h2 align="left" id="siteName"><a href="da_catalog_inputDatasetRecord.php" target="_self">Add a Dataset to this record</a></h2> 

<form action="da_catalog_edit.php" method="post" name="editRecord" target="_self">
<input name='submitRecord' type='submit' value='Continue editing this record'><input type='hidden' name='studynumber' value='<?php echo $studynumber ?>'><h2 align="left" id="siteName">Edit this Record</h2>

</form> 





</div>
 
<div id="citation" style="margin: 30; text-align: left; background-color: white;">
    <?php
	
	//------------------------------------------------------------------------------------
	//
	//     insert the updates for title and citation
	//        
	//
	//-------------------------------------------------------------------------------------
		
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_maintenance/";	
	include("../_includes/SSDA_librarydatabase_edit.php"); 
	// maintenance doesn't use the menu bar
	//include("../_includes/SSDA_menubar.php");  
	// SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reource
	
	
	// PDO connect  
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
	try	{
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password); 
		
		} catch(PDOException $e)	{
			echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
			die();
			}
		
	//$current_query = "";
	//$result = "";
	
	// PDO - create prepared statement: FIRST pass, populate TITLE, then PIFULL (2nd), SHFULL (3rd)
	//--------------------------------------------------------------------------
		
	
	
	//----------------------------------------------------------------------------------
	//   title table
	//----------------------------------------------------------------------------------
	// $tisort is the title table key, auto-imcrementd, set at insert
	$studynumber = strtoupper($_POST['studynumber']);
	if (isset($_POST['restricted'])) {
	$restricted = $_POST['restricted'];
	// note - pick this up from title.restricted
		//echo "<br>$restricted";
	}	else {
		$restricted = "";
	}
	$dontdisplay = $restricted;
	//$dontdisplay = "";
	// note - pick this up from title.restricted
	$restricted = $restricted;
	
	//$dateadded = $_POST['dateadded'];
	//$dateadded = date('Y-m-d h:i:s');
	//$dateadded = "7/21/2009";
	$lastupdated = date('Y-m-d h:i:s');
	//$lastupdated = "";
	
	if (isset($_POST['sda'])) {
		$sda = $_POST['sda'];
		//$sda = "";
		//echo "<br>$sda";
	} else {
		$sda = "";
	}
	if (isset($_POST['varsrch'])) {
		$varsrch = $_POST['varsrch'];
		//$varsrch = "";
		//echo "<br>$sda";
	} else {
		$varsrch = "";
	}
	
	// citenum connects to title.Cite - so just use that number
	//--------------------------------------------------------------------------------------------------------------------
	//
	// studyNumShort is the studynumber minus the version - V1,  or V#
	// this is used for title.Cite and title.WWW - the connecting fields for citation and wwwlink
	$studynumArray = explode("V",$studynumber);
	$studyNumShort = $studynumArray[0];	
	
	//
	//substr($studyNum, 0, (strlen($current_studynumber) - (strlen(strstr($studyNum, "V")))));
	//$www = substr($current_studynumber, 0, (strlen($current_studynumber) - (strlen(strstr($current_studynumber, "V")))));
	
	if (isset($_POST['www'])) {
		$www = $_POST['www'];
		//echo "<br>wwwlink connector: " . $www;
		} else {
			$www = $studyNumShort;
			//echo "<br>wwwlink connector: " . $www;
		}
	
	//$citenum = substr($current_studynumber, 0, (strlen($current_studynumber) - (strlen(strstr($current_studynumber, "V")))));
	//--------------------------------------------------------------------------------------------------------------------
	if (isset($_POST['citenum'])) {
		$citenum = $_POST['citenum'];
		//echo "<br>citenum connector: " . $citenum;
		} else  {
			$citenum = $studyNumShort;
			//echo "<br>citenum connector: " . $citenum;
			}	
	
	
	if (isset($_POST['cite_text'])) {
		$cite_text = $_POST['cite_text'];
		echo "<br>$cite_text";
	} else { $cite_text= ""; }
	
	// there is only a single citation for title/bib/base records
	//if (isset($_POST['cite_subsort'])) {
		//$cite_subsort = $_POST['cite_subsort'];
		//echo " - subsort: $cite_subsort";
	//} else { $cite_subsort=  ""; }
	
	//if (isset($_POST['cite_text'])) {
		//$cite_subsort = $_POST['cite_text'];
		//echo " - subsort: " . $cite_text;
	//} //else { $cite_text=  ""; }
	
	//if (isset($_POST['cite_text'])) {
		//$cite_subsort = $_POST['cite_text'];
		//echo "citation: " . $cite_text;
	//} //else { $cite_text=  ""; }
	
	
	if (isset($_POST['justonCD'])) {
	$justonCD = $_POST['justonCD'];
	//$justonCD = "";
		echo "<br>$justonCD";
	} else {
		$justonCD= "";
	}
	// was the field to hold the gramatical article - the, a , an - not set or currently used
	$article = $_POST['article'];
	//$article = "";
	$title = addslashes(html_entity_decode($_POST['title']));
	//echo "<br>" . $title . "<br>";
	//$title = "Process Evaluation of the Comprehensive Communities Program in Selected Cities in the United States, 1994-1996";
	
	echo "<h2>New baserecord updated: " . $dateadded . "</h2>";
	echo "<h2>Fields updated or set for " .  $studynumber  .  "</h2>";	
	echo "<br><strong>title:</strong> " . $title . "<br><br>";
	
	
	echo "<strong>Fields set:</strong><br>";
		
	if ($restricted == "*") {echo "restricted<br>";}
	if ($sda == "*") {echo "SDA<br>";}
	if ($varsrch == "*") {echo "Varsrch<br>";}
	if ($justonCD == "*") {echo "Just-On-CD<br>";}
	if ($mobilityData == "*") {echo "Mobility-Data<br>";}
	if ($eveFielderCollection == "*") {echo "Eve-Fielder-Collection<br>";}
	
	if ($www != "") { echo "www ($www)<br>";}
	if ($citenum != "") { echo "citenum ($citenum)<br>";}
	if ($cite_text != "") { echo "citation title-level ($cite_text) is set: " . $cite_text . "<br>";}
	
	//  ----  insert query ----
// first pass insert data into TITLE, PIFULL, SHFULL
// title   // pifull   // shfull  // cite gets the citenum from title.cite

//UPDATE title SET Title='$title', Restricted='$restricted', LastUpdated='$lastupdated', SDA='$sda', Varsrch='$varsrch', JustOnCD='$justonCD', mobilityData='$mobilityData', eveFielderCollection='$eveFielderCollection' where StudyNum ='$studynumber'

$query_update_title = "UPDATE title SET Title='" . $title . "', Restricted='" . $restricted . "', LastUpdated='" . $lastupdated . "', SDA='" . $sda .  "', Varsrch='" . $varsrch . "', JustOnCD='" . $justonCD . "', mobilityData='" . $mobilityData . "', eveFielderCollection='" . $eveFielderCollection . "', Cite='" . $citenum . "', WWW='" . $www .  "' where StudyNum ='" . $studynumber . "'";
//echo "<br>" . $query_update_title . "<br>";   // SDA` = '*' 
		
		//----------------------------------------------------------------------------------
		// PDO - create prepared statement: get the title.tisort 	
		//----------------------------------------------------------------------------------
		
		// lock table: title
		//$PDO_query = $PDO_connection->prepare("lock tables fileinfo write");
		// execute query
		//$PDO_query->execute();
		
		
		$PDO_query = $PDO_connection->prepare($query_update_title);
		//  PDO - execute the query
		$insert_title = $PDO_query->execute();
		//echo "<br>title insert query: " .  $query_from_title . "<br>";
	  		if (!$insert_title) {
					echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
					die ("Could not query the database: <br />". mysql_error());
				} 	
			//echo "title table record for " . $studynumber .  " added";
			//echo "<br>";
		
		// unlock table: title
		$PDO_query = $PDO_connection->prepare("unlock tables");
		// execute query
		$PDO_query->execute();
			
	
	// ---------------------------------------------------------------------------
	//
	//   check wheter a citation record exists for the base record
	// 		 citenum,  subsort, cite <- the text
	// 		
			
		
		// check for base record citation -- there will only be one for base record
		//    
		//    
		$cite_ID = "";
		
		$cite_list = array();
		$row_index = 0;
		
		$query_check_citation = "SELECT * from cite where citenum='" . $citenum . "'";
		//echo "<br>" . $query_check_citation . "<br>";
	
				// prepare query
				$PDO_query = $PDO_connection->prepare($query_check_citation);
				// execute query
				$PDO_query->execute();
				// fetch query
				while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {   // check to see if something exists  // end of while-row-loop
				
					// $fileInfo[$row_index]["dsname"] = $row[ "Dsname" ];
					$cite_list[$row_index]["citeID"] = $row["ID"];
					$cite_list[$row_index]["citenum"] = $row["citenum"];
					// the title/bib/base record only has ONE citation so subsort won't be used
					//$cite_list[$row_index]["cite_subsort"] = $row["subsort"];
					$cite_list[$row_index]["cite_text"] = $row["cite"];			
					}
					
				//print_r($cite_list);
				$count_cite = count($cite_list);
				//echo "<br>Number citations: " . $count_cite . ",  citeID = " . $citeID;
				
				//if ($count_cite < 1) {  // no citations use INSERT to add this one
				if ($count_cite < 1) {  // no citations use INSERT to add this one
				
				//  
		$query_insert_citation = "insert into cite (citenum, subsort, cite) values ('" . $citenum . "', '', '" . $cite_text . "') ";
					
						//echo "<br>Citation doesn't exist - citation inserted. <br>";		
						//echo "<br>citation query: " . $query_insert_citation;
		
						$query_citation = $query_insert_citation;
					
					} else { // something exists so use UPDATE
						//$citeID = $row["ID"];
						$citeID = $cite_list[$row_index]["citeID"];
						//echo "<br>" . $citeID . "<BR>";
						//echo "<br>Citation exists:  " . $query_update_citation . " record updated.<br>";
					
										
						// update query
						//$query_update_citation = "UPDATE cite SET cite='" . $cite_text . "', subsort='" . $cite_subsort . "' where ID='" . $citeID . "'";
						$query_update_citation = "UPDATE cite SET cite='" . $cite_text . "' where ID='" . $citeID . "'";
					
						//print_r($row);
				
				
						//echo "<br>Citation exists:  " . $query_update_citation . " record updated.<br>";
						
						$query_citation = $query_update_citation;
					
					}	
					
					// logk table: cite
					$PDO_query = $PDO_connection->prepare("lock tables cite write");
					// execute query
					$PDO_query->execute();
		
		
					// prepare query
						$PDO_query = $PDO_connection->prepare($query_citation);
						// execute query
						$PDO_query->execute();
						
						if (!$PDO_query) { die ("Could not query the database: <br />". mysql_error()); } 	 
						// close query cursor
						$PDO_query->closeCursor();
						// end of the if-else-loop
						
						
						// unlock table: cite
						$PDO_query = $PDO_connection->prepare("unlock tables");
						// execute query
						$PDO_query->execute();
			
		
	//--------------------------------------------------------------------------
		echo $studynumber;	
			
	
	session_start();
	
	$_SESSION['studynumber'] = $studynumber;
	$_SESSION['title'] = $title;
	echo "<br>" . $title . "<br>";
	$_SESSION['restricted'] = $restricted;
	$_SESSION['sda'] = $sda;
	$_SESSION['varsrch'] = $varsrch;
	$_SESSION['citeID'] = $citeID;
	$_SESSION['citenum'] = $citenum;
	$_SESSION['cite_text'] = $cite_text;
	$_SESSION['mobilityData'] = $mobilityData;
	$_SESSION['eveFielderCollection'] =  $eveFielderCollection;
	$_SESSION['www'] = $www;
	$_SESSION['justonCD'] = $justonCD;
	
	$_SESSION['pi'] = $pi;
	echo "<br>" . $pi . "<br>";
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