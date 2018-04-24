<?php 

namespace Core;

use Core\Singapura\Config;
use PDO;
use Core\Singapura\Error;
use Exception;

class DatabaseConnector
{
    protected static $db_handler ;
    
    public function __construct()
    {      
       if(Config::$dbms == 'mysql')
       {
            try
            {
                self::$db_handler = new PDO
                (
                      'mysql:host='.Config::$db_host.
                      '; dbname='.Config::$db_name,
                       Config::$db_user,
                       Config::$db_pass
                );
                self::$db_handler->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                self::$db_handler->exec('SET CHARACTER SET utf8');
            }
            catch (Throwable $err)
            {
                throw new Exception($err->getMessage());
                die();   
            }
        }
    }

    public function db_handler()
    {
        return self::$db_handler;
    }

}


?>