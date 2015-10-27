<html>
<head><title>Eve Fielder Library Test</title>
<link rel="stylesheet" href="../da_catalog/2col_leftNav.css" type="text/css">
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
<div id="masthead">
         <h1 id="siteName">Social Science Data Archive</h1> 

<div id="globalNav"><div id="breadCrumb">
             <a href="http://dataarchives.ss.ucla.edu/">Archive Home</a>|
             <a href="http://dataarchives.ss.ucla.edu/da_catalog/">Archive Data Catalog </a>|
             <a href="http://dataarchives.ss.ucla.edu/tutor/index.html">Archive Tutorial </a>|
             <a href="http://dataarchives.ss.ucla.edu/resource.htm">Archive Resources </a>|
             <a href="http://www.icpsr.umich.edu">ICPSR</a>|
             <!--<a href="http://www.sscnet.ucla.edu/issr/index.html">ISR Home </a>| -->
             <a href="http://www.ucla.edu/index.html">UCLA Home </a></div>
		
         </div>
</div> <!--end masthead--><!--end masthead-->


<div id="content" align="center">
<H1 align="center">Titles That Begin With The Letter...</H1><br>

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
	
	// NOTE: original query included the Restricted items, 
	
	// sql query statement
	 $query = "select distinct ucase(left(fielderBibRecord.title,1)) as index_letter, count(*) as index_letter_count from fielderBibRecord where ucase(left(fielderBibRecord.title,1)) regexp '^[A-Za-z]'  group by index_letter";
	 
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query);
	 // PDO - execute the query
	 $result = $PDO_query->execute();
	 
	 if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}
	
	 
		echo "<table id='alphaList' align='center'> ";
		echo "<tr>";  // start a row
		
		$itemCount = 1;	  // count off the number of items in the alpha-block, 5 letters across
		
		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		// Non-PDO code ---------------------
		//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			$index_letter = $row[ "index_letter" ];
			$index_letter_count = $row["index_letter_count"];
			echo "<td><A HREF= '" . $currentHTTP . "da_catalog_titlesThatBeginWith.php?index_letter=$index_letter'>$index_letter</a>&nbsp;($index_letter_count&nbsp;titles)</td>";
			
			if ($itemCount < 5) {			
			
			$itemCount++;
			}
			
			else { 
				
				echo "</tr>";       // end the row
				echo "<tr>";		// start a new row
				
				$itemCount = 1;
			} 
		}
	echo "</table>";
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
		
	?>
 </div>
 <div id="navBar"><div class="relatedLinks">
  <h3>Search By: </h3>
   <ul><h3>
    <li> <a href="../da_catalog_fielder/da_catalog_subjects.php" title="Search by index terms">Index Terms</a></li>
    <li> <a href="../da_catalog_fielder/da_catalog_titles.php" title="Search by study titles">Titles</a></li>
    <li> <a href="../da_catalog_fielder/da_catalog_authors.php" title="Search by study titles">Authors</a></li>
    <li> <a href="../da_catalog_fielder/da_catalog_search.php" title="Search Database">Keyword or Term</a></li></h3>
  </ul></div>
 </div>   <!--end navbar-->

 </div>   <!--end navbar-->


  </body></html>