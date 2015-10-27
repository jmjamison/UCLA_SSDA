<?PHP
# Name:emptycart.php
# Purpose: empty ISSR_DATA_ARCHIVES_TAR cookie of all listed citations
# Usage: called from ---
# Steps:
#   - read ISSR_DATA_ARCHIVE_TAR cookie 

$referer = $_SERVER['HTTP_REFERER'];
//echo "before: " . $_COOKIE['ISSR_DATA_ARCHIVE_TAR']) . "<br>";

setcookie ("ISSR_DATA_ARCHIVE_TAR", "", time() - 3600);// set the time to minus to remove the cookie.  
echo "Dataset cart list cleared. Return to <a href=\"$referer\">Study Page</a>\n";
//echo "after: " . $_COOKIE['ISSR_DATA_ARCHIVE_TAR']) . "<br>"; 

//header("Location: $referer"); # redirect back to source page
// header("Location: da_catalog_titleRecord.php?studynumber=$src"); # redirect back to source page
     // exit;
	 
	//echo "variable \$referer = " .  $referer . "<br>"; 
	//echo "variable \$study = " .  $study . "<br><br>"; 
	
   
	//echo "<FORM METHOD=\"POST\" ACTION=\"http://www.sscnet.ucla.edu/issr/da/da_catalog/da_catalog_titleRecord.php?studynumber=$study\">\n";
   // echo "<INPUT TYPE=\"submit\" VALUE=\"RETURN TO STUDY\">\n";
   // echo "</FORM>\n";


?>