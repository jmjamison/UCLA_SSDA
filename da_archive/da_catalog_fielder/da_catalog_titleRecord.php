<html>
<head><title>Eve Fielder Library Test</title>
<link href="../da_catalogLib/2col_leftNav.css" rel="stylesheet" type="text/css">
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

<!-- share-this script -->
<script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'605fb740-c736-4f2d-b087-bd8ffdb0078f'});</script>


</head>

<body>
<div id="masthead">
         <h1 id="siteName">Social Science Data Archives</h1> 

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

<div id="content">
<?php

	//include the login file - ISSRDA_login.php
	// data archive in-house login
	include("../da_catalogLib/ISSRDA_login.php");
	
	// check, if NOT set 
	if (!isset($_GET['ID'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='da_catalog_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
	 
	$recordID =  $_GET['ID']; 
	
	// database name
	$fielder_query = "select fielderBibRecord.*, fielderSubjectFull.*, fielderSubjectCode.*, fielderAuthorCode.*, fielderAuthorFull.*  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID where fielderBibRecord.ID = '" . $recordID . "'";
	
	//echo "<br>" . $fielder_query . "<br>";
			
	// PDO connect  
		$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;

	 
	//  echo "<br>" .  $queryGetBaseRecord . "<br>";
			try	{
				$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
		
				} catch(PDOException $e)	{
					echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
					die();
					}
	
			// PDO - create prepared statement: get the table.pifull
 			// --------------------------------------------------------
			$PDO_query = $PDO_connection->prepare($fielder_query);
			// PDO - execute the query
			$result = $PDO_query->execute();
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				} 	
				
				
				
		// the mobilityData 
		$fielder_record=array();

	$row_index = 0;
	while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		
		 $fielder_record[$row_index]["title"] = $row["title"];
		 $fielder_record[$row_index]["edition"] = $row["edition"]; 
		 $fielder_record[$row_index]["published"] = $row["published"];
		 $fielder_record[$row_index]["description"] = $row["description"];
		 $fielder_record[$row_index]["series"] = $row["series"];
		 $fielder_record[$row_index]["othernames"] = $row["othernames"];
		 $fielder_record[$row_index]["notes"] = $row["notes"];
		 $fielder_record[$row_index]["copies"] = $row["copies"];
		 //
		 $fielder_author[$row_index] = $row["author"] . ";" . $row["authorID"];
		 //
		 $fielder_subject[$row_index] = $row["subject"]. ";" . $row["subjectID"];;
		 
		
		//echo "<br>Row count: " . $row_index;
		 
		 
	 	$row_index++;
	 
 		}
	
	$fielder_record = array_unique($fielder_record);  // toss out duplicate bib records
	
	$fielder_author = array_unique($fielder_author);  // toss out duplicate subject terms
	//print_r($fielder_author);
	$fielder_subject = array_unique($fielder_subject);  // toss out duplicate subject/index terms
	//print_r($fielder_subject);
	
	
	// author or authors
	echo "<br><br><strong>Author:</strong> ";   
		for ($row_index = 0; $row_index < count($fielder_author); $row_index++ ) {	
		
			// break up the author line if it contains more than one author
		
			for ($i = 0; $i < count($fielder_author); $i++) {
				
				list($author, $authorID) = explode(";", $fielder_author[$i]);
				
				echo "<A HREF= '" . $currentHTTP . "da_catalog_byAuthorList.php?author=" . $author . "&authorID=" . $authorID  . "'>" . $author . "</a>   " ;
			
				}
				
		}
		
		echo "<br><br>";
	
	for ($row_index = 0; $row_index < count($fielder_record); $row_index++ ) {		
	
		$title = $fielder_record[$row_index]['title'];
		$edition = $fielder_record[$row_index]['edition'];
		$published = $fielder_record[$row_index]['published'];
		$description = $fielder_record[$row_index]['description'];
		$series = $fielder_record[$row_index]['series'];
		$othernames = $fielder_record[$row_index]['othernames'];
		$notes = $fielder_record[$row_index]['notes'];
		$copies = $fielder_record[$row_index]["copies"];
		
		}
		
		//echo "<br><br>";
		
		echo "<strong>Title: </strong>" . $title . "<br><br>";

		echo "<strong>Edition: </strong>" . $edition . "<br>";
		echo "<strong>Series: </strong>" . $series . "<br>";
		echo "<strong>Description: </strong>" . $description . "<br>";
		echo "<strong>Published: </strong>" . $published . "<br>";
		echo "<strong>Notes: </strong>" . $notes . "<br>";
		echo "<strong>Other names: </strong>" . $othernames . "<br><br>"; 
		echo "<strong>Avaliable copies: </strong>" . $copies . "<br><br>";
		
		
		// subject or subjects
		echo "<strong>Subject:</strong> "; 
		// subject or index term(s)
		for ($row_index = 0; $row_index < count($fielder_subject); $row_index++ ) {	
		
			// break up the author line if it contains more than one author
		
			for ($i = 0; $i < count($fielder_subject); $i++) {
				
				list($subject, $subjectID) = explode(";", $fielder_subject[$i]);
				
				//echo $subject . " / " . $subjectID . "   ";
echo "<A HREF= '" . $currentHTTP . "da_catalog_bySubjectList.php?subject=" . $subject . "&subjectID=" . $subjectID  . "'>" . $subject . "</a></li>   ";
			
				}
		
		}	
				
		
		
		
		echo "<br>";
		
		
		//--------------------------------------------------------------------------------------------
	//  Section for sharing links
	//  07/23/2011
	//
	//--------------------------------------------------------------------------------------------
	
	echo "<br>";
	
	echo "<div align='left' class='socialLinks' >";   
	
	echo "<span  class='st_twitter' ></span><span  class='st_facebook' ></span><span  class='st_email' ></span><span  class='st_sharethis' ></span>";
	
	echo "</div>";
	
	echo "<br>";
	
		echo "<br><br>";
	
// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
?>    
  </div> <!-- end content-->
  
  
 <div id="navBar"><div class="relatedLinks">
  <h3>Search By: </h3>
   <ul><h3>
    <li> <a href="../da_catalog_fielder/da_catalog_subjects.php" title="Search by index terms">Index Terms</a></li>
    <li> <a href="../da_catalog_fielder/da_catalog_titles.php" title="Search by study titles">Titles</a></li>
    <li> <a href="../da_catalog_fielder/da_catalog_authors.php" title="Search by study titles">Authors</a></li>
    <li> <a href="../da_catalog_fielder/da_catalog_search.php" title="Search Database">Keyword or Term</a></li></h3>
  </ul></div>
 </div>   <!--end navbar-->



<div id="siteInfo">
 <a href="http://dataarchives.ss.ucla.edu/da/about.htm">About Us</a> |
 <a href="mailto:libbie@ucla.edu">Contact Us</a> |
  &copy;

07/07/2008 University of California
</div>


<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19063567-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>	

  </body></html>