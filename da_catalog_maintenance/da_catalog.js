// JavaScript Document
// March 2010jmj
// Scripts at this time created for use in the da_catalog maintenance pages
<!--
// selectPIs pastes from myElementSend (a listbox) to myElementReceive (a text line)
// Note: this was written for a specific task, may be better to change the name to something more generic???
//function selectPIs(myForm, myElementSend, myElementReceive)
//function selectPasteCopy(myForm, myElementSend, myElementReceive)
function selectPasteCopy(myFormSend, myElementSend, myElementReceive, myFormReceive)
{
	//-----------------------------------------------------------------------------------------------------------------
	// ****NOTE****: javascript can't have optional parameters in the middle - so the optional parameter myFormReceive is last
	//----------------------------------------------------------------------------------------------------------------
	// myFormSend may not be set - the items copied and pasted may be in the same form
	if (!myFormReceive) myFormReceive = myFormSend;
	
	// debugging comments
	//alert("myFormSend: " + myFormSend);
	//alert("myElementSend: " + myElementSend);
	//alert("myFormReceive: " + myFormReceive);
	//alert("myElementReceive: " + myElementReceive);
	
	// this will paste the selected pi's from the list into the PI text box
	// can do multiple adds, it will send to the end of the list
	var numberOptions = document.forms[myFormSend].elements[myElementSend].options.length;
	// alert for debugging purposes only
	//alert("test options number: " + numberOptions);
	var selectedList = "";
	for(k = 0; k < numberOptions; k++)
	{
		if(document.forms[myFormSend].elements[myElementSend].options[k].selected)
		{
			var listSelectedObject = document.forms[myFormSend].elements[myElementSend].options[k].value;
			selectedList += listSelectedObject  + "; ";
		}
	}
	
	var tempList = document.forms[myFormReceive].elements[myElementReceive].value;
	
	//tempList.replace(/\s+$/, '');
	
	//alert("tempList: " + tempList.charAt(tempList.length-1));	
	//  check to see that the line ends with a ; separator - if there isn't one add it
	tempList = tempList.replace(/\s+$/, '');  // right-trimmed
	//alert("tempList: " + tempList.charAt(tempList.length-1));	
	if (tempList.length > 0) { // is there something there? - length greater than 0
		
		if(tempList.charAt(tempList.length-1) != ";") tempList +=  "; "; // if it doesn't end with a semicolon - ; - add one
		
	}
	
	tempList += selectedList;
	
	// NOW make sure there isn't a hanging semicolon (;) -- OTHERISE you end up adding a blank last record!!!
	// more debugging messages
	//alert("what was selected: " + selectedList);
	//alert("everything together: " + tempList);
	
	
	tempList = tempList.replace(/\s+$/, ';');  
	//alert("tempList: " + tempList.charAt(tempList.length-1));	
			
	
	if(tempList.charAt(tempList.length-1) == ";") { // if there is a semicolon at the end, back one more away from it
			
			tempList = tempList.slice(0,(tempList.length-2));  // if it doesn't end with a semicolon - ; - add one
		}
	
	document.forms[myFormReceive].elements[myElementReceive].value = tempList;
}
// clearoutPI_list clears out a text line
//function clearoutPI_list(myForm, myElementReceive)
function clearoutTextElement(myFormReceive, myElementReceive)
{	
	var blank = "";
	document.forms[myFormReceive].elements[myElementReceive].value = blank;
}

//--------------------------------------------------------------------------
// code from: http://lawrence.ecorp.net/inet/samples/regexp-format.php
// essentially do a right-trim: str.replace(/\s+$/, '');
//--------------------------------------------------------------------------

//-->