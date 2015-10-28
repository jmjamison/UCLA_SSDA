<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
test, test <br />
<?php
	
//$db_host = "128.97.186.150";
//$db_port = "3306";
//$db_name="ISSRDA";
//$db_username  = "darchives";
//$db_password = "whqGnaL6GDfTpLYQ";
//$currentHTTP =  "http://dataarchives.ss.ucla.edu/da_catalog";

//$homelocation = "http://drupaldataarchives.sscnet.ucla.edu/";


include("../da_catalogLib/ISSRDA_login.php");
//echo $homelocation . "<br>";
// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	
	// check, if NOT set 
	//if (!isset($_GET['searchTerm'])) { 
		//die ("No citations selected.");
		//die();
		//}
		
// fielder source  = '/content/eve_fielder_titleRecord?';
// da catalog source = '/content/title-record?';	
	 
	//$searchTerm =  $_GET['searchTerm']; 
	//echo "Search term(s): <strong>" .  $searchTerm . "</strong><br>";
	


//$query_search_da_all = "SELECT distinct  '/content/title-record?studynumber=' as source, '(dataset)' as material, title.Title as title, title.StudyNum as recordID, pifull.pi as author, shfull.subject as subject FROM (((title LEFT JOIN picode ON title.tisort = picode.tisort) LEFT JOIN pifull ON picode.picode = pifull.picode) LEFT JOIN shcode ON title.tisort = shcode.tisort) LEFT JOIN shfull ON shcode.subjectcode = shfull.subjectcode where title.Restricted <> '*' and ((title.Title like '%" . $searchTerm . "%')  or (pifull.pi like '%" . $searchTerm . "%') or (shfull.subject like '%" . $searchTerm . "%')) UNION SELECT distinct  '/content/eve_fielder_titleRecord?ID=' as source, '(monograph)' as material, fielderBibRecord.title, fielderBibRecord.ID as recordID, fielderSubjectFull.subject as subject, fielderAuthorFull.author from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID where ((fielderBibRecord.title like '%" . $searchTerm . "%')  or (fielderAuthorFull.author like '%" . $searchTerm . "%') or (fielderSubjectFull.subject like '%" . $searchTerm . "%')) ORDER BY title";	

$query_search_da_all = "SELECT title.Title as title, '/content/title-record?studynumber=' as source, '(dataset)' as material, title.StudyNum as recordID,  FROM (((title LEFT JOIN picode ON title.tisort = picode.tisort) LEFT JOIN pifull ON picode.picode = pifull.picode) LEFT JOIN shcode ON title.tisort = shcode.tisort) LEFT JOIN shfull ON shcode.subjectcode = shfull.subjectcode where title.Restricted <> '*' and ((title.Title like '%europe%') or (pifull.pi like '%europe%') or (shfull.subject like '%europe%')) UNION SELECT fielderBibRecord.title, '/content/eve_fielder_titleRecord?ID=' as source, '(monograph)' as material, fielderBibRecord.ID as recordID,  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID where ((fielderBibRecord.title like '%europe%') or (fielderAuthorFull.author like '%europe%') or (fielderSubjectFull.subject like '%europe%')) ORDER BY title";



	echo $query_search_da_all . "<br>";	
	// PDO connect  <br>
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	 // PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($query_search_da_all);
	 // PDO - execute the query
	 $result = $PDO_query->execute();

	//$result = mysql_query($query);
	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	else { "created temp table<br>"; }

	//echo "test";
	
	// Note: Make a table so you can avoid duplicate titles  using array_unique
	$resultsSearchAll = array();
	$row_index = 0;

		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
			
          	$resultsSearchAll[$row_index]["source"] = $row["source"];
            $resultsSearchAll[$row_index]["material"] = $row["material"];
			$resultsSearchAll[$row_index]["title"] = $row["title"];
			$resultsSearchAll[$row_index]["author"] = $row["author"];
			$resultsSearchAll[$row_index]["subject"] = $row["subject"];
            $resultsSearchAll[$row_index]["recordID"] = $row["recordID"];
			
			//echo "<br>Row count: " . $row_index;
		 
		 
	 		$row_index++;
			
			}
	
	//print_r($resultsSearchAll);

	if ($row_index < 1) {		
			echo "<li class='alphaTitleList'>No items found for search term: $searchTerm</li>";
	}
	
	 $resultsSearchAll = array_unique($resultsSearchAll);  // toss out duplicate bib records
	 //sort( $resultsSearchAll);
	
	echo "<H1>Results of Search in Data Archives Studies</H1><br>";
	
	echo "<ul>";
	
	for ($row_index = 0; $row_index < count($resultsSearchAll); $row_index++ ) {		
	
		$source = $resultsSearchAll[$row_index][ "source" ];
        $material =  $resultsSearchAll[$row_index][ "material" ];
        $title = $resultsSearchAll[$row_index]["title"];
		$author = $resultsSearchAll[$row_index][ "author" ];
		$subject = $resultsSearchAll[$row_index][ "subject" ];
        $recordID = $resultsSearchAll[$row_index][ "recordID" ];

		echo "<li class='alphaTitleList'><A HREF= '" . $source .  $recordID ." '>" . $material  . "  " .  $title ."</a></li>";			
			
			
		}
		
		echo "</ul>";
	
	$PDO_connection = null;
	
	?>

</body>
</html>