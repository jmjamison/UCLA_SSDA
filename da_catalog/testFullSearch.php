<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
	
$db_host = "128.97.186.150";
$db_port = "3306";
$db_name="ISSRDA";
$db_username  = "darchives";
$db_password = "whqGnaL6GDfTpLYQ";
$currentHTTP =  "http://dataarchives.ss.ucla.edu/da_catalog";

$homelocation = "http://drupaldataarchives.sscnet.ucla.edu/";
//echo $homelocation . "<br>";
// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	// echo "$PDO_string<br>";
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	
	// check, if NOT set 
	//if (!isset($_GET['searchTerm'])) { 
		//die ("No citations selected.");
		////die();
		//}
		
	
	 
	//$searchTerm =  $_GET['searchTerm']; 
	//echo "Search term(s): " .  $searchTerm . "<br>";
	$searchTerm = "Africa";
	echo "Search term(s): " .  $searchTerm . "<br>";

$query_search_da_all = "SELECT title.Title as title, title.StudyNum as recordID, pifull.pi as author, shfull.subject as subject FROM (((title LEFT JOIN picode ON title.tisort = picode.tisort) LEFT JOIN pifull ON picode.picode = pifull.picode) LEFT JOIN shcode ON title.tisort = shcode.tisort) LEFT JOIN shfull ON shcode.subjectcode = shfull.subjectcode where title.Restricted <> '*' and ((title.Title like '%" . $searchTerm . "%')  or (pifull.pi like '%" . $searchTerm . "%') or (shfull.subject like '%" . $searchTerm . "%')) UNION SELECT fielderBibRecord.title, fielderBibRecord.ID as recordID, fielderSubjectFull.subject as subject, fielderAuthorFull.author from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID where ((fielderBibRecord.title like '%" . $searchTerm . "%')  or (fielderAuthorFull.author like '%" . $searchTerm . "%') or (fielderSubjectFull.subject like '%" . $searchTerm . "%')) ORDER BY title";	

echo $query_search_da_all . "<br>";
		
	// PDO connect  
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

	
	echo "<H1>Results of Search in Data Archives Studies</H1><br>";
	
	echo "<ul>";
	$row_index = 0;

		while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
			
			$title = $row[ "title" ];
			$author= $row[ "author" ];
			$subject= $row[ "subject" ];
//echo "<li class='alphaTitleList'><A HREF= 'title-record?studynumber=$studynum&title=$title'>$title</a></li>";
			//echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "da_catalog_titleRecord.php?studynumber=$studynum</a></li>";

            echo "<li class='alphaTitleList'>" . $title . " - " . $author . " - " . $subject . "</a></li>";
			
			$row_index++;
			
		}
	echo "</ul>";
	if ($row_index < 1) {
			
			echo "<li class='alphaTitleList'>No items found for search term: $searchTerm</li>";
			
	}
	
	$PDO_connection = null;
	
	?>
</body>
</html>