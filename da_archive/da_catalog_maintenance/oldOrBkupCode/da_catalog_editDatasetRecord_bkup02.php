<html>
<head><title>Data Archive Catalog: Input Dataset Record</title>
<link rel="stylesheet" href="2col_leftNav.css" type="text/css">

</head>
<body>
<?php
		
	$sscnetHTTP = "http://www.sscnet.ucla.edu/issr/da/da_catalog/";
	$sscnetHTTP_maintenance = "http://www.sscnet.ucla.edu/issr/da/da_catalog_maintenance/";
	$mydestopHTTP = "http://localhost/da_catalog/";
	$currentHTTP = $sscnetHTTP_maintenance;
	
	//include the login file - db_login.php
	//include('../db_login2.php');
	//include('ISSRDA_login.php');
	// set the include file
	//include the login file - db_login.php
	$sscnetInclude = "ISSRDATEST_login.php";
	$mydesktopInclude = "../db_login2.php";
	$currentInclude = $sscnetInclude;
	include($currentInclude); 
	
	// for desktop test system
	//$db_name = "da_catalog";	
	
	
	if (!empty($_POST['studynumber'])) {
		//echo "studynumber: " . $studynumber;
		$_SESSION['studynumber'] = $_POST['studynumber'];
		
			// something is selected
		$queryDatasetRecord="SELECT wwwlink.wwwlink, wwwlink.wwwtext, wwwlink.WWWcode, wwwlink.studynum, fileinfo.*, data_cite.cite AS datacite, fileinfo.Restricted AS restricted_file, fileinfo.StudyNum, fileinfo.ID as datasetID, data_cite.ID as citeID FROM cite AS data_cite RIGHT JOIN (wwwlink RIGHT JOIN fileinfo ON wwwlink.dtafile = fileinfo.DTAfile) ON data_cite.citenum = fileinfo.Cite WHERE fileinfo.StudyNum='" . $studynumber . "'";
		
		//echo "<br>query: " . $queryDatasetRecord . "<br>";
		
	// PDO connect  
		$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;

	 
	//  echo "<br>" .  $queryGetBaseRecord . "<br>";
			try	{
				$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
		
				} catch(PDOException $e)	{
					echo "Could not connect to the database because: ".	$e->getMessage()."<br>";
					die();
					}
	
 	// --------------------------------------------------------
			$PDO_query = $PDO_connection->prepare($queryDatasetRecord);
			// PDO - execute the query
			$result = $PDO_query->execute();
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				} 	
			// complete record info
			$datasetRecord = array();  // record - the title, sub# and restricted y/n
			
			$row_index = 0;   
			while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
				
				// alraedy have the sturynumber - $studynumber
				$datasetRecord[$row_index]["datasetID"] = $row["datasetID"];  // id for dataset record
				$datasetRecord[$row_index]["dtafile"] = $row["DTAfile"];
				$datasetRecord[$row_index]["dsname"] = $row["Dsname"];
				$datasetRecord[$row_index]["alttype"] = $row["AltType"];
				$datasetRecord[$row_index]["altsnum"] = $row["AltSNUM"];
				$datasetRecord[$row_index]["filetype"] = $row["FileType"];
				$datasetRecord[$row_index]["note"] = $row["Note"];
				$datasetRecord[$row_index]["dsname"] = $row["Dsname"];
				$datasetRecord[$row_index]["fullsize"] = $row["Fullsize"];  // NOTE: legacy - use Fullsize (vs. Gzipsize) for filesize 
				
				
				
				//-------------------------------------------------------------------------------
				$datasetRecord[$row_index]["wwwID"] = $row["WWWcode"];  // id for dataset record
				$datasetRecord[$row_index]["wwwtext"] = $row["wwwtext"];
				$datasetRecord[$row_index]["wwwlink"] = $row["wwwlink"];	
				
				//-------------------------------------------------------------------------------
				$datasetRecord[$row_index]["citeID"] = $row["citeID"];  // id for dataset record
				$datasetRecord[$row_index]["cite"] = $row["cite"];
				
							
				
				$row_index++;
				
			}
		
	}
		
			
	echo "studynumber: " . $studynumber . "<br>";	
	$datasetRecordListCount = count($datasetRecord);
			echo "<br>Dataset record count: " . $datasetRecordListCount . "<br>";
	

		
	
	
	
$queryTitleStudyNumFileType = "SELECT title.StudyNum, fileinfo.FileType, fileinfo.dtafile, fileinfo.dtafilename FROM title LEFT JOIN fileinfo ON title.StudyNum = fileinfo.StudyNum ORDER BY title.StudyNum";
	
	// PDO connect  
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	
	try	{
		$PDO_connection = new PDO($PDO_string, $db_username, $db_password); 
		
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
					$dtafileList[$row_index] = $row["dtafile"];
					
					
					$row_index++;
			}
			
			$fileTypeList = array_unique($fileTypeList);
			sort($fileTypeList);
			$fileTypeTotal = count($fileTypeList);
			
			$dtafileList = array_unique($dtafileList);
			sort($dtafileList);
			
			
			$studynumberList = array_unique($studynumberList);
			sort($studynumberList);
			$studynumberListTotal = count($studynumberList);
			
			
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
   <form <?php 
  
  	if (isset($_SESSION['studynumber'])) {     //   a study has been chose so post means go to updateCheck
			echo " action='da_catalog_updateCheck.php'";  
			
		}   else {    //  a study HAS NOT been chosen so post the study info back to the input page when you do choose a study
				echo " action=''";  
				}
	
	?>    method="post" name="updateRecord" target="_self">
  
  
    <p><label>Studynumber: 
     <?php
		   		if (isset($_SESSION['studynumber'])) {
					
					$studynumber = $_SESSION['studynumber'];
					
					echo '<input name="studynumber" type="text" id="studynumber" value="' . $studynumber . '" size="30" maxlength="255">';
					
					
					echo '</select>';
					
					
				} else {
			
					echo '<select name="studynumber" id="studynumber">';
		   			echo '<option value="">choose studynumber</option>';
	   		
					foreach ($studynumberList as $key => $value) {
				
						echo '<option value="' . $value . '">' . $value;
				
				 	}
					
			echo " <input name='getbaserecord' type='submit' id='getbaserecord' value='Get this Studynumber'>";
				}
			
			
							
		?></label>
   
    <input name="updateTitle" type="submit" id="updateTitle" value="save/update record">
    <input name="reset form" type="reset" value="reset">
    <input type="button" onClick="history.go(0)" value="Reload page">
    <br> 
  <hr align="center" width="100%" size="1">
  
  <?php
  //-----------------------------------------------------
  //  beginning of item record
  //-----------------------------------------------------
 
  
	echo "<div id='dynamicInput'><p>";   //  first div encompases the dataset record AREA, the 2nd is the individual record
      
      
        
		 for ($row_index = 0; $row_index < $datasetRecordListCount; $row_index++) {   //  start of for-loop dataset list
		 
		 		// alraedy have the sturynumber - $studynumber
				$datasetID = $datasetRecord[$row_index]["datasetID"];  // id for dataset record
				$dtafile = $datasetRecord[$row_index]["dtafile"];
				$dsname = $datasetRecord[$row_index]["dsname"];
				$alttype = $datasetRecord[$row_index]["alttype"];
				$altsnum = $datasetRecord[$row_index]["altsnum"];
				$filetype = $datasetRecord[$row_index]["filetype"];
				$note = $datasetRecord[$row_index]["note"];
				$dsname = $datasetRecord[$row_index]["dsname"];
				$filesize = $datasetRecord[$row_index]["fullsize"];  // NOTE: legacy - use Fullsize (vs. Gzipsize) for filesize 
				
				
				
				//-------------------------------------------------------------------------------
				$wwwID = $datasetRecord[$row_index]["wwwID"];  // id for dataset record
				$wwwtext = $datasetRecord[$row_index]["wwwtext"];
				$wwwlink = $datasetRecord[$row_index]["wwwlink"];	
				
				//-------------------------------------------------------------------------------
				$citeID = $datasetRecord[$row_index]["citeID"];  // id for dataset record
				$cite = $datasetRecord[$row_index]["cite"];
		 
		 
		
		
		// NOTE: the studypart variable is used to sort the various datasets in order, so start with #1    
        echo " </p>";
        
        echo "<div id='datasetrecord' style='background-color:#CFC'><br>";
        echo "<input name='studypart' type='hidden' value='1' />  dataset name: <input name='dsname' type='text' value='" . $dsname . "'>";
        echo "filetype: <input name='filetype' type='text' value='" . $filetype . "'>     Filetype:&nbsp;";
         echo "<select name='filetype' id='dropdownList0'>";
            
	   		
			foreach ($fileTypeList as $key => $value) {
				
				echo '<option value="' . $value . '">' . $value;
				
				 }
				 
				
				
		?>
         </select>
         <label> file type NOT LISTED:
           <input name='newfiletype' type='text' id="newFileTypeEntry0">
         </label>
         <input name="da_catalog_insertSubjectCheck.php" type="button" onClick="addNewFileTypeEntry('newFileTypeEntry0', 'dropdownList0')" value="Add New File Type">
<br><br>
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
          note: <input name="note" type="text" id="fooTest02" value="<?php $note;  ?>">  Dtafile: 
          
		 
          
      <input name="dtafile" type="text" value="<?php  echo $dtafile; ?>">
    <br>   
          wwwlink description: <input name="wwwtext" type="text" size="50" maxlength="255">
          wwwlink: http://<input name="wwwlink" type="text" size="50" maxlength="255"> <br>
          Title link from other source, example - 'ICPSR': <input type="text" name="alttype">
           Alternate studynumber from other source: 
           <input type="text" name="altsnum">
<input type="hidden" name="gzsize" value=""><br>file level citation: <input type="text" name="cite_text" size="100" maxlength="500">
<br><br><input name="reset form" type="reset" value="reset">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="button" onClick="history.go(0)" value="Reload page">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="searchStudynumber" id="searchStudynumber" value="Add Dataset to this Studynumber">
      </p><br>
        <hr align="center" width="100%" size="1">
      </div> 
      	
        <?php   
		//-----------------------------------------------------
  		//  end of item record
  		//-----------------------------------------------------
  		?>
  
      <p> <hr align="center" width="100%" size="1">      
        <?php 
		}   // end of the for-loom dataset list ?>
       
       </p>
      </p>
      <p>&nbsp; </p>
</div>   
  </form>
 <?php  
 
 	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
?>
 
</div> <!-- end content-->
 
  </body></html>