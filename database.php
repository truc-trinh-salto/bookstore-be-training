<?php
    class DBConfig{
        private static $instance;
        private $dbConnect;
        private function __construct(){}
        private function __clone(){}


        private static function getInstance(){
            if(self::$instance === null){
                $classname = __CLASS__;
                self::$instance = new $classname;
            }
            return self::$instance;
        }

        private static function connectDB(){
            $db = self::getInstance();
            $config = parse_ini_file('config/dbconfig.env');
            $db->dbConnect = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname'],'3306');
            $db->dbConnect->set_charset('utf8');
            return $db->dbConnect;
        }

        public static function getDB(){
            try {
                $db = self::connectDB();
                // echo 'Successfully connected to the database';
                return $db;
            }catch(Exception $e){ 
                var_dump($e);
                echo "Error connecting to database.";
                return null;
            }
        }
    }
    // $db = DBConfig::getDB();
?>