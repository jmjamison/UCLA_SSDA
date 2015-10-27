<html>
<head><title>Study Titles: ALpha list</title>
<link href="../da_catalogLib/2col_leftNav.css" rel="stylesheet" type="text/css">
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
<!--<a href="http://dataarchives.ss.ucla.edu/">Back to main</a>&nbsp;-&nbsp;-&nbsp;<a href="http://dataarchives.ss.ucla.edu/da_catalog_index.php">Data Archive: Index</a><br> -->

<div id="masthead">
         <h1 id="siteName">Social Science Data Archives</h1> 

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

    
<div id="content">
<?php
	
	$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
	$currentHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
	
	//include the login file - ISSRDA_login.php
	// data archive in-house login
	include("../da_catalogLib/ISSRDA_login.php");
	//$currentInclude = $sscnetInclude;
	//include($currentInclude); 
		
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	
	// check, if NOT set 
	if (!isset($_GET['searchTerm'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
		
	
	 
	$searchTerm =  $_GET['searchTerm']; 
	echo "Search term(s): " .  $searchTerm . "<br>";
	
	// sql query statement   fielderBibRecord.ID, fielderSubjectCode.*, ,  fielderSubjectCode.subjectID as subjectConnect,  fielderAuthorCode.*

 $query_createTempStuff = "create temporary table temp_searchStuff  (select fielderBibRecord.title, fielderBibRecord.ID as recordID, fielderSubjectFull.subject as subject, fielderAuthorFull.author  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID)";
 
 
	// echo "query: " . $query_createTempStuff . "<br>";
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query_createTempStuff);
	 // PDO - execute the query
	 $result = $PDO_query->execute();

	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	else { "created temp table<br>"; }
	
	
	$query_searchStuff = "select title, recordID, author, subject from temp_searchStuff where ((title like '%" . $searchTerm . "%') or (author like '%" . $searchTerm . "%') or (subject like '%" . $searchTerm . "%')) order by title";
	
		
	 // echo "<br>Query statement: " .  $query_searchStuff . "<br>";
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query_searchStuff);
	 
	 // PDO - execute the query
	 $result = $PDO_query->execute();
	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	
	
	echo "<H1>Results of Search in Data Archives Studies</H1><br>";
	
	echo "<ul>";
	$row_index = 0;

		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		
			$title = $row[ "title" ];
			$recordID = $row["recordID"];
			
			//echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "da_catalog_titleRecord.php?studynumber=$studynum&title=$title'>$title</a></li>";
			//echo cho "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "da_catalog_titleRecord.php?ID=$recordID'>" . $title  . "</a></li>";
			
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_titleRecord.php?ID=" . $recordID . "'>" . $title . "</a></li>";
			
			//  
			
			$row_index++;
			
		}
	echo "</ul>";
	if ($row_index < 1) {
			
			echo "<li class='alphaTitleList'>No items found for search term: $searchTerm</li>";
			
	}
	
	
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	?>
    
 </div> <!-- end content-->
 
<div id="navBar"><div class="relatedLinks">
  <h3>Search By: </h3>
   <ul><h3>
    <li> <a href="../da_catalog_fielder/fielder_subjects.php" title="Search by index terms">Index Terms</a></li>
    <li> <a href="../da_catalog_fielder/fielder_titles.php" title="Search by study titles">Titles</a></li>
    <li> <a href="../da_catalog_fielder/fielder_authors.php" title="Search by study titles">Authors</a></li>
    <li> <a href="../da_catalog_fielder/fielder_search.php" title="Search Database">Keyword or Term</a></li></h3>
  </ul></div>
 </div>   <!--end navbar-->

</body></html>
