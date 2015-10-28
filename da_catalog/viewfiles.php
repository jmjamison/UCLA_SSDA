<?php
# Name: viewfiles.php
# Purpose: extract ISSR_DATA_ARCHIVES_TAR cookie and display all listed citations
# Usage: called from the web
# Steps:
#   - read ISSR_DATA_ARCHIVE_TAR cookie and give error if it doesn't exist
#   - split it into list, based on blankspace delimiter
#   - use list of values as keys to either database or filenames, and display them all
#   - add  "You have selected nn files, in yy studies, that total xx storage, compressed will be approximately zz."
#   - add REQUEST RETRIEVAL of FILES button
#       concatenate file.dsn(study);file.dsn(study);.....
#   - add Return to Catalog
#
# Update: 11-20-09 mike - changed $fileretrievalURL to new one provided by Andrew Tai per Libbie's email
# Update: 08-28-07 mike and Marty - addied totals, Return to Study and Retrieval buttons - all working, ready for Shirley
# Update: 07-13-07 mike and Marty - got this working and it displays study title and file info
# Update: 07-12-07 mike and Marty - starting shopping cart version
# Update: 02-23-05 mike and Marty - working with real citation/files and displays them
#                  and delimiting by semicolon
# Update: 01-21-05 mike and Marty - starting this as test of citation shopping cart
#
# Status: WRITING
# SVN: http://svn.sscnet.ucla.edu/classweb/ISSRDA
# Update: 12-08-09jmj accumulated note: $fileretrievvalURL changed to reflect the new eve server, also changes made for shibbolith 
#
#
# BIG-MESSY-UPDATE: 7-April-2010jmj.  This will hopefully work around the legacy issues.  
#		1)  the DTAfile - legacy to tape days - is coded ### ####, or for example 1991234, sometimes with a space between the firs 3 #'s, sometimes not
#		2)     the files are NOW requested as DTA###.file####, so...DTAfile must be split up and reformated. 
#		3)     EXCEPT in cases where you are SEARCHING the datbase for DTAfile.
#              so I'm formating BOTH formats to use where needed
#       NOTE: I though about simply replaceing DTAfile with a formated variable but that ran into other problems, so I'm keeping the original numbers,
#             since we really don't know how the database will change over time, be redesigned, etc.
#
#-----------------------------------------------------------------------------------------------------------------
#BIG-MESSY-UPDATE-PART2: 9-April-2010jmj. I'm going back to passing the OLD, un-formatted DTAfile variable to the cookie. Only reformat to New or Old formats in 
#	the viewfiles.php as needed.
#   
#-----------------------------------------------------------------------------------------------------------------
#BIG-MESSY-UPDATE-PART2b: 9-April-2010jmj. Fix the SQL callss to use PDO prepared objects, hense protect against injection attacks and similar security problems
#

	//$sscnetHTTP = "http://dataarchives.ss.ucla.edu/da_catalog/";
	$mydestopHTTP = "http://localhost/da_catalog/";
	$currentHTTP = $mydestopHTTP;
	
	
	//$sscnetInclude = "ISSRDA_login.php";
	//$mydesktopInclude = "../db_login2.php";
	$ssdaLocal_login = "ssdaLocal_login.php";
	$currentInclude = $ssdaLocal_login;
	include($currentInclude); 

  #$fileretrievalURL = "http://issrda.cluster.ucla.edu:10080/cgi-bin/standin"; # provided by Shirley Goldstein, ATS
  
  //$fileretrievalURL = "http://eve.ats.ucla.edu/get.php"; # provided by Andrew Tai, ATS 11-20-09
  $fileretrievalURL = "get.php"; # provided by Andrew Tai, ATS 11-20-09
  
  $referer = $_SERVER['HTTP_REFERER'];

  if (empty($_COOKIE['ISSR_DATA_ARCHIVE_TAR'])) {
    echo "Nothing stored in shopping cart, so far.  Return to <a href=\"$referer\">Study Page</a>\n<br>\n";
  } else {
    //require("dbopen.php");
	require("ssdaLocal_login.php");
	
## retrieve contents of cookie and create output list hash of studies and files
	//echo "the current cookie: ";
	//print_r($_COOKIE['ISSR_DATA_ARCHIVE_TAR']);
	//echo "<br>";
	
	$cookieFile = explode(";", $_COOKIE['ISSR_DATA_ARCHIVE_TAR']);
	$cookieCount = count($cookieFile);
	//
	echo "<br>cookie count: " . $cookieCount . "<br>";
	
	for ($counter = 0; $counter < $cookieCount; $counter++) {
		//echo $cookieFile[$counter] . "<br>";
	}
		
	#
	//
    echo "FILE=" . $file . "   STUDY= ". $study . "<br>";
	//
	  
	  
   $list = split(";", $_COOKIE['ISSR_DATA_ARCHIVE_TAR']);
	
	
    while (list ($key, $val) = each ($list)) {
      $file = $study = "";
      # echo "$key => $val "; 
      if (preg_match("/^(.*)?\((.*)\)$/", $val, $matches)) {
        $file = $matches[1];
        $study = $matches[2];
      } elseif (preg_match("/^(.*)$/", $val, $matches)) {
        $study = $matches[1];
      }
	  #
      //echo "FILE=" . $file . "   STUDY= ". $study . "<br>\n";
	  //
	 	  #
      if (empty($file) and empty($study)) {
        # ignore
      } elseif (empty($file)) {
        $output["$study"]++;
      } else {
        $output["$study-$file"]++;
      }
     
#     if ($val == "") { # skip empty values
#     } elseif (file_exists("citations/$val.TXT")) {
#       include("citations/$val.TXT"); 
#       echo "<hr>\n";
#     } else {
#       echo "No citation found for $val.</br>\n";
#       echo "<hr>\n";
#     }
    }

	 
## loop through output list, ordering by study, then file, retrieving associated file names and titles from mysql
    ksort($output);
    reset($output);
    $currentstudy = $requestedFiles = "";
    $totStudies = $totFiles = $totCompressed = $totUncompressed = 0;
	
	// make an list, then explode an array of all files that are either CD-ROM or WebAccess  
  	$notAtATS = "";
	
    while (list ($key, $val) = each ($output)) {
      list($study,$file) = split("-", $key);
      //echo "$key = $val<br>\n";
	  
	  //---------------------------------------------------------------
	  //echo "FILE=" . $file . "   STUDY= ". $study . "<br>\n";
	 
	  
	  //------------------------------------------------------------------
	  
      if ($study <> $currentstudy) {
        $currentstudy = $study;  // looks like a check for dups
        $totStudies++;		
		//
		// query title and fileinfo for by the study number
		//
		$query_1 = "select title.Title from title inner join fileinfo on title.StudyNum=fileinfo.StudyNum where fileinfo.StudyNum='" . $study . "'";
		//
		//echo "<br>query_1: " . $query_1 . "<br>";
		//
		// PDO connect  
		$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
		// PDO - create prepared statement
	 	$PDO_query = $PDO_connection->prepare($query_1);
	 
		$PDO_query->bindValue(":study", $study,  PDO::PARAM_STR);
		//$PDO_query->bindValue(":title", $title,  PDO::PARAM_STR);
	 
	 	// PDO - execute the query
		$result = $PDO_query->execute();

		if (!$result) {
			die ("Could not query the database: <br />". mysql_error());
		}	
		//
		//$q = mysql_query ($query_1)
          //or die ("Query failed: error message = " . mysql_error ());
		  //$row = $PDO_query->fetch(PDO::FETCH_ASSOC)
		
        //$row = mysql_fetch_assoc($q);
		$row = $PDO_query->fetch(PDO::FETCH_ASSOC);
        $title = $row["Title"];
        # echo "<B>$study: $title </B><br>\n";
        echo "<h3>$study: $title </h3>\n";
      } 
	  
	  //-----------------------------------------------------
	  // No file variable - $file is empty
	  // probably here is were the entire study is selected
	  //-----------------------------------------------------
	  //
      if (empty($file)) {  
        echo "&nbsp; &nbsp; All Files will be included.<br>\n";
		//
		$query_2 = "select * from fileinfo where StudyNum='" . $study . "'";
		//
		//echo "<br>query_2: " . $query_2 . "<br>";
		//
		// PDO connect  
		$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
		// PDO - create prepared statement
	 	$PDO_query = $PDO_connection->prepare($query_2);
	 
		$PDO_query->bindValue(":study", $study,  PDO::PARAM_STR);
	 
	 	// PDO - execute the query
		$result = $PDO_query->execute();

		if (!$result) {
			die ("Could not query the database: <br />". mysql_error());
		}	
		//$q2 = mysql_query ($query_2)
         // or die ("Query failed: error message = " . mysql_error ()); 
        //while ($row2 = mysql_fetch_assoc($q2)) {
		while ($row2 = $PDO_query->fetch(PDO::FETCH_ASSOC)) {
		// 
		 $filetype = $row2["FileType"];
		 if (!(stristr ($filetype, "CD-ROM")) AND !(stristr ($filetype, "Web Access")) AND !(stristr ($filetype, "SDA online analysis"))) {  // NOT cd-rom or web-access and SDA online analysis
          $totFiles++;  
		  $totUncompressed += $row2["Fullsize"];
		  $totCompressed   += $row2["GZsize"];
		  //----------------------------------------
		  // here you have to make the DTAfile into the DTA###.file#### format - at least for now...
		  $part_1 = "";
		  $part_2 = "";
		  // take the un-formatted DTAfile number and format into DTA###.file####. 
		  $dtafileOLD = $row2["DTAfile"];
		  //echo "<br>" . $dtafileOLD . "<br>";
		  $part_1 = trim(substr($dtafileOLD, 0, 3));
		  $part2_length = strlen($dtafileOLD)-3;
		  $part_2 = trim(substr($dtafileOLD, 3));
		  $dtafileNEW = "DTA" . $part_1 . ".file". str_pad($part_2, 4, "0", STR_PAD_LEFT);
		  //$requestedFiles  .= $row2["DTAfile"] . "." . $row2["Dsname"] . "(" . $study . ");";
		  //DTA" . $part_1 . ".file". str_pad($part_2, 4, "0", STR_PAD_LEFT)
		  $requestedFiles  .= "DTA" . $part_1 . ".file". str_pad($part_2, 4, "0", STR_PAD_LEFT) . "." . $row2["Dsname"] . "(" . $study . ");";
		  //echo "<br>" . $requestedFiles . "   " . $dtafileOLD . " - " . $filetype . "<br>";
		  } else {  
		  	$notAtATS .= "<strong>" . $study . "</strong>, " . "<em>" . $title . "</em>, " . $filetype . "; ";
			//echo "<br>Files not at ATS: " . $notAtATS . "<br>";
			}  // end of the not-ats-list if-loop
        } // end of the while-loop
		//echo "<br>Files not at ATS: " . $notAtATS . "<br>";
      } else {
		  //echo "<br>FILE=$file"; 
		  $dtafileOLD = $file;
		  //echo "<br>" . $dtafileOLD . "<br>";
		  $part_1 = trim(substr($file, 0, 3));
		  $part2_length = strlen($file)-3;
		  $part_2 = trim(substr($file, 3));
		  $dtafileNEW = "DTA" . $part_1 . ".file". str_pad($part_2, 4, "0", STR_PAD_LEFT);
		  //echo "     DTAfile OLD = " . $dtafileOLD . "; DTAfile NEW = " . $dtafileNEW . "<br>";
		//------------------------------------------------------------------------------
		//
		$query_3 = "select * from fileinfo where DTAfile='" . $dtafileOLD . "'";
		//
		//echo "<br>query_3: " . $query_3 . "<br>";
		// PDO connect  
		$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
		// PDO - create prepared statement
	 	$PDO_query = $PDO_connection->prepare($query_3);
	 
		$PDO_query->bindValue(":study", $study,  PDO::PARAM_STR);
	 
	 	// PDO - execute the query
		$result = $PDO_query->execute();

		if (!$result) {
			die ("Could not query the database: <br />". mysql_error());
		}	
		//$q3 = mysql_query ($query_3)
          //or die ("Query failed: error message = " . mysql_error ());
		  
        //$row2 = mysql_fetch_assoc($q3);
		$row2 = $PDO_query->fetch(PDO::FETCH_ASSOC);
		
		$filetype = $row2["FileType"];
		
		 if (!(stristr ($filetype, "CD-ROM")) AND !(stristr ($filetype, "Web Access")) AND !(stristr ($filetype, "SDA online analysis"))) {  // NOT cd-rom or web-access or SDA online analysis
        	$totFiles++;  
			//$requestedFiles  .= $row2["DTAfile"] . "." . $row2["Dsname"] . "(" . $study . ");";
			$requestedFiles  .= $dtafileNEW . "." . $row2["Dsname"] . "(" . $study . ");";
			echo "<br>" . $requestedFiles . "    " . $row2["Dsname"];
		 	$totUncompressed += $row2["Fullsize"];
		 	$totCompressed   += $row2["GZsize"];
			$dsn = $row2["Dsname"];
			$note = $row2["Note"];
			//$file_type = $row2["FileType"];
       	 	//echo "FILE=$file";
        	//echo "$dsn: $file_type";
			echo "$dsn: $filetype";
        	if (!empty($note)) { echo " $note";}
        	echo "<br>\n";
		 } else {  
		 	$notAtATS .= "<strong>" . $study . "</strong>, " . "<em>" . $title . "</em>, " . $filetype . "; ";
			//echo "<br>Files not at ATS: " . $notAtATS . "<br>";
			}  // end of the not-ats-list if-loop
        //} // end of the while-loop
		//echo "<br><strong>Files not downloadable from ATS:</strong> " . $notAtATS . "<br>";
		 // end of if-test-for not at ats
      } 
    }
	
    $totUncompressed = round($totUncompressed / 1024);
    $totCompressed = round($totCompressed / 1024);
    echo "<br>You have selected $totFiles files, in $totStudies studies, that total $totUncompressed KB storage, compressed will be approximately $totCompressed KB.<br>\n";
    // list out the files that are NOT available for download from ATS
	echo "<br>If you have selected any <strong>Web Accessable</strong> files they will not be included in the download<br> "; //echo "<br><strong>Files not available for download, please contact the Data Archive for assistance:</strong> " . $notAtATS . "<br>";
	$notDownload = explode("; ", $notAtATS);
	//print_r($notDownload);
	$i = 1;
	foreach ($notDownload as $current) {
		if (!empty($current)) {
			echo $i . ") " . $current . "<br>";
			$i++;
		}
	}
	
	
	$requestedFiles = rtrim($requestedFiles,";");  # remove trailing ;
    echo "<br><br>\n";
    # echo "<a href=\"", $_SERVER['HTTP_REFERER'],"\">Return to study</a>\n"; 
	
	//echo "variable \$referer = " .  $referer . "<br>"; 
	//secho "variable \$study = " .  $study . "<br><br>"; 
	
    #echo "<FORM METHOD=\"POST\" ACTION=\"$referer\">\n";
	# changed the above line to hardcode the return address + $study,     22-jan-2010jmj
	#      always return to the last titleRecord
	#echo "<FORM METHOD=\"POST\" ACTION=\"http://www.sscnet.ucla.edu/issr/da/da_catalog/da_catalog_titleRecord.php?studynumber=" . $study . "\">\n";
	echo "<FORM METHOD=\"POST\" ACTION=\"http://dataarchives.ss.ucla.edu/da_catalog/da_catalog_titleRecord.php?studynumber=" . $study . "\">\n";
    echo "<INPUT TYPE=\"submit\" VALUE=\"RETURN TO STUDY\">\n";
    echo "</FORM>\n";

    ## REQUEST RETRIEVAL of FILES button
    echo "<FORM METHOD=\"POST\" ACTION=\"$fileretrievalURL\">\n";
    echo "<INPUT TYPE=\"hidden\" NAME=\"filecount\" VALUE=\"$totFiles\">\n";
    echo "<INPUT TYPE=\"hidden\" NAME=\"studycount\" VALUE=\"$totStudies\">\n";
    echo "<INPUT TYPE=\"hidden\" NAME=\"files\" VALUE=\"$requestedFiles\">\n";
	 echo "<INPUT TYPE=\"hidden\" NAME=\"return\" VALUE=\"$study\">\n";
    echo "<INPUT TYPE=\"submit\" VALUE=\"RETRIEVE FILES\">\n";
    echo "</FORM>\n";

  }
?>
