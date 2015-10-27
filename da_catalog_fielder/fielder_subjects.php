<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>
<head><title>Eve Fielder Library Test</title>
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1 id="siteName"><a href="../index.php"><img src="../_images/logo75.jpg" width="75" height=""></a> Social Science Data Archive: Eve Fielder Collection</h1> 
 
 <div id="container">

<?php  include("../SSDA_menubar.php");    ?>
<!-- -----------------------------------------
SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
------------------------------------------ -->
<!-- end masthead --> 

<H1 align="center">Subjects/Indices That Begin With The Letter...</H1><br>

 <?php
	
	$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
	
	//include the login file - ISSRDA_login.php
	// data archive in-house login
	include("../da_catalogLib/ISSRDA_login.php");
	
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	// select distinct ucase(left(title.Title,1)) as index_letter, count(*) as index_letter_count from da_catalog.title where ucase(left(title.Title,1)) regexp '^[A-Za-z]' and title.Restricted <> "*" group by index_letter;
	
	 $query = "select fielderSubjectFull.*, Left(fielderSubjectFull.subject,1) AS firstLetterIndex from fielderSubjectFull order by firstLetterIndex;";
	 
	 
	 
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query);
	 // PDO - execute the query
	 $result = $PDO_query->execute();
	 
	 if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}
		
		$indexList=array();
		// first letter of indext term list
		$indexFirstLetterList=array();
	 
		//echo "<table id='alphaList' align='center'> ";
		//echo "<tr>";  // start a row
		
		$itemCount = 1;	  // count off the number of items in the alpha-block, 5 letters across
		
		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
			$indexList[$row_index]["subject"] = $row['subject'];
			$indexList[$row_index]["subjectID"] = $row['subjectID'];
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
					
	 		$subject = $indexList[$row_index]["subject"];
			$subjectID = $indexList[$row_index]["subjectID"];
			$firstLetterIndex = $indexList[$row_index]["firstLetterIndex"];
			
			if ($firstLetterIndex == $value) {
						
				//echo $author . "<br>";
				echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_bySubjectList.php?subject=" . $subject . "&subjectID=" .  $subjectID . "'>" . $subject  . "</a></li>";
				
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
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
		
	?>
 </div>
  


  </body></html>