<?
# dbopen.php - establish connection to database and server

# change db_username, db_password and db_name as necessary
$dbhost = "localhost";
$dbname = "ISSRDA";
$dbuser = "darchives";
$dbpswd = "whqGnaL6GDfTpLYQ";

mysql_pconnect ("$dbhost","$dbuser","$dbpswd")
    or die ("Unable to connect to My_SQL server $dbhost as $dbuser.");

mysql_select_db("$dbname") or die ("Unable to select database $dbname.");
?>
