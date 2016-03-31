<?php
	session_start();	
	error_reporting(0);
?>
<html>
<head><title>Study Titles: ALpha list</title>
<!--<link rel="stylesheet" href="2col_leftNav.css" type="text/css"> -->
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="content">
<?php
	
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_maintenance/";	
	include("../_includes/SSDA_librarydatabase_edit.php"); 
	// below links to the test version of the database, for testing
	//include("../_includes/SSDA_librarydatabase_test_edit.php"); 
	
	
	
	$current_query = "";
	$result = "";
		
	//   First insert into 3 tables: title, pifull (principle investigator(s)), shfull (subject/keyword(s))	 strtoupper  
	
	//----------------------------------------------------------------------------------
	//   title table
	//----------------------------------------------------------------------------------
	// $tisort is the title table key, auto-imcrementd, set at insert
	if (isset($_POST['studynumber'])) {
		$studynumber = $_POST['studynumber'];
	}
		
	$current_studynumber = strtoupper($_POST['studynumber']);
	//echo $current_studynumber . "<br>";
	//------------------------------
	// check that studynumber does't exist - run a select query on the studynumber <-- which has to be unique
	//      if the studynumber is a dup, will have to rename it or otherwise straighten this out before adding the record
	//------------------------------    
	
			// PDO connect  
			//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
			$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
			// echo "$PDO_string<br>";
			$PDO_connection = new PDO($PDO_string, $db_username_edit, $db_password_edit);
	
			$query_check_title = "select StudyNum from title where StudyNum = '" . $current_studynumber . "'";
			//echo $query_check_title . "<br>";
			
			// PDO - create prepared statement
 			// --------------------------------------------------------
			$PDO_query = $PDO_connection->prepare($query_check_title);
			
			$PDO_query->bindValue(":studynumber", $studynumber,  PDO::PARAM_STR);
				
			// PDO - execute the query
			$result = $PDO_query->execute();
			
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				} 	else "querried the database.<br>";
			$result = $PDO_query->fetch(PDO::FETCH_ASSOC);
			// print_r($result);
			//echo "<br>current studynumber being added: ". $current_studynumber;
			echo "<br>"; 	
			if ($result) { 
				echo "NOTE!! " . $current_studynumber . " IS probably a duplicate"; 
				} elseif (!$result) { 
				//echo $current_studynumber . " is NOT a duplicate"; 
				}
	
	//-----------------------------------------------------------------
	//   pick up the other variables used in the title table
	//-----------------------------------------------------------------
	
	// title.restricted is used for all instances of restricted or dontdisplay
	if (isset($_POST['restricted'])) {
	$current_restricted = $_POST['restricted'];
	// note - pick this up from title.restricted
		echo "<br>$current_restricted";
	}	else {
		$current_restricted = "";
	}
	$dontdisplay = $current_restricted;
	//$dontdisplay = "";
	// note - pick this up from title.restricted
	$restricted = $current_restricted;
	
	
	$dateadded = date('Y-m-d h:i:s');
	// 
	//$lastupdated = $_POST['lastupdated'];
	$lastupdated = "";  // format for the editing/update screen
	
	if (isset($_POST['sda'])) {
		$sda = $_POST['sda'];
		//echo "<br>$sda";
	} else { $sda = "";	}
	
	if (isset($_POST['varsrch'])) {
		$varsrch = $_POST['varsrch'];
		//echo "<br>$varsrch";
	} else { $varsrch = ""; }
	
	if (isset($_POST['justonCD'])) {
		$justonCD = $_POST['justonCD'];
	} else { $justonCD= ""; }
	
	if (isset($_POST['mobilityData'])) {
		$mobilityData = $_POST['mobilityData'];		
	} else { $mobilityData= ""; }
	
	if (isset($_POST['eveFielderCollection'])) {
		$eveFielderCollection = $_POST['eveFielderCollection'];
	} else { $eveFielderCollection= ""; }
	
	
	//--------------------------------------------------------------------------------------------------------------------
	//
	// studyNumShort is the studynumber minus the version - V1,  or V#
	// this is used for title.Cite and title.WWW - the connecting fields for citation and wwwlink
	$studynumArray = explode("V",$studynumber);
	$studyNumShort = $studynumArray[0];	
	
	//
	//substr($studyNum, 0, (strlen($current_studynumber) - (strlen(strstr($studyNum, "V")))));
	//$www = substr($current_studynumber, 0, (strlen($current_studynumber) - (strlen(strstr($current_studynumber, "V")))));
	$www = $studyNumShort;
	//echo "<br>wwwlink connector: " . $www;
	
	//$citenum = substr($current_studynumber, 0, (strlen($current_studynumber) - (strlen(strstr($current_studynumber, "V")))));
	$citenum = $studyNumShort;
	//echo "<br>cite connector: " . $citenum;
	
	//--------------------------------------------------------------------------------------------------------------------
	
	if (isset($_POST['cite_text'])) {
		$cite_text = addslashes($_POST['cite_text']);
		//echo "<br>$cite_text";
	} else { $cite_text= ""; }
	
	
	// was the field to hold the gramatical article - the, a , an - not set or currently used
	$article = $_POST['article'];
	//$article = "";
	// legacy item
	
	
	//$title = $_POST['title'];
	// addslashes for instances where the title string includes quotes or other special characters
	$title = addslashes($_POST['title']);	
	echo "<h2>Fields to be added or set for " .  $studynumber  .  "</h2>";
	
	echo "<br><strong>title:</strong> " . $title . "<br><br>";
	
	
	echo "<strong>Fields set:</strong><br>";
	if ($restricted == "*") {echo "restricted IS set<br>";}
	if ($sda == "*") {echo "SDA<br>";}
	if ($varsrch == "*") {echo "Varsrch<br>";}
	if ($justonCD == "*") {echo "Just-On-CD<br>";}
	if ($mobilityData == "*") {echo "Mobility-Data<br>";}
	if ($eveFielderCollection == "*") {echo "Eve-Fielder-Collection<br>";}
	
	if ($www != "") { echo "www ($www)<br>"; }
	if ($citenum != "") { echo "citenum ($citenum)<br>";  }
	if ($cite_text != "") { echo "citation title-level ($cite_text)<br>";  }
	echo "<br>";
	

	// PDO - create prepared statement: get the title.tisort 	
	//----------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------
	// pifull - the principle investigator table
	// create the PI array of one or more principle investigator names
	//    the insert will happen when after ok-ing the record
	//----------------------------------------------------------------------------------	
	
	$pi = addslashes($_POST['pi']);
	//echo "<input type='hidden' name='pi' value='" . $pi . "'> ";
	$piList = explode(";", $pi);
	$totalPI = count($piList);
	
	echo "<strong>PI: </strong>" . $pi;
	echo "<br>Total PI(s) = " . $totalPI . " attached to this study.<br>";
	
	
	for ($row_index = 0; $row_index < $totalPI; $row_index++) {
		
			$individual_pi = trim($piList[$row_index]);  // NEED TO USE TRIM - otherwise spaces can throw off the search
			//echo "<br>current pi [" . $row_index . "]: " . $individual_pi . "<br>";
			
			$query_checkPIdups = "SELECT pi, picode FROM pifull WHERE pi like '" . $individual_pi . "'";
			//echo "<br>" . $query_checkPIdups . "<br>";
			
				// PDO connect  
				//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
				$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
				// echo "$PDO_string<br>";
				$PDO_connection = new PDO($PDO_string, $db_username_edit, $db_password_edit);
	
				//echo $query_checkPIdups . "<br>";
				
				// PDO - execute the query
				$result = $PDO_query->execute();
			
				// prepare query
				$PDO_query = $PDO_connection->prepare($query_checkPIdups );
				$PDO_query->bindValue(":pi", $pi,  PDO::PARAM_STR);
				
				// execute query
				$PDO_query->execute();
				// fetch query
				$row = $PDO_query->fetch(PDO::FETCH_ASSOC);
				// close query cursor
				$PDO_query->closeCursor();
				// print_r($row);
				//echo  "<br>";
				
	  			if (!$row ) { 	// $result is FALSE, record not found or rather doesn't exist
						
						//echo "<br>Could not find record for <strong>PI:</strong> " . $individual_pi . " -  so adding this pi to the database<br />";
						
						
						
						
						} 	//echo "found record/!";
						
				elseif ($row) { // $result is TRUE, record exists
			
					// there should only be one - the key, title key or tisort, is unique
					//echo "<br>";
					
					
					//echo "<br>row: ";
					// print_r($row);
					$picode = trim($row["picode"]);
					$checkPI = trim($row["pi"]);
					//echo "<br>pi: " . $checkPI . " [picode: " . $picode . "]: already exists in pi table (pifull).<br>";
				
				
			
				}  // end if-elseif-loop
				
			
		
	} // end for-loop through piList
	
	
	//----------------------------------------------------------------------------------
	// shfull- the subject/keyword table
	//----------------------------------------------------------------------------------	
	
	$subject = $_POST['subject']; 
	
	// ** NOTE ** $numstudies is from the old database, it lists the # of studies for a particular subject/keyword, not counting restricted items
	//             under the current PHP display this would be calculated dynamically
	//             leave for now but dont' need to set
	$numstudies = $_POST['numstudies'];
	//$numstudies = "";
	// $subjectcode is the shfull key, auto-incrimented 
	// $dontdisplay is set from title.restrited
	$icpsrcountry = $_POST['icpsrcountry'];
	//$icpsrcountry = "";
	$icpsrlink = $_POST['icpsrlink'];
	
	//$subsort = "";
	
	// break up subject
	$subjectList = explode(";", $subject);
	$totalSubjects = count($subjectList);
	//echo "<br>subject list array:  ";
	// print_r($subjectList);
	//echo "<br>";
	$subjectListAdd = array();		// create an array of pi's and picodes to use to create the connecting picode table
	//echo "<br>total subjects = $totalSubjects<br>";
	
	
	echo "<br><strong>Subject(s)/Index Term(s): </strong>" . $subject;
	echo "<br>Total Subject(s)/Index Term(s) = " . $totalSubjects . " attached to this study.<br><br>";
		
	for ($row_index = 0; $row_index < $totalSubjects; $row_index++) {
		
			$individual_subject = trim($subjectList[$row_index]);  // NEED TO USE TRIM - otherwise spaces can throw off the search
			$query_checkSubjectDups = "SELECT subject, subjectcode FROM shfull WHERE subject like '" . $individual_subject  . "'";
			//echo "<br>current subject/keyword: ". $individual_subject;
			
				// prepare query
				$PDO_query = $PDO_connection->prepare($query_checkSubjectDups);
				
				$PDO_query->bindValue(":subject", $subject,  PDO::PARAM_STR);
				
				
				// execute query
				$PDO_query->execute();
				// fetch query
				$row = $PDO_query->fetch(PDO::FETCH_ASSOC);
				// close query cursor
				$PDO_query->closeCursor();
				
				
	  			if (!$row )  { 	// $result is FALSE, record not found or rather doesn't exist
						//die ("<br>Could not find record<br />". mysql_error());
						//echo "<br><strong>Subject: </strong> " . $individual_subject . "<br>added to database.<br />";
						
						// put an insert in here for PIs with no da_catalog record
						// pull back the pi code for the added PI
						
						} 	//echo "found record/!";
						
				elseif ($row) { // $result is TRUE, record exists
			
					// there should only be one - the key, title key or tisort, is unique
					//echo "<br>";
					
					
					//echo "<br>row: ";
					// print_r($row);
					$subjectcode = $row["subjectcode"];
					$checkSubject = $row["subject"];
					//echo "<br>subject: " . $checkSubject . ";  subjectcode: " . $subjectcode . " record exists in pifull table.";
				
					$subjectListAdd[$row_index]["subject"] = trim($row["subject"]);
					$subjectListAdd[$row_index]["subjectcode"] = trim($row["subjectcode"]);
					
			
				}  // end if-elseif-loop
				//echo "<br><br>subjectListAdd array: ";
				// print_r($subjectListAdd);  // there is only one entry 
				// save in piListAdd and use later to create PICODE table
		
	} // end for-loop through piList
	

	
  		// --------------------------------------------------------
		
	// close the connection
	// mysql_close($connection);		
	//$PDO_connection = null;
	
	// -------------------------------------------------------------------------------
	
	
	
	echo "<br><A HREF='javascript:javascript:history.go(-1)'>Click here to go back to previous page</A><br>";
	echo "";
	echo "<form action='da_catalog_insert.php' method='post' target='_self'>";
	echo "Edit (below) or <input name='submitRecord' type='submit' value='Submit Record'><br><br>";
	
	echo "Study Number: <input name='studynumber' value='" . $current_studynumber . "'><br><br>";
	echo "Title: <input name='title' size='100' value='" . htmlentities($title, ENT_QUOTES) . "'><br><br>";
	echo "PI(s)<input name='pi' ' size='100'  value='" . htmlspecialchars($pi, ENT_QUOTES) . "'><br><br>";
	
	echo "Index/Subject(s): <input name='subject' size='100' value='" . $subject . "'><br><br>";
	
	echo "Restricted: <input name='restricted' value='" . $restricted . "'> ";
	echo "SDA: <input name='sda' value='" . $sda . "'><br>";
	echo "Varsarch: <input name='varsrch' value='" . $varsrch . "'> ";
	echo "Mobility Data: <input name='mobilityData' value='" . $mobilityData . "'><br>";
	echo "Eve Fielder Collection: <input name='eveFielderCollection' value='" . $eveFielderCollection . "'> <br><br>";
	echo "Web Link: <input name='www' value='" . $www . "'>  ";
	echo "Citation: number:<input name='citenum' value='" . $citenum . "'><br>";
	echo "Citation: <input name='cite_text' value='" . htmlentities($cite_text, ENT_QUOTES) . "'><br>";
	echo "Just-on-CD<input name='justonCD' value='" . $justonCD . "'> ";
	echo "<input name='article' value='" . $article . "'> ";
	
	//echo "<input name='pi' value='" . htmlspecialchars($pi, ENT_QUOTES) . "'> ";
	
	//echo "<input name='subject' value='" . $subject . "'> ";
	echo "Number of studies: <input name='numstudies' value='" . $numstudies . "'> ";
	echo "Don't display: <input name='dontdisplay' value='" . $dontdisplay . "'><br> ";
	echo "ICPSR country: <input name='icpsrcountry' value='" . $icpsrcountry . "'> <br>";
	echo "ICPSR link: <input name='icpsrlink' value='" . $icpsrlink . "'> ";	
	echo "DateAdded: <input name='dateadded' value='" . $dateadded . "'><br> ";
	echo "DateUpdated: <input name='lastupdated' value='" . $lastupdated . "'> ";	
	echo "</form>";
	

 
 // close the connection
	$PDO_connection = null;
	
	session_destroy();
	
	?>

</div> 

<div id="pageFooter" style="margin-left: 0; text-align: center; background-color: white;"></div>
</body></html>