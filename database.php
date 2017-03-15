<?php
include realpath(dirname(__FILE__).'/adodb5/adodb.inc.php');
Class ICS_database{
	private static $conn;
	private static $config;
	private static $adodb;
	private static $db_config = array(
		'hotel' => array('localhost','radius', 'root', 'local'),
		'dev01-cloud' => array('172.30.30.74', 'radius_dev01', 'root', 'oportino'),
		'local' => array('localhost', 'radius', 'root', 'local'),
		'tha' => array('203.170.193.74', 'tha', 'root' ,'oportino'),
		'booking' => array('203.170.193.74', 'book_package', 'root' ,'oportino')
	);
	public function getConnection($database='hotel'){
		if(!isset(self::$db_config[$database])){
			$database = 'hotel';
		}
		self::$config = self::$db_config[$database];
		self::$conn = mysql_connect(self::$config[0],self::$config[2],self::$config[3]) or die ("cannot connect db");
				mysql_select_db(self::$config[1], self::$conn) or die ("cannot select db");
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
		mysql_query("SET character_set_connection=utf8");
		return self::$conn;
	}
	
	public function AdodbConnection($database='hotel'){
		self::$adodb = NewADOConnection('mysql');
		self::$config = self::$db_config[$database];
		self::$adodb->Connect(self::$config[0], self::$config[2], self::$config[3], self::$config[1]);
		self::$adodb->setFetchMode(ADODB_FETCH_ASSOC);
		self::$adodb->Execute("SET NAMES 'utf8'");
		return self::$adodb;
	}
}