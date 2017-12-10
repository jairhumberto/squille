<?php
namespace Application\DAO\DB;

use \PDO;

abstract class DAODB {
    protected $connection;
	
	public function __construct() {
		global $config;
		$db = $config['database'];
		
		$this->connection = new PDO("mysql:host={$db['dbhost']};dbname={$db['dbname']}", $db['dbuser'], $db['dbpassword']);

		$this->connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->connection->setAttribute(PDO::ERRMODE_EXCEPTION, true);
	}
}
