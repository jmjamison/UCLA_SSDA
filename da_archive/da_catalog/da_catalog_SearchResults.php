<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>

<!-- DW6 -->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Data Portals</title>

<!--<link rel="stylesheet" href="file://///polaris/hontz/Desktop/New Archive web site/2col_leftNav.css" type="text/css"> -->

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



<!-- The structure of this file is exactly the same as 2col_rightNav.html;

     the only difference between the two is the stylesheet they use -->

<script src="../index/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>

<link href="../index/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">

<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">

<body> 


<h1 id="siteName"><img src="../_images/logo75.jpg" width="75" height=""> Social Science Data Archive</h1> 
<div id="container">
<ul id="MenuBar2" class="MenuBarHorizontal">
    <li><a href="../index.html">Archive Home</a>  </li>
    <li><a href="../da_catalog/">Archive Data Catalog</a></li>
       <li><a class="MenuBarItemSubmenu" href="#">Archive Tutorial</a>
      <ul>
        <li><a class="MenuBarItemSubmenu" href="../archive tutorial/searchingfordata.html">Search for Data</a>
          <ul>
            <li><a href="../archive tutorial/searchingfordata.html#Search">About Social Science Data</a></li>
            <li><a href="../archive tutorial/searchingfordata.html#Research">Refining Research Topics</a></li>
          </ul>
        </li>
        <li><a href="../archive tutorial/aboutcodebooks.html">About Codebooks</a></li>
        <li><a href="../archive tutorial/bibliographiccitation.html">Bibliographic Citations</a></li>
        <li><a href="../archive tutorial/archivingdata.html" class="MenuBarItemSubmenu">Archiving Data</a>
          <ul>
            <li><a href="../archive tutorial/archivingdata.html#WhyArchive">Why Archive Your Data?</a></li>
            <li><a href="../archive tutorial/archivingdata.html#SSDA">Deposit Data with SSDA</a></li>
            <li><a href="../archive tutorial/archivingdata.html#ICPSR">Deposit Data with ICPSR</a></li>
            <li><a href="../archive tutorial/archivingdata.html#Dataverse">Deposit Data with Dataverse</a></li>
            <li><a href="../archive tutorial/archivingdata.html#UCLA Library">Deposit Data with UCLA Library</a></li>
              <li><a href="../archive tutorial/archivingdata.html#CDL">Deposit Data with California Digital Library</a></li>
          </ul>
        </li>
        <li><a href="../archive tutorial/preparingdata.html" class="MenuBarItemSubmenu">Preparing Data</a>
          <ul>
            <li><a href="../archive tutorial/preparingdata.html#Prepare">Preparing Data</a></li>
            <li><a href="../archive tutorial/preparingdata.html#UCResearch">Research and UC Policy</a></li>
                     </ul>
        </li>
        <li><a href="../archive tutorial/grantproposals.html" class="MenuBarItemSubmenu">Grant Proposals</a>
          <ul>
            <li><a href="../archive tutorial/grantproposals.html#Management">Data Management</a></li>
            <li><a href="../archive tutorial/grantproposals.html#Protection">Data Protection</a></li>
            <li><a href="../archive tutorial/grantproposals.html#ProtectionPlans">Data Protection Plans</a></li>
          </ul>
        </li>
        <li><a href="../archive tutorial/ownership.html"class="MenuBarItemSubmenu">Ownership and Privacy</a>
        <ul>
   	    <li><a href="../archive tutorial/ownership.html#Copyright">Copyright</a></li>
            <li><a href="../archive tutorial/ownership.html#License">License Agreements</a></li>
            <li><a href="../archive tutorial/ownership.html#Classes">Using Data in the Classroom</a></li>
             </ul>
            </li>
        <li><a href="../archive tutorial/restricteddatause.html"class="MenuBarItemSubmenu">Restricted Data</a>
        <ul>
   	    <li><a href="../archive tutorial/restricteddatause.html#Restricted">Restricted Data</a></li>
            <li><a href="../archive tutorial/restricteddatause.html#humanSubjects">Human Subjects Review</a></li>
            <li><a href="../archive tutorial/restricteddatause.html#Enclave">Secure Data Enclave</a></li>
      </ul>
  </li></ul>
    <li><a href="#" class="MenuBarItemSubmenu">Archive Resources</a>
      <ul>
<li><a href="../archive resources/portalsresources.html">Data Portals</a></li>
<li><a href="../archive resources/toolsresources.html">Data Analysis Tools</a></li>
<li><a href="../archive resources/indexresources.html">Indexes</a></li>
<li><a href="../archive resources/surveyresearchresources.html">Survey Research Resources</a></li>
<li><a href="../archive resources/instructionalsupportresources.html">Instruction Resources</a></li>
<li><a href="../archive resources/qualitativedataresources.html">Qualitative Data Analysis</a></li>
      </ul>
    </li>
    <li><a href="http://www.icpsr.umich.edu/icpsrweb/ICPSR/">ICPSR</a></li>
    <li><a href="http://www.ucla.edu/">UCLA</a></li></ul>
<!-- end masthead --> 
    
<div id="content">
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
	
	// for desktop test system
	//$db_name = "da_catalog";	
	
		
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	
	// check, if NOT set 
	if (!isset($_GET['searchTerm'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='da_catalog_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
		
	
	 
	$searchTerm =  $_GET['searchTerm']; 
	echo "Search term(s): " .  $searchTerm . "<br>";
	
	// sql query statement
//$query_createTempStuff = "create temporary table temp_searchStuff (SELECT title.Title, title.StudyNum, pifull.pi, shfull.subject, shfull.icpsrcountry FROM (((title LEFT JOIN picode ON title.tisort = picode.tisort) LEFT JOIN pifull ON picode.picode = pifull.picode) LEFT JOIN shcode ON title.tisort = shcode.tisort) LEFT JOIN shfull ON shcode.subjectcode = shfull.subjectcode)";
//$query_createTempStuff = "create temporary table temp_searchStuff (SELECT title.Title, title.StudyNum, pifull.pi, shfull.subject, shfull.icpsrcountry FROM (((title LEFT JOIN picode ON title.tisort = picode.tisort) LEFT JOIN pifull ON picode.picode = pifull.picode) LEFT JOIN shcode ON title.tisort = shcode.tisort) LEFT JOIN shfull ON shcode.subjectcode = shfull.subjectcode) AND title.Restricted != '*'";
//$query_createTempStuff = "create temporary table temp_searchStuff (SELECT title.Title, title.StudyNum, pifull.pi, shfull.subject, shfull.icpsrcountry FROM (((title LEFT JOIN picode ON title.tisort = picode.tisort) LEFT JOIN pifull ON picode.picode = pifull.picode) LEFT JOIN shcode ON title.tisort = shcode.tisort) LEFT JOIN shfull ON shcode.subjectcode = shfull.subjectcode) AND 1";

$query_createTempStuff = "create temporary table temp_searchStuff (SELECT title.Title, title.Restricted, title.StudyNum, pifull.pi, shfull.subject, shfull.icpsrcountry FROM (((title LEFT JOIN picode ON title.tisort = picode.tisort) LEFT JOIN pifull ON picode.picode = pifull.picode) LEFT JOIN shcode ON title.tisort = shcode.tisort) LEFT JOIN shfull ON shcode.subjectcode = shfull.subjectcode)";
		
		
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query_createTempStuff);
	 // PDO - execute the query
	 $result = $PDO_query->execute();

	//$result = mysql_query($query);
	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	else { "created temp table<br>"; }
	
	
	//$query_searchStuff = "select distinct StudyNum, Title from temp_searchStuff where (Title like '%" . $searchTerm . "%') or (StudyNum like '%" . $searchTerm . "%') or (pi like '%" . $searchTerm . "%') or (subject like '%" . $searchTerm . "%') or (icpsrcountry like '%" . $searchTerm . "%') order by Title";
	
	//$query_searchStuff = "select distinct StudyNum, Title from temp_searchStuff where (Title like '%" . $searchTerm . "%') or (StudyNum like '%" . $searchTerm . "%') or (pi like '%" . $searchTerm . "%') or (subject like '%" . $searchTerm . "%') or (icpsrcountry like '%" . $searchTerm . "%')and (Restricted <> '*') order by Title";
	//  27-jan-2010jmj - grouped the search terms (title, StudyNum, etc) AND (test for RESTRICTED <> '*') - the extra parenthesis on the restricted test catches any 
	//     stray restricted files.
	$query_searchStuff = "select distinct StudyNum, Title from temp_searchStuff where ((Title like '%" . $searchTerm . "%') or (StudyNum like '%" . $searchTerm . "%') or (pi like '%" . $searchTerm . "%') or (subject like '%" . $searchTerm . "%') or (icpsrcountry like '%" . $searchTerm . "%'))and (Restricted <> '*') order by Title";
	
		
	//echo "<br>Query statement: " .  $query_searchStuff . "<br>";
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
		
			$title = $row[ "Title" ];
			$studynum = $row[ "StudyNum" ];
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "da_catalog_titleRecord.php?studynumber=$studynum&title=$title'>$title</a></li>";
			//echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "da_catalog_titleRecord.php?studynumber=$studynum</a></li>";
			
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
    
 </div> 
<!-- end container-->
<div id="navBar">
  <h3>Search By: </h3>
   <ul><h3>
   <li> <a href="da_catalog_index.php" title="Search by index terms">Index Terms</a></li>
    <li> <a href="da_catalog_titles.php" title="Search by study titles">Study Titles</a></li>
    <li> <a href="da_catalog_studynumbers.php" title="Search by study titles">Study Numbers</a></li>
    <li> <a href="da_catalog_search.php" title="Search Database">Keyword or Term</a></li></h3>
  </ul>
 </div>   <!--end navbar-->


<br>
<script type="text/javascript">
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>

</html>


