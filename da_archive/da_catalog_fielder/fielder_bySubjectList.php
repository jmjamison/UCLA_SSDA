<html>
<head><title>Eve Fielder Library Test</title>
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

    
<div id="content">
<?php
	
	$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
	$currentHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
	
	//include the login file - ISSRDA_login.php
	// data archive in-house login
	include("../da_catalogLib/ISSRDA_login.php");
	 
	// check, if NOT set 
	if (!isset($_GET['subject'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
		
	if (!isset($_GET['subjectID'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
	 
	$subject =  $_GET['subject']; 
	$subjectID =  $_GET['subjectID']; 
	
	//echo "subject / ID : " . $subject . " / " . $subjectID . "<br>";
	 
	// sql query statement
	
	 
	 $titlesBySubjectQuery = "select fielderSubjectFull.*, fielderSubjectCode.*, fielderBibRecord.* from fielderSubjectFull left join fielderSubjectCode on fielderSubjectFull.subjectID = fielderSubjectCode.subjectID left join fielderBibRecord on fielderSubjectCode.baseCode = fielderBibRecord.ID where fielderSubjectFull.subjectID = '" . $subjectID . "';";
	//echo $titlesBySubjectQuery;
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($titlesBySubjectQuery);
	 // PDO - execute the query
	 $result = $PDO_query->execute();

	//$result = mysql_query($query);
	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	
	
	echo "<H1>" . $subject  . "</H1><br>";


		 
	
	echo "<ul>";

		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		// Non-PDO code ---------------------
		//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			$title = $row[ "title" ];
			$recordID = $row[ "ID" ];
			
			//$studynum = $row[ "StudyNum" ];
			
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_titleRecord.php?ID=" . $recordID . "'>" . $title . "</a></li>";
		}
	echo "</ul>";
	
	
	
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