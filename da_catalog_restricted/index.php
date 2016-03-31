<!DOCTYPE html>
 <?php include("../_includes/SSDA_LibraryTopPanel.php") ?>
 
<title>Social Science Data Archive | Restricted File List</title>

       
  
  <?php include_once("../_includes/SSDA_LibrarySidePanel.php") ?>
  
<div class="panel-pane pane-bean-text-block pane-bean-ssda-schedule-appointment">
  

<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
      
  
  <div class="pane-content">
    <div class="entity entity-bean bean-text-block clearfix">

  <div class="content">
    <div class="field field--name-field-text-block field--type-text-long field--label-hidden"><div class="field__items"><div class="field__item even"><p>Have questions about your research? <a href="mailto:libbie@g.ucla.edu?subject=Research%20questions">We can help?</a></p>
</div></div></div>  </div>
</div>
  </div>

  
  </div>
    </div>


  
  <div class="l-region l-region--main-column">
<!-- Scripts for title record menu bar -->
<script type="text/javascript" src="scripts/jquery-latest.js"></script> 
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script> 
<script type="text/javascript" id="js">$(document).ready(function() {
	// call the tablesorter plugin
	$("table").tablesorter({
		// sort on the first column and third column, order asc
		sortList: [[0,0],[1,0]]
	});
}); </script>

<!-- share-this script -->
<script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'605fb740-c736-4f2d-b087-bd8ffdb0078f'});</script>
   
<!-- data archive  menubar - library in-house version  -->



<?php
	
	//error_reporting(E_ALL);
//ini_set('display_errors', 1);


	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_restricted/";	
	//SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	include("../_includes/SSDA_librarydatabase.php");  //SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	// class for database connections
	include "../_classes/class.Database.php";
	
	$query_restrictedList = "SELECT * FROM `title` WHERE `Restricted` = '*' order by Title";
	
	// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($query_restrictedList);   	
// execute query
$result = $db->executeQuery();	 
	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
		}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging
	
	echo "<H1>Restricted Titles</H1><br>";
	
	//echo "<br>";
			//echo "For material available to download from the Data Archve:<br>";
			echo "Click on column titles to resort.<br>";
			echo "<div id='downloadallfiles' class='datasets' >";
			//  12-15-09jmj
			//  if there is 1 or more - >= 1 - datasets that can be downloaded from the DATA ARCHIVE 
			//  after the dataset list is written out, javascript at the end of this section will write in thelines
			//   commented out below 
		//	echo "To download an entire study choose: <A HREF='addfiles.php?file=&study=" . $studynumber . "&src=" . $studynumber . "'><img src='addall.gif'></a><br><br>";
	//echo "<div style = 'font-size: small'>Click category headers to sort.<br>";
	echo "<table id='datasetList' class='tablesorter' style = 'font-size: small' cellpadding=5 >";
	echo "<thead><tr>";
	echo "<th class='label' style = 'background-color: powderblue' width=25 >Study Number</th>";
	echo "<th class='label' align='left' style = 'background-color: powderblue' >Study Title</th>";
	echo "</tr></thead>";
	
	//echo "<ul>";
	$row_index = 0;

		while ($row = $db->getRow())  {
				
			$title = $row[ "Title" ];
			$studynum = $row[ "StudyNum" ];
			
echo "<TR align='left' >"; // beginning of the row

echo "<TD><A HREF= '" . $currentHTTP . "da_catalog_titleRecordRestricted.php?studynumber=$studynum'>$studynum</a></TD>";

echo "<TD align='left'><A HREF= '" . $currentHTTP . "da_catalog_titleRecordRestricted.php?studynumber=$studynum'>$title</a></TD>";

echo "</tr>";   // end of the row
			
			$row_index++;
			
		}
		echo "</TABLE>";
		
	//echo "</ul>";
	if ($row_index < 1) {
			
			echo "<li class='alphaTitleList'>No items found for search term: $searchTerm</li>";
			
	}
	
	
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	?>
    
 
<?php include("../_includes/SSDA_LibraryBottomPanel.php") ?>

  

</body></html>