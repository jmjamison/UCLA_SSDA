<?php
/**
 * MySQLi database; only one connection is allowed. 
 */
class Database {
    
# change db_username, db_password and db_name as necessary

	private $db_host = DB_HOST;
	private $db_username = DB_USER;
	private $db_password = DB_PASS;
	private $db_name = DB_NAME;
	private $db_port = DB_PORT;
 
  	private $dsn; // database source name
  	private $dbh;  // database handler
  	private $error;
	private $stmt; // query statement varable
	
	private $connection;
	

  public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->db_username, $this->db_password, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }
	
	
	
	public function bind($param, $value, $type = null){
    if (is_null($type)) {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
    }
    $this->stmt->bindValue($param, $value, $type);
	}
	
	public function execute(){
    	return $this->stmt->execute();
	}
	
	public function executeQuery(){
    	return $this->stmt->execute();
	}
	
	public function query($query) {
		$this->stmt = $this->dbh->prepare($query);
	}
	
	public function prepareQuery($query) {
		$this->stmt = $this->dbh->prepare($query);
	}
	
	public function resultset(){
    	$this->execute();
    	return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function single(){
    	$this->execute();
    	return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getRow(){
    	return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function rowCount(){
    	return $this->stmt->rowCount();
	}
	
	public function debugDumpParams() {
		return $this->stmt->debugDumpParams();
	}
	
	public function __destruct() {
		$dbh = null;
	}
	
	
	
}
?> 