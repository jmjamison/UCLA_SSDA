<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
abstract class fielderRecord implements Model  {
    
    // street address
    public $street_address_1;
    public $street_address_2;
    
    // name of the City
    public $city_name;
    
    // name of the subdivision
    public $subdivision_name;
    
   
    
    //name of the country
    public $country_name;
    
    /**
     * Display address in html
     * @return string
     */
    
    // primary key for address
    protected $_address_id;
    
    // Address type id.
    protected $_address_type_id;
    
    // when record was created and last updated
    protected $_time_created;
    protected $_time_updated; 
    
     // postal code
    protected $_postal_code;
    
    /**
   * Post clone behavior. 
   */
  function __clone() {
    $this->_time_created = time();
    $this->_time_updated = NULL;
  }
    
    /**
     *  optional array of property names and values
     * @param type $data
     */
    function __construct($data = array()) {
        $this->_init();
        $this->_time_created = time();
        
        // insure that the address can be populated
        if (!is_array($data)) {
            trigger_error("Unable to construct address with a " . get_class($name));
        }
        // if there is data in the array, at least one value
        //     populate the address with it
        if (count($data) > 0) {
            foreach ($data as $name => $value) {
            // special case for protected properties
                if (in_array($name, array(
                    'time_created',
                    'time_updated', 
                    'address_id',
                    'address_type_id',
                ))) {
                    $name = '_' . $name;
                }
                $this->$name = $value;
            }
        }
    }
    
     /**
     * magic __get
     * @param type $name
     */
    function __get($name) {
        if (!$this->_postal_code)  {
            $this->_postal_code = $this->_postal_code_guess();
        }
     // attempt to return a protected propety by name
    $protected_property_name = '_' . $name;
    if (property_exists($this, $protected_property_name)) {
           return $this-> $protected_property_name;
    }
    // unable to access property; trigger error
    trigger_error("Undefined peroperty via __get: " . $name);
    return NULL;
    }
    
    /**
     * @param string $name
     * @param type $value
     */
    function __set($name, $value) {
        
        //allow anything to set the postal code
        if ('postal_code' == $name) {
            $this->$name = $value;
            return;
        }
        // unable to access property; trigger error
        trigger_error("Undefined or unallowed property via __set()" . $name);
        }
    /**
     * magic toString method
     * returns a string
     */   
    function __toString() {
        return $this->display();
    }
    
    /**
     * force extending classes to init method
     */
    abstract protected function _init();
       /**
   * Guess the postal code given the subdivision and city name.
   * @todo Replace with a database lookup.
   * @return string 
   */
   //protected function _postal_code_guess(){ 
    //return 'LOOKUP';
 //}
    /**
   * Guess the postal code given the subdivision and city name.
   * @todo Replace with a database lookup.
   * @return string 
   */
  protected function _postal_code_guess() {
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    
    $sql_query  = 'SELECT postal_code ';
    $sql_query .= 'FROM location ';
    
    $city_name = $mysqli->real_escape_string($this->city_name);
    $sql_query .= 'WHERE city_name = "' . $city_name . '" ';
    
    $subdivision_name = $mysqli->real_escape_string($this->subdivision_name);
    $sql_query .= 'AND subdivision_name = "' . $subdivision_name . '" ';
    
    $result = $mysqli->query($sql_query);
    
    if ($row = $result->fetch_assoc()) {
      return $row['postal_code'];
    }
  }
  
           
    function display () {
        
        $output = '';
    
        $output .= $this->street_address_1;
        if ($this->street_address_2) {
            $output .= '</br>' . $this->street_address_2;
            
        }
        // city, subdivision and postal code    
        $output .= '<br/>';
        $output .= $this->city_name . ', '. $this->subdivision_name;
        $output .= ' ' . $this->postal_code;        
        // country
        $output .= '<br/>';
        $output .= $this->country_name;
        return $output;
        
        }
        
     /**
   * Determine if an address type is valid.
   * @param int $address_type_id
   * @return boolean
   */
  static public function isValidAddressTypeId($address_type_id) {
    return array_key_exists($address_type_id, self::$valid_address_types);
  }
  
  /**
   * If valid, set the address type id.
   * @param int $address_type_id 
   */
  protected function _setAddressTypeId($address_type_id) {
    if (self::isValidAddressTypeId($address_type_id)) {
      $this->_address_type_id = $address_type_id;
    }
  }
  
  /**
   * 
   * @param type $address_id
   */
  final public static function load($address_id) {
      $db = Database::getInstance();
      $mysqli = $db->getConnection();
      
      	
$fielder_query = "select fielderBibRecord.*, fielderSubjectFull.*, fielderSubjectCode.*, fielderAuthorCode.*, fielderAuthorFull.author as author ,fielderAuthorFull.*  from fielderBibRecord left join fielderSubjectCode on fielderBibRecord.ID = fielderSubjectCode.baseCode left join fielderSubjectFull on fielderSubjectCode.subjectID = fielderSubjectFull.subjectID left join fielderAuthorCode on fielderBibRecord.ID = fielderAuthorCode.baseCode left join fielderAuthorFull on fielderAuthorCode.authorID = fielderAuthorFull.authorID where fielderBibRecord.ID = '" . "8" . "'";
      
      $result = $mysqli->query($sql_query);
      #if ($row = $result -> fetch_object()) {
      if ($row = $result -> fetch_assoc()) {
          var_dump($row);
          exit();
          return self::getInstance($row['title'], $row);
      }
      //throw new ExceptionAddress('Address not found', $code, $previous);
      throw new ExceptionAddress('Address not found', 
              self::ADDRESS_ERROR_NOT_FOUND);
  }
  
  /*
   * Given an address_type_id, return an instance of that subclass.
   *  @param int $address_type_id
   *  @param array $data
   *  @return Address subclass
   */
  final public static function getInstance($address_type_id, $data = array()) {
      $class_name = 'Address' . self::$valid_address_types[$address_type_id];
      if (!class_exists($class_name)) {
          throw new ExceptionAddress('Address subclass not found cannont create.', 
                  self::ADDRESS_ERROR_UNKNOWN_SUBCLASS);
      }
      return new $class_name($data);
  }
  /**
   * 
   */
  final public function save() {}
  
}