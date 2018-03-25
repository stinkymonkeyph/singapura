<?php 

namespace Core;
use Core\Config;
use \PDO;

class DatabaseConnector
{

    protected static $db_handler ;
    public function __construct()
    {
      if(Config::$dbms == 'mysql')
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
          self::$db_handler->exec("SET CHARACTER SET utf8");
        }
        catch (Exception $err)
        {
          $err->getMessage() . "<br/>";
          die();
        }

    }
    public static function db_handler()
    {
      return self::$db_handler;
    }

}



?>