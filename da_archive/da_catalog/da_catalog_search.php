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
        <li><a href="../archive tutorial/ownership.html" class="MenuBarItemSubmenu">Ownership and Privacy</a>
        <ul>
   	    <li><a href="../archive tutorial/ownership.html#Copyright">Copyright</a></li>
            <li><a href="../archive tutorial/ownership.html#License">License Agreements</a></li>
            <li><a href="../archive tutorial/ownership.html#Classes">Using Data in the Classroom</a></li>
             </ul>
            </li>
        <li><a href="../archive tutorial/restricteddatause.html" class="MenuBarItemSubmenu">Restricted Data</a>
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
<H1 align="center">Data Archives Catalog Search Engine</H1>
<br>

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
	
	
	
	//echo "<form action='da_catalog_titleRecord.php' method='put' name='studynumber' target='_self'>";
	//echo  "<select name='studynumber' class='alphaTitleList'>";
	$searchTerm = "";
	$searchPhrase = "";
	
	echo "<div align='center'><form action='da_catalog_SearchResults.php?searchTerm=$searchTerm' method='put' name='searchTerm' target='_self'>";

	echo "<table border='1' bordercolor='#FFFFCC' bordercolorlight='#66CCFF' bordercolordark='#66CCFF' bgcolor='#FFFFCC'  id='search'>";

	echo "<tr><td><label>Text to Search For: </label></td><td><input type=text name='searchTerm' size=40></td></tr>";
	//echo "<tr><td><label>Boolean:</label><select name='boolean'><option>AND<option>OR</select></td><td><label>Case</label><select name='case'><option>Insensitive<option>Sensitive</select></td></tr>";
	echo "<tr><td colspan=2 style='text-align: center;'><input type=submit value='Search!'> <input type=reset></th></tr></table></form></div>";


	
			
			
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	
	//print_r($indexList); 
	//echo "<br>";
	//print_r($indexFirstLetterList);
	?>
    <p>For any questions please contact <a href='mailto:libbie@ucla.edu'>Elizabeth Stephenson.</a></p>
</div>

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


