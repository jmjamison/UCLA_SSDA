<html>
<head><title>Study Titles: Alpha list</title>
<link rel="stylesheet" href="file:///C|/Documents and Settings/data archive/Application Data/SSH/temp/2col_leftNav.css" type="text/css">
<style type="text/css">
<!--
.style1 {color: #333333}
body {
	background-color: #FFFBEC;
}
.style2 {
	font-size: large;
	font-weight: bold;
}
.style5 {color: #333333; font-weight: bold; }
-->
</style>
</head>
<body>
<div id="content" align="center">

 <?php
	
	$sscnetHTTP = "http://www.sscnet.ucla.edu/issr/da/da_catalog/";
	$mydestopHTTP = "http://localhost/da_catalog/";
	$currentHTTP = $sscnetHTTP;
	
	//include the login file - db_login.php
	//include('../db_login2.php');
	//include('ISSRDA_login.php');
	// set the include file
	//include the login file - db_login.php
	$sscnetInclude = "ISSRDA_login.php";
	$mydesktopInclude = "../db_login2.php";
	$currentInclude = $sscnetInclude;
	include($currentInclude); 
	
	// for desktop test system
	$db_name="ISSRDATEST";	
	
		
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	
	$query = "select ID, StudyNum, DTAfile FROM fileinfo_nu";
	
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query);
	 
	 // PDO - execute the query
	$PDO_query->execute();
	if (!$PDO_query) { 
		die ("Could not query the database: <br />". mysql_error());  } 
	// close query cursor
	//$PDO_query->closeCursor();
	
	
	$fixDTAfile = array();
	$row_index = 0;
	
	while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		
		$fixDTAfile[$row_index]["fileinfoID"] = $row["ID"];
		$fixDTAfile[$row_index]["studynumber"] = $row["StudyNum"];
		$fixDTAfile[$row_index]["dtafilename"] = $row["DTAfile"];
		
		
		$studynumber = $fixDTAfile[$row_index]["studynumber"];
		$dtafilename = $fixDTAfile[$row_index]["dtafilename"];
		$fileinfoID = $fixDTAfile[$row_index]["fileinfoID"];
		
		//$studynumber = $row["StudyNum"];
		//$dtafilename = $row["DTAfile"];
		
		// start at beginning (0) and take first 3
		$part_1 = trim(substr($dtafilename, 0, 3));
		
		//  start after the first 3 and take the rest
		$part_2 = trim(substr($dtafilename, 3));
		
		$dtafilename_nu = "DTA" . $part_1 . ".file". str_pad($part_2, 4, "0", STR_PAD_LEFT);
		$fixDTAfile[$row_index]["dtafilename_nu"] = $dtafilename_nu;
		
		echo "ID=" . $fileinfoID . " and study number=" . $studynumber . ": original dtanumber = "  . $dtafilename . "; new dtafilenumber = " . $dtafilename_nu . "<br>";
		
		
		
			$row_index++;
		}
		
		$fixDTAfileCount = count($fixDTAfile);
		echo "row count = " . $fixDTAfileCount . "<br><br>";
		
		// PDO connect  //$fixDTAfile = array();
		//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
		$db_name="ISSRDATEST";	
		$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
		// echo "$PDO_string<br>";
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
		
		//$query_update_title = "UPDATE title SET Title=" . $title . ", Restricted=" . $restricted . ", LastUpdated=" . $lastupdated . ", SDA=" . $sda .  ", Varsrch=" . $varsrch . ", JustOnCD=" . $justonCD . ", mobilityData=" . $mobilityData . ", eveFielderCollection=" . $eveFielderCollection . " where StudyNum =" . $studynumber;
		
		//mysql_query("UPDATE Persons SET Age = '36' WHERE FirstName = 'Peter' AND LastName = 'Griffin'");
		
		for ($row_index=0; $row_index < $fixDTAfileCount; $row_index++) {
			
			$fileinfoID = $fixDTAfile[$row_index]["fileinfoID"];
			$studynumber = $fixDTAfile[$row_index]["studynumber"];
			$dtafilename = $fixDTAfile[$row_index]["dtafilename"];
			$dtafilename_nu = $fixDTAfile[$row_index]["dtafilename_nu"];
			
			
			//echo $row_index . "  " . $studynumber . ": original dtanumber = "  . $dtafilename . "; new dtafilenumber = " . $dtafilename_nu . "<br>";			
			
			$queryFixDTAfile = "UPDATE fileinfo_nu SET dtafilename='" . $dtafilename_nu . "' WHERE ID='" . $fileinfoID . "'";
			echo $studynumber . " " . $queryFixDTAfile . "<br>";			
			// prepare query
			
			$PDO_query = $PDO_connection->prepare($queryFixDTAfile);
			// execute query
			$PDO_query->execute();
			if (!$PDO_query) { 
				die ("Could not query the database: <br />". mysql_error());  } 
			// close query cursor
			$PDO_query->closeCursor();
		
		}
	
	// close the connection
		// mysql_close($connection);		
		$PDO_connection = null;
		
	
		
	?>
 </div>
  </body></html>