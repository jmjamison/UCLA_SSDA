<!DOCTYPE html>

 <?php include("../_includes/SSDA_LibraryTopPanel.php") ?>
 
<title>Social Science Data Archive | UCLA Library</title>

  
 <?php include("../_includes/SSDA_LibrarySidePanel.php") ?>
 
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
<div id="container" style="padding: 30px 50px 30px 50px;">

<?php  

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog/";	
	//SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	include("../_includes/SSDA_librarydatabase.php");  //SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	// class for database connections
	include "../_classes/class.Database.php";
//
// SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
//


//

//?>




 <h2 align="center">Eve Fielder Collection</h2>

        <P>The EFL contains bibliographic citations to a collection of survey methods publications and journals donated to the Data Archive by <a href="fielder_aboutEveFielder.php" target="_self">Eve Fielder</a>, former <em>Director of the ISSR Survey Research Center.</em> </P>
        <P>The items are available for use in the Archive and can sometimes be borrowed. For questions, please contact the <a href="mailto:libbie@ucla.edu">Archive</a>.</P>
          
          <div align="center">
            <h3 align="center"><A HREF = "fielder_index.php">index or subject term</A>&nbsp;&bull;&nbsp;<A HREF = "fielder_titles.php">titles</A>&nbsp;&bull;&nbsp;<A HREF = "fielder_authors.php">authors</A> &nbsp;&bull;&nbsp;<A HREF = "fielder_search.php">keyword search</A></h3>
</div>
<!-- end content-->  <!--end container -->
<!---------------------------------------------------------------------------------------------- -->

 <?php include("../_includes/SSDA_LibraryBottomPanel.php") ?>

  

</body></html>