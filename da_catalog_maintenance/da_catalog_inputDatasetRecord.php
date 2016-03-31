<html>
<head><title>Data Archive Catalog: Input Dataset Record</title>
<link rel="stylesheet" href="2col_leftNav.css" type="text/css">
<!--<link rel="stylesheet" href="2col_leftNav.css" type="text/css"> -->
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
<!--  Javascript(s) to 1) paste PI names into text field, 2) clear the text fiels -->
<script language="JavaScript" src="da_catalog.js" type="text/javascript"><!--  da_catalog scripts //--></script>
<!-- end Javascript PI paste and clear -->

</head>
<body>
<?php
		
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_maintenance/";	
	include("../_includes/SSDA_librarydatabase_edit.php"); 
	// below links to the test version of the database, for testing
	//include("../_includes/SSDA_librarydatabase_test_edit.php"); 
	

	
	// PDO connect  
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
	
	try	{
		$PDO_connection = new PDO($PDO_string, $db_username_edit, $db_password_edit); 
		
		} catch(PDOException $e)	{
			echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
			die();
			}
	
	
	
	if (isset($_SESSION['studynumber']))
			$studynumber = $_SESSION['studynumber'];
	else 
			$studynumber = "";
		
			
	echo "studynumber: " . $studynumber . "<br>";	
		
	if (isset($_SESSION['studypart']))  
		$studypart = $_SESSION['studypart'];
	else 
			$studypart = "";
		
	if (isset($_SESSION['dsname'])) 
		$dsname = $_SESSION['dsname'];
	else
			$dsname = "";
	echo "dsname = " . $dsname . "<br>";
		
	if (isset($_SESSION['filetype'])) 
		$filetype = $_SESSION['filetype'];
	else 
		$filetype = "";
		
	if (isset($_SESSION['filesize'])) 
 		$filesize = $_SESSION['filesize'];
	else 
		$filesize = "";
		
	if (isset($_SESSION['note']))
		$note = $_SESSION['note'];
	else 
		$note = "";
	
	// original dtafile 
	if (isset($_SESSION['dtafile'])) 
		$dtafile = $_SESSION['dtafile'];
	else
		$dtafile = "";
		
		//was dtafile
	if (isset($_SESSION['dtafilename'])) 
		$dtafilename = $_SESSION['dtafilename'];
	else
		$dtafilename = "";
		
	if (isset($_SESSION['wwwtext'])) 
		$wwwtest = $_SESSION['wwwtext'];
	else 
		$wwwtext = "";
		
	if (isset($_SESSION['wwwlink'])) 
		$wwwlink = $_SESSION['wwwlink'];
	else 
		$wwwlink = "";
		
	if (isset($_SESSION['alttype'])) 
		$alttype = $_SESSION['alttype'];
	else 
		$alttype = "";
		
	if (isset($_SESSION['altsnum'])) 
		$altsnum = $_SESSION['altsnum'];
	else 
		$altsnum = "";
		
	if (isset($_SESSION['gzsize']))
		$gzsize = $_SESSION['gzsize'];
	else 
		$gzsize = "";
	
	if (isset($_SESSION['studypart'])) 
		$studypart = $_SESSION['studypart'];
	else 
		$studypart = "";
		
	if (isset($_SESSION['cite_text'])) 
		$cite_text = $_SESSION['cite_text'];
	else 
		$cite_text = "";
			
	$reclen = "";  // used for tape files, not currently set
			
	//$cite = $citenum . $studypart;
	
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_maintenance/";	
	include("../_includes/SSDA_librarydatabase_edit.php"); 
	// below links to the test version of the database, for testing
	//include("../_includes/SSDA_librarydatabase_test_edit.php"); 
	
//$queryTitleStudyNumFileType = "SELECT title.StudyNum, title.Title, fileinfo.* FROM title LEFT JOIN fileinfo ON title.StudyNum= fileinfo.StudyNum ORDER BY title.StudyNum";

$queryTitleStudyNumFileType = "SELECT title.StudyNum, fileinfo.FileType, fileinfo.DTAfile FROM title LEFT JOIN fileinfo ON title.StudyNum = fileinfo.StudyNum ORDER BY title.StudyNum";


echo "<b>" . $queryTitleStudyNumFileType . "";
	
	
	// PDO connect  
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
	
	try	{
		$PDO_connection = new PDO($PDO_string, $db_username_edit, $db_password_edit); 
		
		} catch(PDOException $e)	{
			echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
			die();
			}
	
			// PDO - create prepared statement: get the table.pifull
 			// --------------------------------------------------------
			$PDO_query = $PDO_connection->prepare($queryTitleStudyNumFileType);
			// PDO - execute the query
			$result = $PDO_query->execute();
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				} 	
			$fileTypeList = array();
			$studynumberList = array();
			$titleList = array();
			$dtafileList = array();
			
			$result = $PDO_query->fetch(PDO::FETCH_ASSOC); 
			$row_index = 0;   
			while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
					
					$studynumberList[$row_index] = $row["StudyNum"];
					if (!is_null($row["FileType"])) { $fileTypeList[$row_index] = $row["FileType"];  }  // others won't have nulls
					$dtafileList[$row_index] = $row["DTAfile"];
					
					//$title = $row["Title"];
					
					
					$row_index++;
			}
			
			$fileTypeList = array_unique($fileTypeList);
			natcasesort($fileTypeList);
			$fileTypeTotal = count($fileTypeList);
			
			$dtafileList = array_unique($dtafileList);
			sort($dtafileList);
			
			$studynumberList = array_unique($studynumberList);
			natcasesort($studynumberList);
			//sort($studynumberList);
			$studynumberListTotal = count($studynumberList);
			
			echo "<br>Last dta number: " . end($dtafileList) . "<br>";
			echo "Last study number: " . end($studynumberList) . "<br>";
			
			
			$fileTypeListText = implode("','", $fileTypeList);
			$fileTypeListText = "'" . $fileTypeListText . "'";
						
	?>
<script type="text/javascript">
var counter = 0;

function addNewFileTypeEntry(arg1, arg2) {	

	//  element containing the new file type entry
	
	var currentEntryID = arg1;
	alert(currentEntryID);

	var currentEntryName = document.getElementById(currentEntryID).name;
	alert("new entry form name: " + currentEntryID);
	
	var newText = document.getElementById(currentEntryID).value;
	
	//alert("Add this file type: " + newText);
	
	// element containt the old file type list
	
	var oldSelectBoxID = arg2;
	alert(oldSelectBoxID);
	
	var oldSelectBoxName = document.getElementById(oldSelectBoxID).name;
	//alert("old select box name: " + oldSelectBoxName);
		
	var fileTypeList = new Array(<?php echo $fileTypeListText; ?>);
	var fileListTotal = fileTypeList.length;
	//alert("Current total items: " + fileListTotal);
	
	document.getElementById(oldSelectBoxID).innerHTML = "";
	
	
	// write in the new, added file type first, the re-add the original filetype list
	
	var newOption = document.createElement("option");
	
		newOption.value = newText;
		newOption.text = newText;
	
	document.getElementById(oldSelectBoxID).appendChild(newOption);
	
	for (i = 0; i < fileListTotal; i++)	{
		
		
		var newOption = document.createElement("option");
				
				newOption.value = fileTypeList[i];
				newOption.text = fileTypeList[i];
				
		document.getElementById(oldSelectBoxID).appendChild(newOption);
		
	} // end of for-loop rewrite the option list
				
} // end addNewFileType



</script>


<div id="masthead">
         <h1 id="siteName">UCLA Institute for Social Research Data Archives</h1> 
          <h2 id="siteName"><a href="index.php" target="_self">Maintenance Menu</a>&nbsp;/&nbsp;Input Dataset Record</h2>  
          
         
</div> <!--end masthead--><!--end masthead-->

<div style="margin: 1% 5% 2% 2%;line-height: 1.5;	">
  <form method="post" name="addRecord" action="da_catalog_insertDatasetRecordCheck.php">
    Studynumber:
<?php
		   			echo '<select name="studynumber" id="studynumber"';
		   			echo '<option value="">choose studynumber</option>';
	   		
					foreach ($studynumberList as $key => $value) {
				
						echo '<option value="' . $value . '">' . $value;
				
				 	}
			
			echo '</select>';
			
							
		?>
 
Pick Base Record/Study number to add dataset(s) to.
<hr align="center" width="100%" size="1">
   
   
       <div id="dynamicInput">    
      <p>
        <?php  // NOTE: the studypart variable is used to sort the various datasets in order, so start with #1    ?>
        <input name="studypart" type="hidden" value="1" />  dataset name: <input type="text" name="dsname"> 
         Filetype:&nbsp;<select name="filetype" id="dropdownList0">
           <?php
	   		
			foreach ($fileTypeList as $key => $value) {
				
				echo '<option value="' . $value . '">' . $value;
				
				 }
				 
				
				
		?>
         </select>
        <label> file type NOT LISTED:
           <input name='newfiletype' type='text' id="newFileTypeEntry0">
        </label>
         <input name="addNewFileType" type="button" onClick="addNewFileTypeEntry('newFileTypeEntry0', 'dropdownList0')" value="Add New File Type">
<br><strong>Note:</strong> Dtafile number is derived from the DTA file number.
<br>Example: DTA900.file5811.somefilename.sps -> 9005811 and dataset_name: somefile.sps
<br>
file size:<input type="text" name="filesize" id="fooTest">
	<?php  // NOTE:   DTAfile number is a legacy variable, originally based on a combination of tape# + file#,
			//  later it was generated as 999 + nnnn, just add 1 to the last number generated.   14.Oct.2009 jmj
			 // This creates an incremented DTAfile number. 
		 //$foo = end($dtafileList);
		// $datfilePieces = explode("file", $foo);
		 //echo "   " . end($datfilePieces);
		 // used below in the dtafile_new field
		 //$endpart = end($datfilePieces);
		 // echo "DTA999.file" . ($endpart + 1); 
		?>
          note: <input type="text" name="note" id="fooTest02">  Dtafile: 
          
		 
          
      <input name="dtafile_new" type="text" value="<?php  echo end($dtafileList) + 1; ?>">
          The last dtafile number added was: 
		  	<strong><?php echo end($dtafileList); ?></strong><br>   
          wwwlink description: <input name="wwwtext" type="text" size="50" maxlength="255">
          wwwlink: http://<input name="wwwlink" type="text" size="50" maxlength="255"> <br>
          Title link from other source, example - 'Roper Center': <input type="text" name="alttype">
           Alternate studynumber from other source: 
           <input type="text" name="altsnum">
<input type="hidden" name="gzsize" value=""><br>file level citation: <input type="text" name="cite_text" size="100" maxlength="500">
<br><br><input name="reset form" type="reset" value="reset">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="button" onClick="history.go(0)" value="Reload page">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="searchStudynumber" id="searchStudynumber" value="Add Dataset to this Studynumber">
      </p>
    </div>   
  </form>
 <?php  
 
 	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
?>
 
</div> <!-- end content-->
 
  </body></html>