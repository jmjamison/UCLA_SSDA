<?php
	error_reporting(0);
?>

<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="GENERATOR" content="Mozilla/4.7 [en] (Win98; U) [Netscape]">
<title>Data Archive Catalog: Edit/Update Check</title>
<!--<link rel="stylesheet" href="2col_leftNav.css" type="text/css"> -->
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">

</head>
<body text="#000000" bgcolor="#FFFFFF" link="#0000EE" vlink="#551A8B" alink="#FF0000">

<!-- link to top of page starts here -->
<!-- link to top of page ends here -->

<div id="pageHeader" style="margin-left: 0; text-align: center">
<h1>UCLA Institute for Social Research Data Archives<br><br>Check Record</h1>
</div>
 
<div id="citation" style="margin: 30; text-align: left; background-color: white;">

    <?php
	
	//------------------------------------------------------------------------------------
	//
	//    this page checks the variables, echos out whats set - so the dataentry can be checked, returned back to the input script, etc before
	//         actually doing the insert.  the page can be printed out as a record
	//         eventual updates will be to the title and cite tables
	//
	//-------------------------------------------------------------------------------------
	
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_maintenance/";	
	//include("../_includes/SSDA_librarydatabase_edit.php"); 
	// below links to the test version of the database, for testing
	include("../_includes/SSDA_librarydatabase_test_edit.php"); 
	
	
	
	// PDO connect  
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
	try	{
		$PDO_connection = new PDO($PDO_string, $db_username_edit, $db_password_edit); 
		
		} catch(PDOException $e)	{
			echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
			die();
			}
		
	$current_query = "";
	$result = "";
		
	//   First insert into 3 tables: title, pifull (principle investigator(s)), shfull (subject/keyword(s))	 strtoupper  
	
	//----------------------------------------------------------------------------------
	//   title table
	//----------------------------------------------------------------------------------
	// $tisort is the title table key, auto-imcrementd, set at insert
	$studynumber = strtoupper($_POST['studynumber']);
	
	//------------------------------
	// check that studynumber does't exist - run a select query on the studynumber <-- which has to be unique
	//      if the studynumber is a dup, will have to rename it or otherwise straighten this out before adding the record
	//------------------------------    
	
			// PDO - create prepared statement
	 		//$PDO_query = $PDO_connection->prepare($queryBaseRecord);
	 
			//$PDO_query->bindValue(":studynumber", $studynumber,  PDO::PARAM_STR);
			//$PDO_query->bindValue(":title", $title,  PDO::PARAM_STR);
	 
	 		// PDO - execute the query
			 //$result = $PDO_query->execute();

			// --------------------------------------------------------
			
			$query_check_title = "select StudyNum from title where StudyNum = '" . $studynumber . "'";
			// PDO - create prepared statement: get the table.pifull
			
			$PDO_query = $PDO_connection->prepare($query_check_title);
			// PDO - execute the query
			$result = $PDO_query->execute();
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				} 	
			
			$result = $PDO_query->fetch(PDO::FETCH_ASSOC);
			//print_r($result);
			//echo "<br>current studynumber being added: ". $studynumber;
			//echo "<br>"; 	
			if ($result) { 
				//echo $studynumber . " exists"; 
				} elseif (!$result) { 
				echo $studynumber . " does not exist"; 
				}
				
	
	//-----------------------------------------------------------------
	//   pick up the other variables used in the title table
	//-----------------------------------------------------------------
	
	// title.restricted is used for all instances of restricted or dontdisplay
	if (isset($_POST['restricted'])) {
	$current_restricted = $_POST['restricted'];
	// note - pick this up from title.restricted
		//echo "<br>$restricted";
	}	else {
		$current_restricted = "";
	}
	
	if (isset($_POST['dataverseDOI'])) {
	$dataverseDOI = $_POST['dataverseDOI'];
	// note - pick this up from title.restricted
		//echo "<br>$restricted";
	}	else {
		$dataverseDOI = "";
	}
	
	$dontdisplay = $current_restricted;
	//$dontdisplay = "";
	// note - pick this up from title.restricted
	$restricted = $current_restricted;
	
	
	// ------------------------------------------------------------------------------------------------
	//
	//  check to see if these variables are set and echo out the values if they are set
	//
	// ------------------------------------------------------------------------------------------------
	$lastupdated = date('Y-m-d h:i:s');  // format for the editing/update screen - pull todays date for the update
	//echo "<br>updated: " . $lastupdated . "<br>";
	
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
		//echo "<br>$justonCD";
	} else { $justonCD= ""; }
	
	if (isset($_POST['mobilityData'])) {
		$mobilityData = $_POST['mobilityData'];
		//echo "<br>$mobilityData";
	} else { $mobilityData= ""; }
	
	if (isset($_POST['eveFielderCollection'])) {
		$justonCD = $_POST['eveFielderCollection'];
		//echo "<br>$eveFielderCollection";
	} else { $eveFielderCollection= ""; }
	
	// citenum connects to title.Cite - so just use that number
	//--------------------------------------------------------------------------------------------------------------------
	//
	// studyNumShort is the studynumber minus the version - V1,  or V#
	// this is used for title.Cite and title.WWW - the connecting fields for citation and wwwlink
	$studynumArray = explode("V", $studynumber);
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
	
	if (isset($_POST['citenum'])) {
		$citenum = $_POST['citenum'];
		//echo "<br>citenum connector: " . $citenum;
		} else  {
			$citenum = $studyNumShort;
			//echo "<br>citenum connector: " . $citenum;
			}	
	
	//--------------------------------------------------------------------------------------------------------------------
	
	if (isset($_POST['citeID'])) {
		$citeID = $_POST['citeID'];
		//echo "<br>$citeID";
	} else { $citeID= ""; }
	
	if (isset($_POST['cite_text'])) {
		$cite_text = $_POST['cite_text'];
		//echo "<br>$cite_text";
	} else { $cite_text= ""; }
	
	if (isset($_POST['cite_subsort'])) {
		$cite_subsort = $_POST['cite_subsort'];
		//echo "<br>$cite_text";
	} else { $cite_subsort= ""; }
	
	
	// was the field to hold the gramatical article - the, a , an - not set or currently used
	$article = $_POST['article'];
	//$article = "";
	//$title = $_POST['title'];
	// addslashes fixes situation where the title string includes special characters
	$title = htmlspecialchars($_POST['title']); 
	
	echo "<h2>Fields updated or set for " .  $studynumber  .  "</h2>";	
	echo "<br><strong>title:</strong> " . $title . "<br><br>";
	
	
	echo "<strong>Fields set:</strong><br>";
	
	if ($restricted == "*") {echo "restricted<br>";}
	if ($sda == "*") {echo "SDA<br>";}
	if ($varsrch == "*") {echo "Varsrch<br>";}
	if ($justonCD == "*") {echo "Just-On-CD<br>";}
	if ($mobilityData == "*") {echo "Mobility-Data<br>";}
	if ($eveFielderCollection == "*") {echo "Eve-Fielder-Collection<br>";}
	
	if ($www != "") { echo "www ($www)<br>"; }
	if ($citenum != "") { echo "citenum ($citenum) <br>";  }
	if ($cite_text != "") { 
		echo "citation-level: " . $cite_text . "<br>";
		// there is only a single citation for /bib/base records
		echo "citation sort number: " . $cite_subsort;
		}
	//echo "<br>";
	
	
  	//-------------------------------------------------------------------------------
		
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	//-------------------------------------------------------------------------------
	//$escaped_html=htmlentities($str,ENT_QUOTES); 
	
	
	echo "<br><A HREF='javascript:javascript:history.go(-1)'>Click here to go back to editing page page</A><br>";
	echo "";
	echo "<form action='da_catalog_update.php' method='post' target='_self'>";
	echo "Edit below or <input name='submitRecord' type='submit' value='Submit Record'><br><br>";
	echo "Study number: <input name='studynumber' value='" . $studynumber . "'><br>";
	echo "Title: <input size='100' name='title' value='" . htmlentities($title, ENT_QUOTES) . "'><br><br>";
	echo "DataverseDOI: <input size='100' name='dataverseDOI' value='" . $dataverseDOI . "'><br><br>";
	
	// there is only a single citation for title/bib/base records
	echo "<input name='cite_subsort' value='" . $cite_subsort . "'> ";
	echo "<input name='citeID' value='" . $citeID . "'> ";
	echo "Citation ID number: <input name='citenum' value='" . $citenum . "'> ";
	echo "<input name='cite_subsort' value='" . $cite_subsort . "'> ";
	echo "Citation: <input name='cite_text' value='" . htmlentities($cite_text, ENT_QUOTES) . "'><br><br>";
	
	echo "<input name='restricted' value='" . $restricted . "'> ";
	echo "<input name='sda' value='" . $sda . "'> ";
	echo "<input name='varsrch' value='" . $varsrch . "'><br><br> ";
	
	
	echo "<input name='mobilityData' value='" . $mobilityData . "'> ";
	echo "<input name='eveFielderCollection' value='" . $eveFielderCollection . "'> ";
	echo "<input name='www' value='" . $www . "'> ";
	echo "<input name='justonCD' value='" . $justonCD . "'> ";
	echo "<input name='article' value='" . $article . "'> ";
	echo "<input name='lastupdated' value='" . $lastupdated . "'> ";
	
	
	
		
	echo "</form>";
	
	
?>

</div> 

<div id="pageFooter" style="margin-left: 0; text-align: center; background-color: white;"></div>
</html>