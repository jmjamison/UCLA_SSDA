<html>
<head><title>Data Archives Catalog - Index Terms</title>
<link rel="stylesheet" href="../2col_leftNav.css" type="text/css">
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">

</head>
<body>


<div id="content">
<H3 align="center">DTA filenumbers</H3>
 
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
	//$db_name = "da_catalog";	
	
		
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	// sql query statement  

	// NOTE: original query did not exclude the Restricted items
	// $query = "select title.Title, title.StudyNum, shfull.subject, Left(shfull.subject,1) AS firstLetterIndex, count(*) as titlePerSubjectCount FROM (title INNER JOIN shcode ON title.tisort = shcode.tisort) INNER JOIN shfull ON shcode.subjectcode = shfull.subjectcode group by shfull.subject ORDER BY shfull.subject";
	
	// New query excludes items marked Restricted
	
	$query = "select DTAfile, dtafilename FROM fileinfo";
	
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query);
	 
	 // PDO - execute the query
	 $result = $PDO_query->execute();
	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	
	//  build the first letter list
	echo "<h2  align='center'>";
	
	// the index term list
	$dtafilenumberList=array();
	
	

    
	$row_index = 0;
	while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		
		
		$dtafilenumberList[$row_index]['DTAfile'] = $row['DTAfile'];
		$dtafilenumberList[$row_index]['dtafilename'] = $row['dtafilename'];
		
		
		
         
		
	 	$row_index++;
	 		}
			
		$dtafilenumberListCount = count($dtafilenumberList);
		
		for ($row_index = 0; $row_index < $dtafilenumberListCount; $row_index++) {
			
			$DTAfile = $dtafilenumberList[$row_index]['DTAfile'];
			$dtafilename = $dtafilenumberList[$row_index]['dtafilename'];
			
			echo $DTAfile . " -- " . $dtafilename . "<br>";
			
			}
		
		
	
		//echo "</select><input type='submit' value='Get Record'>";
		//echo "<input name='title' type='hidden' value='" . $title  . "'>";
		//echo "</form>";
	
		
	
	
		
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	
	//print_r($indexList); 
	//echo "<br>";
	//print_r($indexFirstLetterList);
	?>
</div> 
<!-- end container-->
 

</body></html>