<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>

<head><title>Data Archives Catalog - Index Terms</title>

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

<div id="content" align="center">
<H1 align="center">Data Archives Catalog Search Engine</H1><br>

<?php
	
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_fielder/";	
	include("SSDA_librarydatabase.php"); 
	
	$searchTerm = "";
	$searchPhrase = "";
	
	echo "<div align='center'><form action='fielder_SearchResults.php?searchTerm=" . $searchTerm . "' method='put' name='searchTerm' target='_self'>";

	echo "<table border='1' bordercolor='#FFFFCC' bordercolorlight='#66CCFF' bordercolordark='#66CCFF' bgcolor='#FFFFCC'  id='search'>";

	echo "<tr><td><label>Text to Search For: </label></td><td><input type=text name='searchTerm' size=40></td></tr>";
	echo "<tr><td colspan=2 style='text-align: center;'><input type=submit value='Search!'> <input type=reset></th></tr></table></form></div>";
			
	
	?>
    <p>For any questions please contact <a href='mailto:libbie@ucla.edu'>Elizabeth Stephenson.</a></p>
</div> 
<!-- end container-->


</body></html>