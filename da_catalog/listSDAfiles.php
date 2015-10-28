<html>
<head><title>Data Archives Catalog Studynumber List</title>
<link rel="stylesheet" href="2col_leftNav.css" type="text/css">
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
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
<!-- link to top of page starts here -->
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

<div id="content"><H1 align="center">SSDA SDA Files</H1>

Studynumber list<br>

<?php
	
	$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog/";
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
	
	
$query = "SELECT fileinfo.StudyNum, fileinfo.Dsname, title.Title from fileinfo left join title on fileinfo.StudyNum = title.StudyNum where FileType = \'SDA online analysis\' order by StudyNum";

//$query = "SELECT fileinfo.StudyNum, fileinfo.Dsname, title.Title from fileinfo left join title on fileinfo.StudyNum = title.StudyNum where FileType = \'SDA online analysis\' order by StudyNum";

	//$query = "SELECT StudyNum, Dsname from fileinfo where FileType = 'SDA online analysis'";

		
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query);
	 // PDO - execute the query
	 $result = $PDO_query->execute();

	//$result = mysql_query($query);
	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	
	
	

	//echo "<H1>Results of Search in Data Archives Studies</H1><br>";
	// StudyNum, Dsname
	
	echo "<ul>";
	$row_index = 0;

		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		
			$studynumber = $row[ "fileinfo.StudyNum" ];
			$dsname = $row[ "fileinfo.Dsname" ];
			$title = $row["title.Title"];
			echo $studynumber . "  " . $dsname . " " . $title . "<br>";
			//echo $studynumber . "  " . $dsname . "<br>";
			
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
 <!--<div id="navBar"><div class="relatedLinks">
  <h3>Search By: </h3>
   <ul><h3>
  <li> <a href="da_catalog_index.php" title="Search by index terms">Index Terms</a></li>
    <li> <a href="da_catalog_titles.php" title="Search by study titles">Study Titles</a></li>
    <li> <a href="da_catalog_studynumbers.php" title="Search by study titles">Studynumbers</a></li>
    <li> <a href="da_catalog_search.php" title="Search Database">Keyword or Term</a></li></h3>
  </ul></div> -->
 </div>   <!--end navbar-->

</body></html>
