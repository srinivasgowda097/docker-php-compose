<? 
echo "<h1>Docker Compose</h1>";

$db_name = getenv('MYSQL_ENV_MYSQL_DATABASE');
$db_user = getenv('MYSQL_ENV_MYSQL_USER');
$db_pass = getenv('MYSQL_ENV_MYSQL_PASSWORD');

$db_host = getenv('MYSQL_PORT_3306_TCP_ADDR');
$db_port = getenv('MYSQL_PORT_3306_TCP_PORT');

$db_root_pass = getenv('MYSQL_ENV_MYSQL_ROOT_PASSWORD');

echo "<h1>Database info</h1>";
echo "<p>Host: $db_host</p>";
echo "<p>Port: $db_port</p>";
echo "<hr/>";
echo "<h1>Database credentials</h1>";
echo "<p>Database name: $db_name</p>";
echo "<p>Database user: $db_user</p>";
echo "<p>Database password: $db_pass</p>";
echo "<p>Database ROOT password: $db_root_pass</p>";
echo "<hr/>";

$link = mysql_connect($db_host.':'.$db_port, $db_user, $db_pass);


if (!$link) {
    die('Could not connect: ' . mysql_error());
}

if( mysql_select_db($db_name) ) {

$createTable = <<<CREATE_TABLE
CREATE TABLE `user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(255) NULL,
  `lastname` VARCHAR(255) NULL,
  PRIMARY KEY (`iduser`));
CREATE_TABLE;

//Drop table
mysql_query('DROP TABLE user');

//Create Table
mysql_query($createTable);

//Add records
echo "<p>Adding records...</p>";
echo "<hr/>";
mysql_query("INSERT INTO `user` (`firstname`,`lastname`) VALUES ('Jimmie','Johnson')");
mysql_query("INSERT INTO `user` (`firstname`,`lastname`) VALUES ('Joey','Logano')");
mysql_query("INSERT INTO `user` (`firstname`,`lastname`) VALUES ('Kevin','Harvick')");
mysql_query("INSERT INTO `user` (`firstname`,`lastname`) VALUES ('Martin','Truex')");

	$users = mysql_query('SELECT * FROM user');

	if( !$users ){
		echo "FALLO! ". mysql_error();
	}

echo "<p>Listing Added records...</p>";

	while ($row = mysql_fetch_assoc($users)) {
	    echo $row['iduser'].' - ';
	    echo $row['lastname'].', ';
	    echo $row['firstname'];
	    echo "<br/>";
	}

}

mysql_close($link);
?>