<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class
 *
 * @author data archive
 */
class simpleClass
{
    // property declaration
    public $var = 'a default value';

    // method declaration
    public function displayVar() {
        echo $this->var;
    }
}

class fielderRecord {
	
	public $ID;	
	public $title;
	public $edition;
	public $published;
	public $description;
	public $series;
	public $othernames;
	public $notes;
	public $copies;
	
	//public $author;
	//public $subject;
	
	function _construct( $title, $edition, $published, %description, $series, $othernames, 
						$notes, $copies, $author, $subject ) {
		
		$this->ID			= $ID;
		$this->title		= $title;
		$this->edition		= $edition;
		$this->published	= $published;
		$this->description	= $description;
		$this->series		= $series;
		$this->othernames	= $othernames;
		$this->notes		= $notes;
		$this->copies		= $copies;
		
		//$this->author		= $author;
		//$this->subject		= $subject;
	}
	
	function getRecord() {
		
		$rec = "{$this->title}, {$this->edition}, {$this->published}, {$this->description}, {$this->series}, ";
		$rec .= "{$this->othernames}, {$this->notes}, {$this->copies} ";
		return $rec;
		
	}
}
?>
