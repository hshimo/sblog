<?php
namespace Sblog\Lib;

class Model
{
    public $db;
    public $config;

    public function __construct()
    {
        if (!$this->db) {
            $config = $this->getDbConfig();
            $this->db = $this->getDB($config);
        }
        return $this->db;
    }

    public function getDbConfig()
    {
        // FIXME get from Config/database.php
        $dsn = DB_ENGINE .
            ':host=' . DB_HOST .
            ';dbname='    . DB_NAME .
            ';port='      . DB_PORT .
            '';
            //';connect_timeout=15';
        $config = array(
            'db_name' => DB_NAME,
            'db_user' => DB_USER,
            'db_password' => DB_PASSWORD,
            'dsn' => $dsn,
        );
        return $config;
    }

    public function getDB($config)
    {
        return new \Sblog\Lib\DB($config, $config['db_name']);
    }

}