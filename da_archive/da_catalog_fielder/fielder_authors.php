<html>
<head><title>Eve Fielder Library Test</title>
<link rel="stylesheet" href="../da_catalog/2col_leftNav.css" type="text/css">
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
</head>
<body>
<div id="masthead">
         <h1 id="siteName">Social Science Data Archive</h1> 

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


<div id="content" align="center">
<H1 align="center">Author [Surname] That Begin With The Letter...</H1><br>

 <?php
	
	$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog_fielder/";
	
	//include the login file - ISSRDA_login.php
	// data archive in-house login
	include("../da_catalogLib/ISSRDA_login.php");
	
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
		
	 $query = "select fielderAuthorFull.*, Left(fielderAuthorFull.author,1) AS firstLetterIndex from fielderAuthorFull order by firstLetterIndex;";
	 
	 
	 
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query);
	 // PDO - execute the query
	 $result = $PDO_query->execute();
	 
	 if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}
		
		$indexList=array();
		// first letter of indext term list
		$indexFirstLetterList=array();
	 
		//echo "<table id='alphaList' align='center'> ";
		//echo "<tr>";  // start a row
		
		$itemCount = 1;	  // count off the number of items in the alpha-block, 5 letters across
		
		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
			$indexList[$row_index]["author"] = $row['author'];
			$indexList[$row_index]["authorID"] = $row['authorID'];
			$indexList[$row_index]["firstLetterIndex"] = $row['firstLetterIndex'];
	 		$indexFirstLetterList[$row_index] = $row['firstLetterIndex'];
	 		$row_index++;
	 		}
	
		$totalRows = count($indexFirstLetterList);
		
		$indexFirstLetterList = array_unique($indexFirstLetterList);
		sort($indexFirstLetterList);
		
		// first letter list horizontal
		foreach($indexFirstLetterList as $key => $value) {
		
			echo "| <A HREF='#$value'>&nbsp;$value&nbsp;</A>";
			//echo " | $index_letter ";
			}
			echo " | ";
	
//----------------------------------------------------------------------------
//
//  begin the for-loop to read through the entire array
//
//----------------------------------------------------------------------------	
		
	//print_r($indexFirstLetterList);
	
	$totalFirstLetters = count($indexFirstLetterList);
	$firstLetterPrevious = NULL;
	
	// start unordered vertical list of first letters
	echo "<ul  style='text-align: left; margin: 30; margin-left: 50;'>";      // start of the ul list	 
	foreach($indexFirstLetterList as $key => $value) {
		
		echo "<br><br><h2 style='text-align: left;'><a id='" . $value . "'>" . $value . "</a></h2>"; // end previous 
		
		for ($row_index = 0; $row_index < count($indexList); $row_index++ ) {	
					
	 		//$firstLetterIndex = $indexFirstLetterList[$row_index]["firstLetterIndex"];
			$author = $indexList[$row_index]["author"];
			$authorID = $indexList[$row_index]["authorID"];
			$firstLetterIndex = $indexList[$row_index]["firstLetterIndex"];
			
			//echo $firstLetterIndex;
			
			if ($firstLetterIndex == $value) {
						
				//echo $author . "<br>";
				echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_byAuthorList.php?author=" . htmlentities($author, ENT_QUOTES ) . "&authorID=" .  $authorID . "'>" . $author  . "</a></li>";
				
				}
		
	  		}
		
		}
		
		echo "</ul>";      // end of the ul list
//----------------------------------------------------------------------------
//
//   end of the for-loop
//
//----------------------------------------------------------------------------
		
		//echo "</ul>";      // end of the ul list
		// put link to return to top of page ---	
		echo "<a href='#top'>Return to top of the page</a>";
		

//----------------------------------------------------------------------------
//
//   end of the for-loop
//
//----------------------------------------------------------------------------
	//echo "</table>";
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
		
	?>
 </div>
  <div id="navBar"><div class="relatedLinks">
  <h3>Search By: </h3>
   <ul><h3>
    <li> <a href="../da_catalog_fielder/fielder_subjects.php" title="Search by index terms">Index Terms</a></li>
    <li> <a href="../da_catalog_fielder/fielder_titles.php" title="Search by study titles">Titles</a></li>
    <li> <a href="../da_catalog_fielder/fielder_authors.php" title="Search by study titles">Authors</a></li>
    <li> <a href="../da_catalog_fielder/fielder_search.php" title="Search Database">Keyword or Term</a></li></h3>
  </ul></div>
 </div>   <!--end navbar-->

 </div>   <!--end navbar-->


  </body></html>