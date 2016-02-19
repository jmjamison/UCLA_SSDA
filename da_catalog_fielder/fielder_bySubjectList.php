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
	
	//$subject =  htmlspecialchars($_GET['subject'], ENT_QUOTES); 
	$subjectID =  htmlspecialchars($_GET['subjectID'], ENT_QUOTES); 
	
	 
	if (empty($subjectID)) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>Return to catalog.</a></span><br>";
		die ("Nothing selected.");
		
		}
	 
	
	
	 
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
	
	
			
			
		$row_index = 0;
		
		
		while ($row = $db->getRow())  {
			$indexList[$row_index]["subject"] = $row['subject'];
			$indexList[$row_index]["subjectID"] = $row['subjectID'];
			$indexList[$row_index]["titleArticle"] = $row[ "titleArticle" ];
			$indexList[$row_index]["title"] = $row[ "title" ];
			$indexList[$row_index]["recordID"]= $row[ "ID" ];
	 		$row_index++;
	 		}
			
	
	echo "<ul>";
	
	$subject = $indexList[0]["subject"];
	
	echo "<p align='center'>subject: <strong>" . $subject .  "</strong></p>";
	
	
	for ($row_index = 0; $row_index < count($indexList); $row_index++ ) {	
			
			$subject = $indexList[$row_index]["subject"];
			$subjectID = $indexList[$row_index]["subjectID"];
			$title = $indexList[$row_index]["title"];
			$titleArticle = $indexList[$row_index]["titleArticle"];
			$recordID =$indexList[$row_index]["recordID"];
			
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