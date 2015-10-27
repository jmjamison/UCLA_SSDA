<?php
	session_start();
?>
<html>
<head><title>Data Archive Catalog: Edit Item Record(s)</title>
<!--<link rel="stylesheet" href="2col_leftNav.css" type="text/css"> -->
<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
<!--  Javascript(s) to 1) paste PI names into text field, 2) clear the text fiels -->
<script language="JavaScript" src="da_catalog.js" type="text/javascript"><!--  da_catalog scripts //--></script>
<!-- end Javascript PI paste and clear -->

</head>
<body>

<?php
		
	//error_reporting(E_ALL ^ E_NOTICE);
  //error_reporting(0);
  
  	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_maintenance/";	
	include("../_includes/SSDA_librarydatabase_edit.php"); 
	
	//---------------------------------------------------------------------------------------
	
	if (!empty($_POST['studynumber'])) {  // study number set, that is NOT empty get the file/item record info
		$_SESSION['studynumber'] = $_POST['studynumber'];
		$studynumber =  $_SESSION['studynumber'];
		echo "studynumber: " . $studynumber;
		
	echo "studynumber: " . $studynumber;
	
	// studyNumberShort is studynumber without V[[n]. Used for connecting to citations and wevlinks
	// for example: $citenum = $studyNumShort . "_" . $studypart;
	$studynumArray = explode("V",$studynumber);
	$studyNumShort = $studynumArray[0];	
		
	
	
	$datasetRecordListCount = null;
	
	
	$queryDatasetRecord="SELECT fileinfo.*, fileinfo.Restricted AS restricted_file, fileinfo.ID as datasetID, cite.ID as citeID, cite.citenum, cite.cite as cite_text, cite.subsort as cite_subsort, wwwlink.wwwlink, wwwlink.wwwtext, wwwlink.WWWcode, wwwlink.dtafile FROM (fileinfo LEFT JOIN cite on fileinfo.Cite = cite.citenum) LEFT JOIN wwwlink on fileinfo.DTAfile = wwwlink.dtafile WHERE fileinfo.StudyNum='" . $studynumber . "' ORDER BY fileinfo.StudyPart";
		
	

		
		echo "<strong>dataset record query:</strong> " . $queryDatasetRecord . "<strong>;</strong>    ";
		
	// PDO connect  
		$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;

	 
	//  echo "<br>" .  $queryGetBaseRecord . "<br>";
			try	{
				$PDO_connection = new PDO($PDO_string, $db_username_edit, $db_password_edit);
		
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
			//$datasetRecord = array();  // record - the title, sub# and restricted y/n		
			
			$datasetRecord = array();   // holds the record - the title, sub# and restricted y/n	
			
			$row_index = 0;   
			while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
				
				// alraedy have the sturynumber - $studynumber
				$datasetRecord[$row_index]["datasetID"] = $row["datasetID"];  // id for dataset record
				$datasetRecord[$row_index]["dataset_studypart"] = $row["StudyPart"];  // id for dataset record
				$datasetRecord[$row_index]["dtafile"] = $row["DTAfile"];
				$datasetRecord[$row_index]["dsname"] = $row["Dsname"];  
				$datasetRecord[$row_index]["cite"] = $row["Cite"]; // this fileinfo.Cite connects to cite.citenum
				$datasetRecord[$row_index]["alttype"] = $row["AltType"];
				$datasetRecord[$row_index]["altsnum"] = $row["AltSNUM"];
				$datasetRecord[$row_index]["filetype"] = $row["FileType"];
				$datasetRecord[$row_index]["note"] = $row["Note"];
				$datasetRecord[$row_index]["dsname"] = $row["Dsname"];
				$datasetRecord[$row_index]["fullsize"] = $row["Fullsize"];  // NOTE: legacy - use Fullsize (vs. Gzipsize) for filesize 
				$datasetRecord[$row_index]["reclen"] = $row["Reclen"];  // NOTE: legacy - Reclen - record length - added 20130416jmj for older data files
				
				
				
				//-------------------------------------------------------------------------------
				$datasetRecord[$row_index]["wwwID"] = $row["WWWcode"];  // id for dataset record
				$datasetRecord[$row_index]["wwwtext"] = $row["wwwtext"];
				$datasetRecord[$row_index]["wwwlink"] = $row["wwwlink"];	
				
				//-------------------------------------------------------------------------------
				$datasetRecord[$row_index]["citeID"] = $row["citeID"];  // id for dataset record
				$datasetRecord[$row_index]["cite_text"] = $row["cite_text"];
				$datasetRecord[$row_index]["cite_subsort"] = $row["cite_subsort"];
				$datasetRecord[$row_index]["cite_citenum"] = $row["citenum"]; //  <-- the connecting field: cite.citenum to fileinfo.Cite
				
							
				
				$row_index++;
				
			}
			
			print_r($datasetRecord);
			$datasetRecordListCount = count($datasetRecord);	
			
			
					
	} else 
		
			$studynumber = '';  
	//----------------------------------------------------------------------------------
	// end of the first if - see if studynumber has been set, blank==no
	//--------------------------------------------------------------------------------
	//  add session variables so the pages stays populated
	//session_start();
	if (isset($_SESSION['studynumber']))
			$studynumber = $_SESSION['studynumber'];
	else 
			$studynumber = ''; 
	if (isset($_SESSION['datasetRecordListCount']))
			$datasetRecordListCount = $_SESSION['datasetRecordListCount'];
	else 
			$datasetRecordListCount = ''; 
	
	
		
	
	
	
		
	echo "<br><strong>Studynumber:</strong> " . $studynumber . ";  <strong> Dataset record count:</trong> " . $datasetRecordListCount . "<br>";
	
$queryTitleStudyNumFileType = "SELECT title.StudyNum, fileinfo.FileType, fileinfo.dtafile, fileinfo.dtafilename  as datasetID FROM title LEFT JOIN fileinfo ON title.StudyNum = fileinfo.StudyNum ORDER BY title.StudyNum";
	
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
						$dtafileList[$row_index] = $row["dtafile"];
					
					
					$row_index++;
				}
						
			$studynumberList = array_unique($studynumberList);
			natcasesort($studynumberList);
			$studynumberListTotal = count($studynumberList);
			
			
			
			$fileTypeList = array_unique($fileTypeList);
			sort($fileTypeList);
			$fileTypeTotal = count($fileTypeList);
			
			$dtafileList = array_unique($dtafileList);
			sort($dtafileList);
			
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
	
	alert("Add this file type: " + newText);
	
	// element containt the old file type list
	
	var oldSelectBoxID = arg2;
	alert(oldSelectBoxID);
	
	var oldSelectBoxName = document.getElementById(oldSelectBoxID).name;
	alert("old select box name: " + oldSelectBoxName);
		
	var fileTypeList = new Array(<?php echo $fileTypeListText; ?>);
	var fileListTotal = fileTypeList.length;
	alert("Current total items: " + fileListTotal);
	
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


<div id="masthead"><!--begin masthead-->
         <h1 id="siteName">UCLA Institute for Social Research Data Archives</h1> 
          <h2 id="siteName"><a href="index.php" target="_self">Maintenance Menu</a>&nbsp;/&nbsp;Edit Dataset Record(s)</h2>  
          
         
</div> <!--end masthead--><!--end masthead-->

<div style="margin: 1% 5% 2% 2%;line-height: 1.5;	">
   <form <?php 
  
  	if (isset($_SESSION['studynumber'])) {     //   a study has been chose so post means go to updateCheck
			echo " action='da_catalog_updateDatasetRecordCheck.php'";  
			
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
      <!--<input name="updateTitle" type="submit" id="updateTitle" value="save/update record">
      <input name="reset form" type="reset" value="reset">
    <input type="button" onClick="history.go(0)" value="Reload page">-->
    <br> 
  <hr align="center" width="100%" size="1">
  
  <?php
  
  // test to see if there are ANY records attached
  //  if-no - informational message
  //  else-yes - display them
  if (($datasetRecordListCount <= 0) AND (isset($studynumber))) {
	  
	  echo "There are no records attached to Study# " . $studynumber . ".";
	  
  } else {
	  
	  
	$previousDatasetID = null;
	  
	$blue = "#CCFFFF";  
	$yellow = "#FFFFCC";   
	$color = $blue; 
	//echo "Starting color: " . $color . "<br>";
      
		 for ($row_index = 0; $row_index < $datasetRecordListCount; $row_index++) {   //  start of for-loop dataset list
		 
		 			 
		 		// alraedy have the sturynumber - $studynumber
				$datasetID = $datasetRecord[$row_index]["datasetID"];  // id for dataset record
				$dataset_studypart = $datasetRecord[$row_index]["dataset_studypart"];
				if (empty($dataset_studypart)) {  $dataset_studypart = 1;  }
				$dtafile = $datasetRecord[$row_index]["dtafile"];
				$dsname = $datasetRecord[$row_index]["dsname"];
				//
				// if empty, build it
				$cite  = $datasetRecord[$row_index]["cite"];  
				if (empty($cite)) {$cite = $studyNumShort . "_" . $dataset_studypart; }
				//
				$alttype = $datasetRecord[$row_index]["alttype"];
				$altsnum = $datasetRecord[$row_index]["altsnum"];
				$filetype = $datasetRecord[$row_index]["filetype"];
				$note = $datasetRecord[$row_index]["note"];
				$dsname = $datasetRecord[$row_index]["dsname"];
				$filesize = $datasetRecord[$row_index]["fullsize"];  // NOTE: legacy - use Fullsize (vs. Gzipsize) for filesize 
				$reclen = $datasetRecord[$row_index]["reclen"];  // NOTE: legacy - Reclen - record length - added 20130416jmj for older data files
				
				
				
				//-------------------------------------------------------------------------------
				$wwwID = $datasetRecord[$row_index]["wwwID"];  // id for dataset record
				$wwwtext = $datasetRecord[$row_index]["wwwtext"];
				$wwwlink = $datasetRecord[$row_index]["wwwlink"];	
				
				//-------------------------------------------------------------------------------
				$citeID = $datasetRecord[$row_index]["citeID"];  // id for dataset record
				$cite_text = $datasetRecord[$row_index]["cite_text"];
				$cite_subsort = $datasetRecord[$row_index]["cite_subsort"];
				//
				$cite_citenum = $datasetRecord[$row_index]["cite_citenum"]; //  <-- the connecting field: cite.citenum to fileinfo.Cite
				// same as fileinfo.Cite, if empty build it
				if (empty($cite_citenum)) {  $cite_citenum = $studyNumShort . "_" . $dataset_studypart;  }
				//
				
		 
		
		//-----------------------------------------------------
  		//  beginning of item record
  		//-----------------------------------------------------
	if ($datasetID != $previousDatasetID) {  // first: check for dups
  	
		echo "<div id='dynamicInput'><p>";   //  first div encompases the dataset record AREA, the 2nd is the individual record
		
		
		// NOTE: the studypart variable is used to sort the various datasets in order, so start with #1    
       //echo " </p>";
        
        //echo "<div id='datasetrecord' style='background-color: " . $color . "'><br>";
		echo "<div id='datasetrecord' style='background-color: " . $color . "'>";         //  div #2 for record area
		echo "<form action='da_catalog_updateDatasetRecordCheck.php' method='post' name='updateDatasetRecord'><br>";
		if ($color == $blue) {
			$color = $yellow;
		} elseif ($color == $yellow) {
			$color = $blue;
		}
		
		echo "<input name='studynumber' type='hidden' value='" . $studynumber . "'>";
        echo "<label>dataset ID: " . $datasetID . "</label>  and   <label>Dtafile number : " . $dtafile . "</label> ";
		echo "<hr align='center' width='100%' size='1'>";
		//<!--<input name='dtafile' type='text' size='20' value=" . $dtafile . "><br>    -->";
		echo "Studypart number: <input name='dataset_studypart' type='text' size='3' value='" . $dataset_studypart  . "' />     <input name='datasetID' type='hidden' value='" . $datasetID . "'>"; 
		echo "     dataset name: <input name='dsname' type='text' value='" . $dsname . "'><br>";
		
        //echo "<br>filetype: <input name='filetype' type='text' value='" . $filetype . "'>     Filetype:&nbsp;";
		echo "current filetype: " . $filetype . "     ";
		
        echo "<select name='filetype' id='dropdownList"  . $datasetID .  "'>"; // use the datasetID to distinguish between each datasets filetype dropdown box
            
	   		echo '<option value="' . $filetype . '">' . $filetype;
			foreach ($fileTypeList as $key => $value) {
				
				echo '<option value="' . $value . '">' . $value;
				
				 }				
		?>
         </select>
         
<label>add a file type NOT LISTED:  <input name='newfiletype' type='text' id="newFileTypeEntry<?php echo $datasetID;  ?>">
</label>
         
         <!--// use the datasetID to distinguish between each datasets filetype dropdown box -->
         <input name="da_catalog_insertSubjectCheck.php" type="button" onClick="addNewFileTypeEntry('newFileTypeEntry<?php echo $datasetID;  ?>', 'dropdownList<?php echo $datasetID;  ?>')" value="Add New File Type">
<br>
file size:<input type="text" name="filesize" id="filesize" value="<?php echo $filesize;  ?>">   
record length:<input type="text" name="reclen" id="reclen" value="<?php echo $reclen;  ?>">

	<?php  	// NOTE:   DTAfile number is a legacy variable, originally based on a combination of tape# + file#,
			//  later it was generated as 999 + nnnn, just add 1 to the last number generated.   14.Oct.2009 jmj
			// This creates an incremented DTAfile number. 
		 	//$foo = end($dtafileList);
			// $datfilePieces = explode("file", $foo);
		 	//echo "   " . end($datfilePieces);
		 	// used below in the dtafile_new field
		 	//$endpart = end($datfilePieces);
		 	// echo "DTA999.file" . ($endpart + 1); 
			//  // htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
		?>
         
          note: <input name="note" type="text" size="100" id="note" value="<?php echo htmlspecialchars($note, ENT_QUOTES);  ?>">  
          
          <hr align='center' width='100%' size='1'>
        
          wwwlink description: <input name="wwwtext" type="text" size="50" maxlength="255" value="<?php echo $wwwtext;  ?>">
          wwwlink: http://<input name="wwwlink" type="text" size="50" maxlength="255" value="<?php echo $wwwlink;  ?>">   WWWcode:  <?php echo $wwwID;  ?><br>
           <input name="wwwID" type="hidden" value="<?php echo $wwwID;  ?>">
          Title link from other source, example - 'Roper': <input type="text" name="alttype" value="">
           Alternate studynumber from other source: <input name="altsnum" type="text" value="">
           <input type="hidden" name="studyNumShort" value="<?php echo $studyNumShort;  ?>">
           <input type="hidden" name="dtafile"  value="<?php echo $dtafile;  ?>">
           <input type="hidden" name="gzsize" value="">

          <hr align='center' width='100%' size='1'>
          
		file level citation: <!--<input type="text" name="cite_text" size="200" maxlength="500" value=""> -->
        <textarea name="cite_text" cols="101" rows="4"><?php echo $cite_text;  ?></textarea>  citeID: <?php echo $citeID;  ?>,  subsort: <?php echo $cite_subsort;  ?>, citenum: <?php echo $cite_citenum;  ?>
        
        <input name="citeID" type="hidden" value="<?php echo $citeID;  ?>">
        <input name="cite_subsort" type="hidden" value="<?php echo $cite_subsort;  ?>">
        <input name="cite_citenum" type="hidden" value="<?php echo $cite_citenum;  ?>">
        
          <hr align='center' width='100%' size='1'>
          
	<input name="reset form" type="reset" value="reset">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="button" onClick="history.go(0)" value="Reload page">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="updatedataset" id="updatedataset" value="Update this Dataset">
          </p>
      
      </form>
      </div> <!--End of Record Area -->
      	
        <?php   
		//-----------------------------------------------------
  		//  end of item record
  		//-----------------------------------------------------
  		?>
  
      <p> <hr align="center" width="100%" size="1">      
        <?php 
		
		$previousDatasetID = $datasetID;     
		
		}   // end of the for-loop dataset list 
		
	
		 }  //  end of the for-loop for dtafile dups
		
	
	 }  //  end of the if-else loop that tests to see if ANY datasets are attached
	 
	 ?>
        
      
       
       </p>
      </p>
      <p>&nbsp; </p>
</div>   

 <?php  
 
 	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	session_destroy();
	
?>
 
</div> <!-- end content-->

</body></html>