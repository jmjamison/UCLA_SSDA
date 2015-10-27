<?php
	session_start();
?>
<html>
<head><title>Data Archive Catalog: Edit</title>
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
	
	
	if (isset($_SESSION['studynumber']))
			$studynumber = $_SESSION['studynumber'];
	else 
			$studynumber = '';
			
	if (isset($_SESSION['title']))
			$title = $_SESSION['title'];
	else 
			$title = '';
			
	if (isset($_SESSION['pi']))
			$pi = $_SESSION['pi'];
	else 
			$pi = '';
	
	if (isset($_SESSION['subject']))
			$subject = $_SESSION['subject'];
	else 
			$subject = '';
			
	if (isset($_SESSION['wwwtext']))
			$wwwtext = $_SESSION['wwwtext'];
	else 
			$wwwtext = '';
			
	if (isset($_SESSION['wwwlink']))
			$wwwlink = $_SESSION['wwwlink'];
	else 
			$wwwlink = '';
			
	if (isset($_SESSION['restricted']))
			$restricted = $_SESSION['restricted'];
	else 
			$restricted = '';
			
	if (isset($_SESSION['sda']))
			$sda = $_SESSION['sda'];
	else 
			$sda = '';
			
	if (isset($_SESSION['varsrch']))
			$varsrch = $_SESSION['varsrch'];
	else 
			$varsrch = '';
			
	if (isset($_SESSION['justonCD']))
			$justonCD = $_SESSION['justonCD'];
	else 
			$justonCD = '';
			
	if (isset($_SESSION['mobilityData']))
			$mobilityData = $_SESSION['mobilityData'];
	else 
			$mobilityData = '';
			
	if (isset($_SESSION['eveFielderCollection']))
			$eveFielderCollection = $_SESSION['eveFielderCollection'];
	else 
			$eveFielderCollection = '';
			
	if (isset($_SESSION['icpsrcountry']))
			$icpsrcountry = $_SESSION['icpsrcountry'];
	else 
			$icpsrcountry = '';
			
	if (isset($_SESSION['icpsrlink']))
			$icpsrlink = $_SESSION['icpsrlink'];
	else 
			$icpsrlink = '';
	
	
//--------------------------------------------------------------------
//  Section: populate the PI listbox
//      used for authority control, javascript to copy and paste in selected fields
//----------------------------------------------------------------------
$queryPI_list = "SELECT DISTINCT * FROM pifull ORDER BY pi";
//  echo for debugging purposes only
//echo "querry: " . $queryPI_list;
	
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
			$PDO_query = $PDO_connection->prepare($queryPI_list);
			// PDO - execute the query
			$result = $PDO_query->execute();
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				} 	
			$PI_list = array();
			
			
			$result = $PDO_query->fetch(PDO::FETCH_ASSOC); 
			$row_index = 0;   
			
			while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
					
					//$PI_list[$row_index]["picode"] = $row["picode"];
					$PI_list[$row_index]["pi"] = $row["pi"];
					$row_index++;
			}
			
			$PI_list_count = count($PI_list);
			echo "PI count: " . $PI_list_count . "     ";
//--------------------------------------------------------------
//       end populate PI section
//-------------------------------------------------------------
	
//--------------------------------------------------------------------
//  Section: populate the Subject/Index-term listbox
//      used for authority control, javascript to copy and paste in selected fields
//----------------------------------------------------------------------
$querySubject_list = "SELECT DISTINCT subject FROM shfull ORDER BY subject";
//  echo for debugging purposes only
	
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
			$PDO_query = $PDO_connection->prepare($querySubject_list);
			// PDO - execute the query
			$result = $PDO_query->execute();
	  		if (!$result) {
				die ("Could not query the database: <br />". mysql_error());
				} 	
			$Subject_list = array();
			
			
			$result = $PDO_query->fetch(PDO::FETCH_ASSOC); 
			$row_index = 0;   
			
			while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
					
					$Subject_list[$row_index]["subject"] = $row["subject"];
					$row_index++;
			}
			
			$Subject_list_count = count($Subject_list);
			echo "Subject count: " . $Subject_list_count . "<br>";
//--------------------------------------------------------------
//       end populate Subject section
//-------------------------------------------------------------
						
	?>

<div id="masthead">
         <h1 id="siteName">UCLA Institute for Social Research Data Archives</h1> 
          <h2 id="siteName"><a href="index.php" target="_self">Maintenance Menu</a>&nbsp;/&nbsp;Input Record</h2>  
</div> <!--end masthead--><!--end masthead-->

<div style="margin: 1% 5% 2% 2%;line-height: 1.5;	">
  <form method="post" name="addRecord" action="da_catalog_insertCheck.php">
    <p><label>Studynumber:
        <input name="studynumber" type="text" value="" size="20" maxlength="255">
      </label>
      <input name="title" type="hidden" value="title">
       
       <label>Title: 
         <input name="title" type="text" value="" size="100" maxlength="225">
       </label>
       <br>
       <br>
       <label>Add the PI(s) in display order (Lastname, Firstname), full name separated by semicolin (;)</label>
       <br>
      <label>PI: </label>
         <input name="pi" type="text" value=""  size="200" maxlength="255">
              <br><br>
              
       <!--
        //--------------------------------------------------------------------------
        //   dropdown box that is populated with PI names
        //         used as authority control
        //         pick from list and paste into text box/pi with javscript (da_catalog.js library) selectPasteCopy and clearoutTextElement functions
        //--------------------------------------------------------------------------
         -->
        <label>Select Principal Investigator(s) from list:</label>
        <input name="pickPIs" type="button" id="pickPIs" onClick="selectPasteCopy('addRecord', 'pi_list','pi')" value="Select and Paste to PI List">
        <input name="clearOutPI_list" type="button" id="clearOutPI_list" onClick="clearoutTextElement('addRecord', 'pi')" value="clear out PI list">
        <br>
        <br>
        
<select name="pi_list" size="10" multiple id="pi_list">
          <?php
	   		
			for ($row_index=0; $row_index < $PI_list_count; $row_index++) {
				//$picode = $PI_list[$row_index]["picode"];
				$pi =  $PI_list[$row_index]["pi"];
				
				echo '<option value="' . $pi . '">' .$pi;
				
				 }
		?>
        <!--
         //---------------------------------------------------------------------------------
     	//  end of pi list box
    	 //------------------------------------------------
          -->
          
     </select>
    
           <br>
<input name="tisubsort" type="hidden" value="1">
      </label><br>
      <label>Add the Keyword(s)seperated by semicolin (;).</label>
      <br>
      <label>Keywords: 
        <input name="subject" type="text" value=""  id="subject" size="100" maxlength="255">
      </label>
    </p>
  
        <label>Select Subject/Keyword(s) from list:</label>
        <input name="pickSubjects" type="button" id="pickSubjects" onClick="selectPasteCopy('addRecord', 'subject_list','subject')" value="Select and Paste to Subject List">
        <input name="clearOutSubject_list" type="button" id="clearOutSubject_list" onClick="clearoutTextElement('addRecord', 'subject')" value="clear out Subject list">
        <br>
        <strong>Note</strong>: It is possible to select <em>MULTIPLE</em> subject/keyword terms but in order to add terms in a <strong>specific order</strong>, select and paste <em>each term Individually</em>. <br>
        
<select name="subject_list" size="10" multiple id="subject_list">
  <!--
        //--------------------------------------------------------------------------
        //   dropdown box that is populated with Subject/Keyword terms
        //         used as authority control
        //         pick from list and paste into text box/pi with javscript (da_catalog.js library)  selectPasteCopy and clearoutTextElement scripts functions
        //--------------------------------------------------------------------------
         -->
          <?php
	   		
			for ($row_index=0; $row_index < $Subject_list_count; $row_index++) {
				$subject =  $Subject_list[$row_index]["subject"];
				
				echo '<option value="' . $subject . '">' .$subject;
				
				 }
		?>
        <!--
         //---------------------------------------------------------------------------------
     	//  end of suybject list box
    	 //------------------------------------------------
          -->
          
    </select>
   
      <label><br>
        <br>
        Title level citation:
        <input name="cite_text" type="text" size="100" maxlength="500">
    </label>
    
      
      <label><br>
        Restricted:<input name="restricted" type="checkbox"  value="*">
    </label> 
       
       <label>SDA:<input name="sda" type="checkbox" value="*">
       </label>
       &nbsp;&nbsp;
       <label>Varsrch:<input name="varsrch" type="checkbox" value="*">
       </label>
       
       &nbsp;&nbsp;
      <label>CD Only:
         <input name="justonCD" type="checkbox" id="justonCD" value="*">
    </label>
       &nbsp;&nbsp;
       <label>
         <input name="article" type="hidden" value="">
       </label>
       &nbsp;&nbsp;
       <label>Mobility Data:<input name="mobilityData" type="checkbox" id="mobilityData" value="*">
       </label> <label>Eve Fielder Collection:<input name="eveFielderCollection" type="checkbox" id="eveFielderCollection" value="*">
       </label><br>  
              <label>ICPSR lists studies by country: 
       <input name="icpsrcountry" type="text"></label>
       <label>ICPSR  link: 
         <input name="icpsrlink" type="text">
       </label>
       <input name="numstudies" type="hidden" value="">
    <br>
    <input name="addTitle" type="submit" value="add record">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="reset form" type="reset" value="reset">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onClick="history.go(0)" value="Reload page">
    </p>
  </form>
  <?php  
 
 // close the connection
	$PDO_connection = null;
	
	session_destroy();
	
	?>
 
</div> <!-- end content-->
 
  </body></html>