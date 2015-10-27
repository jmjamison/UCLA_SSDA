<?php 

class bibRecord {
	
	// bib records need:  title, pi(s), subject(s), useful links
	//                     connecting fields
	//["title"] = $row["Title"];  - study title
	//["studyNum"] = $row[ "StudyNum" ];   studynumber
	//["restricted"] = $row[ "Restricted" ];  field marking restricted study - with '*'
	//["www"] = $row[ "WWW" ];  - links the bib record to the www/link, uses studynumber minus the volume info, ie. X1234V1 becomes X1234
	//["citation"] = $row[ "cite"]; links to citation info, same as above, , uses studynumber minus the volume info, ie. X1234V1 becomes X1234
	
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	//$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;
	//$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	// PDO - create prepared statement
	// $PDO_query = $PDO_connection->prepare($query_baseRec);
	//$PDO_query->bindValue(":studynumber", $studynumber,  PDO::PARAM_STR);
	 // PDO - execute the query
	 //$result = $PDO_query->execute();

	var $studyTitle;
	var $studynumber;
	var $tempString;
	
	
	function set_studynumber ($studynumber) {
		//
		$this->studynumber = strtoupper($studynumber);
	}
	
	function get_studynumber () {
		//
		return $this->studynumber;
		
	}
	
	
	
	
	function set_title ($title) {
		//
		//htmlentities($title, ENT_QUOTES)
		//
		// Note: although rare, there are situations where the title will have quotes or apostrphies embedded within
		//
		$this->title = htmlentities($title, ENT_QUOTES);
	}
	
	function get_title () {
		//
		return $this->addslashes(html_entity_decode(title));
	}
	
	function get_horizontalList ($line) {
		//
		$this->tempString = $line;
		
		// lop off the last ';'
		if (substr_compare(trim($this->tempString), ";", -1) == 0) { 	
			$this->tempString = substr_replace(trim($this->tempString), "", -1);  
			}
		echo $this->tempString;
	}
	
	function get_verticalList ($line) {
		//
		$this->tempString = $line;
		
		// lop off the last ';'
		if (substr_compare(trim($this->tempString), ";", -1) == 0) { 	
			$this->tempString = substr_replace(trim($this->tempString), "", -1);  
			}
		echo $this->tempString;
		
	}
	function get_linkList ($line) {
		//
		$this->tempString = $line;
		
		// lop off the last ';'
		if (substr_compare(trim($this->tempString), ";", -1) == 0) { 	
			$this->tempString = substr_replace(trim($this->tempString), "", -1);  
			}
		echo $this->tempString;
		
	}
	
}


?>