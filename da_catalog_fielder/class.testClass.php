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
class testClass {
//put your code here
	
	public $someString = "default string";
	
	function __construct($someString) {
		$someString = "default string";
		
	}
	
	function getString() {
		return $this->someString;
	}
}

?>
