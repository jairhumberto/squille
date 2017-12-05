<?php
namespace Admin\DAO\DB;

use \PDO;

abstract class DAODB {
    protected $connection;
	
	public function __construct() {
		// FIXME: melhorar isso para não usar o contexto global, por enquanto é aceitável
		// para pelo menos colocar o site rodando. Mas quando tiver mais tempo corrigir isso.
		// desenvolvido assim em 20/09/2016 por Jair Humberto.
		global $config;
		$db = $config['database-connection'][getenv('environment')];
		
		$this->connection = new PDO("mysql:host={$db[dbhost]};dbname={$db[dbname]}", $db['dbuser'], $db['dbpassword']);
		
		$this->connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->connection->setAttribute(PDO::ERRMODE_EXCEPTION, true);
	}
}
