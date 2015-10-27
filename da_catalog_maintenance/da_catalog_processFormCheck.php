<?php
// Start the session so I can use $_SESSION variables
session_start();
?>
<html>
<head><title>Data Archive Catalog: Edit</title>
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
<!--  Javascript(s) to 1) paste PI names into text field, 2) clear the text fiels -->
<script language="JavaScript" src="da_catalog.js" type="text/javascript"><!--  da_catalog scripts //--></script>
<!-- end Javascript PI paste and clear -->

</head>
<body>

<!-- link to top of page starts here -->
<!-- link to top of page ends here -->

<div id="pageHeader" style="margin-left: 0; text-align: center">
<h1>UCLA Institute for Social Research Data Archives<br><br>Check Record</h1>
</div>
 
<div id="citation" style="margin: 30; text-align: left; background-color: white;">

<form action="da_catalog_edit.php" method="post" name="editRecord" target="_self">
<input name='submitRecord' type='submit' value='Continue editing this record'>
<input type='hidden' name='studynumber' value='<?php echo $studynumber ?>'>
<h2 align="left" id="siteName">Continue to Edit this Record</h2>
</form> 
   <?php
		
	// 13 March 2010 setup the GIT source control archive - jmj 
	//
	$sscnetHTTP = "http://www.sscnet.ucla.edu/issr/da/da_catalog/";
	$sscnetHTTP_maintenance_test = "http://www.sscnet.ucla.edu/issr/da/da_catalog_maintenance_test/";
	$sscnetHTTP_maintenance_live = "http://www.sscnet.ucla.edu/issr/da/da_catalog_maintenance/";
	$mydestopHTTP = "http://localhost/da_catalog/";
	$currentHTTP = $sscnetHTTP_maintenance_live;
	
	$sscnetInclude = "ISSRDA_login.php";
	$currentInclude = $sscnetInclude;
	include($currentInclude); 
	
	// for desktop test system
	//$db_name = "da_catalog";	
	
	
	// PDO connect  
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
	try	{
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password); 
		
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
	$requestCategory = $_POST['requestCategory'];
	$table_name = $_POST["table_name"];
	$requestType = $_POST['requestType'];
	$item_id = $_POST['item_id'];
	$item_subsort = $_POST["item_subsort"];  // this is either pi/tisubsort or subject/subsort - they have different names
	$item_subsort_fieldname = $_POST['item_subsort_fieldname'];
	
	switch($requestType) {
		// only thing to update here is the sort order for pi or subject
		case 'Update sort number':
			//
			echo "You asked to " . $requestType . " a " . strtoupper($requestCategory) . ", " . $requestCategory  . "code id: " . $item_id . "<br>";
			// either or both - update the sort number and/or the text of the pi or the subject
			$updateSortOrderQuery = "UPDATE " . $table_name . " SET " . $item_subsort_fieldname . "=" . $item_subsort . " WHERE ID=" . $item_id . " LIMIT 1";
			echo $updateSortOrderQuery . "<br>";
			
			// prepare query
			$PDO_query = $PDO_connection->prepare($updateSortOrderQuery);
			// execute query
			$PDO_query->execute();
			if (!$PDO_query) { die ("Could not query the database: <br />". mysql_error()); } 	 
			// close query cursor
			$PDO_query->closeCursor();
			
			break;
			
		case 'UpdateAll':
			//
			echo "You asked to " . $requestType . " a " . strtoupper($requestCategory) . ", id: " . $item_id . "<br>";
			
			break;
		
		// delete linkage to the pi or subject
		case 'Delete link':
			//
			echo "You asked to " . $requestType . " a " . strtoupper($requestCategory) . ", " . $requestCategory . "code id: " . $item_id . "<br>";
			
			// the TABLE in this case is shcode or picode
			$deleteQuery = "DELETE FROM " . $table_name . " WHERE ID=" . $item_id . " LIMIT 1";
			echo $deleteQuery . "<br>";
				
			// prepare query
			$PDO_query = $PDO_connection->prepare($deleteQuery);
			// execute query
			$PDO_query->execute();
			if (!$PDO_query) { die ("Could not query the database: <br />". mysql_error()); } 	 
			// close query cursor
			$PDO_query->closeCursor();
			
			break;
			
		case 'Add':
			//
			echo "You asked to " . $requestType . " a " . strtoupper($requestCategory) . ", id: " . $item_id . "<br>";
			break;
		
	}
		
	echo "<br><br>";
	//------------------------------
	// check that studynumber does't exist - run a select query on the studynumber <-- which has to be unique
	//      if the studynumber is a dup, will have to rename it or otherwise straighten this out before adding the record
	//------------------------------    
	
			$query_check_title = "select StudyNum from title where StudyNum = '" . $studynumber . "'";
			
			echo $query_check_title . "<br>";
			
			// PDO - create prepared statement: get the table.pifull
 			// --------------------------------------------------------
			$PDO_query = $PDO_connection->prepare($query_check_title);
			// PDO - execute the query
			$result = $PDO_query->execute();
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				
				} 	
			
			//$result = $PDO_query->fetch(PDO::FETCH_ASSOC);
			// print_r($result);
			echo "<br>current studynumber being added: ". $studynumber;
			echo "<br>request type: " . $requestType;
			echo "<br>request category: " . $requestCategory;
			echo "<br>item id: " . $item_id;
			echo "<br>"; 
			echo $HTTP_POST_VARS['item_id'];
			echo "<br>"; 
			if ($result) { 
				echo "NOTE!! " . $studynumber . " exists"; 
				} elseif (!$result) { 
				echo $studynumber . " does NOT exist."; 
				}
				
	
	//-----------------------------------------------------------------
	//   pick up the other variables used in the title table
	//-----------------------------------------------------------------
	
	// title.restricted is used for all instances of restricted or dontdisplay
	if (isset($_POST['restricted'])) {
	$current_restricted = $_POST['restricted'];
	// note - pick this up from title.restricted
		echo "<br>$restricted";
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
	// 
	
	if (isset($_POST['tisort'])) {
		$tisort = $_POST['tisort'];
		//$tisort = "";
		echo "<br>$tisort";   // title table (studynumber, title, etc) connecting field to picode, shcode
	} else {
		$tisort = "";
	}
		
	if (isset($_POST['sda'])) {
		$sda = $_POST['sda'];
		echo "<br>$sda";
	} else { $sda = "";	}
	if (isset($_POST['varsrch'])) {
		$varsrch = $_POST['varsrch'];
		echo "<br>$varsrch";
	} else { $varsrch = ""; }
	if (isset($_POST['justonCD'])) {
		$justonCD = $_POST['justonCD'];
		echo "<br>$justonCD";
	} else { $justonCD= ""; }
	if (isset($_POST['mobilityData'])) {
		$mobilityData = $_POST['mobilityData'];
		echo "<br>$mobilityData";
	} else { $mobilityData= ""; }
	if (isset($_POST['eveFielderCollection'])) {
		$justonCD = $_POST['eveFielderCollection'];
		echo "<br>$eveFielderCollection";
	} else { $eveFielderCollection= ""; }
	
	
	//substr($studyNum, 0, (strlen($studynumber) - (strlen(strstr($studyNum, "V")))));
	$www = substr($studynumber, 0, (strlen($studynumber) - (strlen(strstr($studynumber, "V")))));
	echo "<br>$www";
	
	$citenum = substr($studynumber, 0, (strlen($studynumber) - (strlen(strstr($studynumber, "V")))));
	echo "<br>$citenum";
	
	if (isset($_POST['cite_title'])) {
		$cite_title = $_POST['cite_title'];
		echo "<br>$cite_title";
	} else { $cite_title= ""; }
	
	if (isset($_POST['cite_subsort'])) {
		$cite_subsort = $_POST['cite_subsort'];
		echo " - subsort: $cite_subsort";
	} else { $cite_subsort= ""; }
	
	
	
	// was the field to hold the gramatical article - the, a , an - not set or currently used
	//$article = $_POST['article'];
	//$article = "";
	//$title = $_POST['title'];
	//
	//$title = "Process Evaluation of the Comprehensive Communities Program in Selected Cities in the United States, 1994-1996";

	echo "<br>Studynumber: $studynumber <br>";
	
	if ($restricted == "*") {echo "restricted IS set<br>";}
	if ($sda == "*") {echo "SDA IS set<br>";}
	if ($varsrch == "*") {echo "Varsrch IS set<br>";}
	if ($justonCD == "*") {echo "Just-On-CD IS set<br>";}
	if ($mobilityData == "*") {echo "Mobility-Data IS set<br>";}
	if ($eveFielderCollection == "*") {echo "Eve-Fielder-Collection IS set<br>";}
	
	if ($www != "") { echo "www ($www) is set<br>"; }
	if ($citenum != "") { echo "citenum ($citenum) is set<br>";  }
	if ($cite_title != "") { echo "citation title-level ($cite_title) is set<br>";  }
	echo "<br>";
	
	// --------------------------------------------------------
		// PDO - create prepared statement: get the table.title
 		// --------------------------------------------------------
		$query_for_tisort = "select tisort from title where StudyNum = '" . $studynumber . "'";
		// PDO - create prepared statement: get the table.pifull
 		// --------------------------------------------------------
		$PDO_query = $PDO_connection->prepare($query_for_tisort);
		//$result = $PDO_query->execute();
		$result = $PDO_connection->query($query_for_tisort);
	  		if (!$result ) {
				die ("Could not find the table key<br />". mysql_error());
				} 	echo "got title table key, woopie!";
		
		// there should only be one - the key, title key or tisort, is unique
		echo "<br>";
		$row = $result->fetch(PDO::FETCH_ASSOC);
		echo "<br>row: ";
		// print_r($row);
		echo "<br>";
		$tisort = $row["tisort"];
		echo "<br>";
		echo "table key/tisort: " . $tisort;
		echo "<br>";
		
	//----------------------------------------------------------------------------------
	// picode - check if the tisort exists
	//----------------------------------------------------------------------------------	
	$piListFull = array();	
	$row_index = 0;
	$query_checkPicode = "SELECT *  FROM picode WHERE tisort like '" . $tisort . "' order by tisubsort";
	echo "<br>" . $query_checkPicode . "<br>";
	
		// prepare query
		$PDO_query = $PDO_connection->prepare($query_checkPicode);
		// execute query
		$PDO_query->execute();
		// fetch query
		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC)) {
			
			
			$piListFull[$row_index]["tisubsort"] = $row["tisubsort"];
			$piListFull[$row_index]["picode"] = $row["picode"];
			
			$row_index++;
			
		}
		
		//print_r($piListFull);
		sort($piListFull);
		// print_r($piListFull);
		echo "<br>";
		
		$piListFullCount = count($piListFull);
		echo "<br>" . $piListFullCount . "<br>";
		
		// close query cursor
		$PDO_query->closeCursor();
		
		//--------------------------------------
		//    print out the list of existing PIs
		
		$last_tisubsort = "";   
		
		for ($row_index = 0; $row_index < $piListFullCount; $row_index++) {
			
			
			$tisubsort = $piListFull[$row_index]["tisubsort"];
			$picode = $piListFull[$row_index]["picode"] ;
			
			echo "tisubsort number: " . $tisubsort . "; picode: " . $picode .  "<br>";
			
			$last_tisubsort = $tisubsort;   // just write over each time
			
		}
		
		$last_tisubsort++;
		
		echo "Next tisubsort number to be addded:  " . $last_tisubsort; 

	// PDO - create prepared statement: get the title.tisort 	
	//----------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------
	// pifull - the principle investigator table
	// create the PI array of one or more principle investigator names
	//    the insert will happen when after ok-ing the record
	//----------------------------------------------------------------------------------	
	
	$pi = $_POST['pi_new'];
	echo "<input type='hidden' name='pi_new' value='" . $pi_new . "'> ";
	//$piList = explode(";", $pi);
	//$totalPI = count($piList);
	
	//print_r($piList);
	//echo "<br>total PIs = $totalPI<br>";
	
	//echo "<br>" . $piList . "<br>" . $totalPI . "<br>";
	
	//$final_ti_subsort = 0;
	//for ($row_index = 0; $row_index < $totalPI; $row_index++) {
		
			// there is only one pi because you are adding one per line in the edit menu
		
			//$individual_pi = trim($piList[$row_index]);  // NEED TO USE TRIM - otherwise spaces can throw off the search
			//echo "<br>current pi [" . $row_index . "]: " . $individual_pi;	
			
			echo "<br>Update this  pi: " . $pi_new . "<br>";
			
			// SELECT pifull1.pi, pifull1.picode, picode1.tisubsort FROM pifull1 INNER JOIN picode1 ON pifull1.picode = picode1.picode WHERE (((pifull1.pi)="Meisel, John"));
			
			//$query_checkPIdups = "SELECT pi, picode FROM pifull WHERE pi like '" . $individual_pi . "'";
			
			$query_checkPIdups = "SELECT piful1.pi, piful1.picode, picode.tisubsort FROM pifull INNER JOIN picode ON pifull.picode = picode.picode WHERE pi like '" . $pi_new . "' ORDER BY picode.tisubsort;";
			
			echo "<br>" . $query_checkPIdups . "<br>";
			
				// prepare query
				$PDO_query = $PDO_connection->prepare($query_checkPIdups );
				// execute query
				$PDO_query->execute();
				
				
				// fetch query
				while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC)) { //
				
				
				
	  			if ((!$row ) || empty($result)) { 	// $result is FALSE, record not found or rather doesn't exist
						echo "<br>Could not find record for " . $individual_pi . " - add "  . $individual_pi .   "  pi table (pifull)<br />";
						
						$pi_tisubsort = 1;
						$picode = "";  // not in table so the $picode won't exist
						
						
						} 	//echo "found record/!";
						
				elseif ($row) { // $result is TRUE, record round
			
					// there should only be one - the key, title key or tisort, is unique
					//echo "<br>";
					
					
					//echo "<br>row: ";
					// print_r($row);
					$picode = trim($row["picode"]);
					$pi_tisubsort = trim($row["pi_subsort"]);
					$checkPI = trim($row["pi"]);
					echo "<br>" . $pi_tisubsort . " pi: " . $checkPI . " [picode: " . $picode . "]: exists in pi table (pifull).<br>";
				
				
			
				}  // end if-elseif-loop
				
				
				// close query cursor
				$PDO_query->closeCursor();
				
				
				$final_ti_subsort .= $pi_tisubsort;
				echo "<br>" . $final_ti_subsort . "<br>";
			
		
	//} // end for-loop through piList
	
	} // end of the while-loop
		
	
			

	
  		// --------------------------------------------------------
		
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	// -------------------------------------------------------------------------------
	
	
	
	echo "<br><A HREF='javascript:javascript:history.go(-1)'>Click here to go back to previous page</A><br>";
	echo "";
	echo "<form action='da_catalog_updatePI.php' method='post' target='_self'>";
	echo "<input type='hidden' name='studynumber' value='" . $studynumber . "'> ";
	echo "<input type='hidden' name='restricted' value='" . $restricted . "'> ";
	
	echo "<input type='hidden' name='dateadded' value='" . $dateadded . "'> ";
	echo "<input type='hidden' name='lastupdated' value='" . $lastupdated . "'> ";
	echo "<input type='hidden' name='sda' value='" . $sda . "'> ";
	echo "<input type='hidden' name='varsrch' value='" . $varsrch . "'> ";
	

	echo "<input type='hidden' name='mobilityData' value='" . $mobilityData . "'> ";
	echo "<input type='hidden' name='eveFielderCollection' value='" . $eveFielderCollection . "'> ";
	echo "<input type='hidden' name='www' value='" . $www . "'> ";
	echo "<input type='hidden' name='justonCD' value='" . $justonCD . "'> ";
	
	echo "<input type='hidden' name='pi_new' value='" . $pi_new . "'> ";
	echo "<input type='hidden' name='last_tisubsort' value='" . $last_tisubsort . "'> ";
	
	
		
	echo "<input name='submitRecord' type='submit' value='Submit Record'></form>"
	
	
?>
</div> 

<div id="pageFooter" style="margin-left: 0; text-align: center; background-color: white;"></div>
</html>