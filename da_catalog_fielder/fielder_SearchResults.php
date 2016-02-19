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


<?php
	
		$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_fielder/";	
		include("../_includes/SSDA_librarydatabase.php");  
		//SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
		// class for database connections
		include "../_classes/class.Database.php";



	$searchTerm =  htmlspecialchars($_GET['searchTerm'], ENT_QUOTES); 
	
	// check, if NOT set 
	if (empty($_GET['searchTerm'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>Return to catalog.</a></span><br>";
		die ("Nothing selected.");
		
		}
		

$query_searchStuff = "select title, recordID, author, subject from (select fielderBibRecord.title, fielderBibRecord.ID as recordID, fielderSubjectFull.subject as subject, fielderAuthorFull.author  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID) as searchStuff  where ((title like '%" . $searchTerm . "%') or (author like '%" . $searchTerm . "%') or (subject like '%" . $searchTerm . "%')) order by title";
	

// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($query_searchStuff);   	
// bind value studynumber	
$db->bind(":searchTerm",  $searchTerm);	
// execute query
$result = $db->executeQuery();	 
	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
		}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging
		
	echo "<H2 align='center'>Results of Search term(s): <strong>" .  $searchTerm . "</strong></H2>";
	
	echo "<ul>";
	$row_index = 0;

		while ($row = $db->getRow())   {
		
			$title = $row[ "title" ];
			$recordID = $row["recordID"];
			
			
			
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_titleRecord.php?ID=" . $recordID . "'>" . $title . "</a></li>";
			
			//  
			
			$row_index++;
			
		}
	echo "</ul>";
	if ($row_index < 1) {
			
			echo "<li class='alphaTitleList'>No items found for search term: $searchTerm</li>";
			
	}
	
	// _destructor class closes connection
	// close the connection		
	//$PDO_connection = null;
	
	?>
<!-- end content-->  <!--end container -->
<!---------------------------------------------------------------------------------------------- -->

 <?php include("../_includes/SSDA_LibraryBottomPanel.php") ?>


</body></html>