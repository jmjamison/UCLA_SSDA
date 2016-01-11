<!DOCTYPE html>

<?php include("../_includes/SSDA_LibraryTopPanel.php") ?>
 
<title>Social Science Data Archive | UCLA Library</title>

 <?php include_once("../_includes/SSDA_LibrarySidePanel.php") ?>

<div class="panel-pane pane-bean-text-block pane-bean-ssda-schedule-appointment">
  
      
  
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
  
   
<!-- data archive  menubar - library in-house version  -->
<?php  
	include("../_includes/SSDA_menubar_libraryInHouse.php");  
//
// SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
//
?>
<!-- data archive google analytics tracking script -->
<?php include_once("../_includes/analyticstracking.php") ?>

  
          <div class="l-region l-region--main">
        <div class="panel-pane pane-node-body">
  

  
  <div class="pane-content">
  
  
    <div class="field field--name-body field--type-text-with-summary field--label-hidden"><div class="field__items"><div class="field__item even">



<!---------------------------------------------------------------------------------------------- -->
<!--ssda page code goes here -->
<H2 align="center">Subject/Index</H2><br>

<?php
		
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_fielder/";	
	//SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	include("../_includes/SSDA_librarydatabase.php");  //SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	// class for database connections
	include "../_classes/class.Database.php";
	
	 
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
	
	
	 
	// sql query statement
	
	 
	 $titlesBySubjectQuery = "select fielderSubjectFull.*, fielderSubjectCode.*, fielderBibRecord.* from fielderSubjectFull left join fielderSubjectCode on fielderSubjectFull.subjectID = fielderSubjectCode.subjectID left join fielderBibRecord on fielderSubjectCode.baseCode = fielderBibRecord.ID where fielderSubjectFull.subjectID = '" . $subjectID . "' ORDER BY title";
	//echo $titlesBySubjectQuery;
	
	
	// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($titlesBySubjectQuery);   	
// execute query
$result = $db->executeQuery();	 
	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
		}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging

	
	echo "<p align='center'>subject / ID : <strong>" . $subject .  "</strong></p>";


		 
	
	echo "<ul>";

		while ($row = $db->getRow())  {
		// Non-PDO code ---------------------
		//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			$title = $row[ "title" ];
			$titleArticle = $row[ "titleArticle" ];
			$recordID = $row[ "ID" ];
			
			//$studynum = $row[ "StudyNum" ];
			
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_titleRecord.php?ID=" . $recordID . "'>" . $titleArticle . " " . $title . "</a></li>";
		}
	echo "</ul>";
	
	
	
	// _destructor class closes connection
	// close the connection		
	//$PDO_connection = null;
	
	?>
<!-- end content-->  <!--end container -->
<!---------------------------------------------------------------------------------------------- -->

<?php include("../_includes/SSDA_LibraryBottomPanel.php") ?>


</body></html>