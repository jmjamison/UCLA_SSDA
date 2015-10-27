<html>
<head><title>Data Archive Catalog: Maintenance Menu</title>
<link rel="stylesheet" href="2col_leftNav.css" type="text/css">
</head>
<body>
<?php
		
	$sscnetHTTP = "http://www.sscnet.ucla.edu/issr/da/da_catalog/";
	$sscnetHTTP_maintenance = "http://www.sscnet.ucla.edu/issr/da/da_catalog_maintenance/";
	$mydestopHTTP = "http://localhost/da_catalog/";
	$currentHTTP = $sscnetHTTP_maintenance;
	
	//include the login file - db_login.php
	//include('../db_login2.php');
	//include('ISSRDA_login.php');
	// set the include file
	//include the login file - db_login.php
	$sscnetInclude = "ISSRDA_login.php";
	$mydesktopInclude = "../db_login2.php";
	$currentInclude = $sscnetHTTP_maintenance;
	include($currentInclude); 
	
	// for desktop test system
	//$db_name = "da_catalog";	
						
	?>


<div id="masthead">
         <h1 id="siteName">UCLA Institute for Social Research Data Archives</h1> 
         <h2  id="siteName">Catalog Maintenance: Input & Update</h2>
</div> <!--end masthead--><!--end masthead-->

<div style="margin: 1% 5% 2% 2%;line-height: 1.5;	">
<h2><a href="da_catalog_input.php" target="_self">Input Base Record</a> <h3>(Includes pi and keywords along with title/studynumber information)</h3></h2>
<br>
<h2><a href="" target="_self">Edit Base Record</a></h2>
<br>

<h2><a href="" target="_self">	Input Dataset Item Record</a></h2>
<h2><a href="" target="_self">Edit Dataset Item Record</a></h2>
<p>&nbsp;</p>
<h2><a href="" title="input Web Link" target="_self">Input Web Link ("Useful Link")</a></h2><br>
  
 <p>&nbsp;</p>
<h2><a href="" title="input PI record">Input Principle Investigator (PI)</a>
  <h3>(Includes pi and keywords along with title/studynumber information)</h3></h2>
 </div> <!-- end content-->

 <?php  
 
 // close the connection
	// mysql_close($connection);		
	//$PDO_connection = null;
	
	?>
 
 
  </body></html>