<?php

	namespace X\Sys;

	class DB extends \PDO{
		static $instance;

		public function __construct(){

		    //get instance from registry
			$config=Registry::getInstance();

			//make array with configuration from config.json
			$dbconf=(array)$config->dbconf;
			$dsn=$dbconf['driver'].':host='.$dbconf['dbhost'].';dbname='.$dbconf['dbname'];
		 	$usr=$dbconf['dbuser'];
		 	$pwd=$dbconf['dbpass'];

		 	//pass to config to pdo
			parent::__construct($dsn,$usr,$pwd);
		}

		static function singleton(){
			if(!(self::$instance instanceof self)){
				self::$instance=new self();
			}
			return self::$instance;
		}
	}