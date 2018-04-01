<?php 

namespace Core;
use Core\Config;
use Core\DatabaseConnector;
use PDO;

class Database
{
	private static $conn;
	private static $bind = array();
	private static $query;
  private static $columns;

	private static function connect_db()
	{
  		$conn = new DatabaseConnector();
  		self::$conn = $conn->db_handler();
	}

  public static function update($table)
  {
      self::connect_db();
      self::$query = "UPDATE ".$table ;

      return new static;
  }

  public static function set($value_key)
  {
      self::$query = self::$query." SET ";
      $counter = 0 ;
      foreach($value_key as $key => $value)
      {
          self::$query = self::$query.$key." = :".$key.'_update';
          self::bind_set($key.'_update', $value);
          if($counter+1 < count($value_key))
          {
             self::$query = self::$query.", ";
          }
      }

      return new static;
  }

  public static function delete()
  {
        self::connect_db();
        self::$query = "DELETE ";

        return new static;
  }

	public static function select($attributes = null)
	{
		  self::connect_db();

   	  self::$query = "SELECT ";
    	$counter = 0;
    	if($attributes === null)
   	  {
        self::$query = self::$query." * ";
    	}
      else
    	{
        foreach($attributes as $column => $value)
        {
            self::$query = self::$query.$value;
            if($counter+1 < count($attributes))
            {
              self::$query = self::$query.", ";
            }
            $counter++;
        }
    	}

    	return new static;
	}

  public static function from($table_name)
  {    
        
	 	  self::$query = self::$query." FROM ".$table_name;
    	return new static;
  }

 	public static function where($key, $value)
	{
    	self::$query = self::$query." WHERE ".$key." = :".$key;
    	self::bind_set($key, $value);
    	return new static;
	}

	private static function bind_set($key, $value)
	{
    	self::$bind[':'.$key] = $value;
    	return new static;
	}

	public static function and($key, $value)
	{
 	    self::$query = self::$query." AND ";
    	self::$query = self::$query.$key." = :".$key;
    	self::bind_set($key, $value);
    	return new static;
	}

	public static function get()
	{
    	$query = self::$query;
    	$stmt = self::$conn->prepare($query);
    	foreach(self::$bind as $key => $value)
    	{
         	$stmt->bindValue($key, $value);
    	}
    	$stmt->execute();
    	$result = $stmt->fetchAll();
       
    	return $result;
	}

	public static function insert()
	{
	    self::$query = "INSERT ";
	    $counter = 0;
	    return new static;
	}

	public static function into($table_name)
	{
	    self::$query = self::$query." INTO ".$table_name;
	    return new static;
	}

	public static function columns($columns)
	{
	    self::$query = self::$query."(";
	    $counter = 0;
	    foreach($columns as $column)
	    {
	      self::$query = self::$query.$column;
	      if($counter+1 < count($columns))
	      {
	        self::$query = self::$query.",";
	      }
	      $counter++;
	    }
	    self::$query = self::$query.")";
	    return new static;
   }

	public static function values($values)
	{
	    self::$query = self::$query." VALUES(";
	    $counter = 0;
	    foreach($values as $value)
	    {
	        self::$bind[] = $value;
	        self::$query = self::$query."?";
	        if($counter+1 < count($values))
	        {
	            self::$query = self::$query.",";
	        }
	        $counter++;
	    }
	    self::$query = self::$query.") ";
	    return new static;
	}

	public static function save()
	{
      self::execute();	
       
	}

  public static function execute()
  {

      echo self::$query .'<br>';
      $stmt = self::$conn->prepare(self::$query);
 
      foreach(self::$bind as $key => $value)
      {
          $stmt->bindValue($key, $value);
      }
      $result = $stmt->execute();
       
      return $result;
  }


}

?>