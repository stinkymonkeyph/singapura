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

	 private function connect_db()
	{
  		$conn = new DatabaseConnector();
  		self::$conn = $conn->db_handler();
	}

  public function update($table)
  {
      //update()->set()->where()->execute();
      self::connect_db();
      self::$query = "UPDATE ".$table ;

      return new static;
  }

   private function set_single($key, $value)
  {
      self::$query = self::$query." SET ".$key." =:".$key.'_update';
      self::bind_set($key.'_update', $value);
      return new static;
  }

   private function set_array($key_value)
  {
      self::$query = self::$query." SET ";
      $counter = 0 ;
      foreach($key_value as $key => $value)
      {
          self::$query = self::$query.$key." = :".$key.'_update';
          self::bind_set($key.'_update', $value);
          if($counter+1 < count($key_value))
          {
             self::$query = self::$query.", ";
          }
      }
  }

  public function set($key_value, $value = null)
  {
      if(is_array($key_value) && $value == null)
          self::set_array($key_value);
      else
          self::set_single($key_value, $value);
      return new static;
  }

  public function delete()
  {
        //delete()->from(table_name)->where(column, value)->execute();
        self::connect_db();
        self::$query = "DELETE ";

        return new static;
  }

	public function select($attributes = null)
	{
      //select(attributes)->from(table_name)->where(column, value)->get();
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

  public function from($table_name)
  {    
        
	 	  self::$query = self::$query." FROM ".$table_name;
    	return new static;
  }

 	 private function where_single($key, $value)
	{
    	self::$query = self::$query." WHERE ".$key." =:".$key;
    	self::bind_set($key, $value);
    	return new static;
	}

   private function where_array($key_value)
  {
      self::$query = self::$query." WHERE " ;
      $counter = 0;
      foreach($key_value as $key => $value)
      {
          self::$query = self::$query.$key." =:".$key." ";
          self::bind_set($key, $value);
          if($counter+1 < count($key_value))
          {
              self::$query = self::$query.", ";
          }
          $counter++;
      }

      return new static;
  }

  public function where($key_value, $value = null)
  {
      if(is_array($key_value) && $value == null)
          self::where_array($key_value);
      else
          self::where_single($key_value, $value);
      return new static;
  }

  public function where_and($key_value)
  {
        self::$query = self::$query." WHERE ";
        $counter = 0;
        foreach($key_value as $key => $value)
        {
            self::$query = self::$query.$key." =:".$key." ";
            self::bind_set($key, $value);
            if($counter+1 < count($key_value))
            {
                self::$query = self::$query." AND ";
            }
            $counter++;
        }
        return new static;
  }

	 private function bind_set($key, $value)
	{
    	self::$bind[':'.$key] = $value;
    	return new static;
	}

	public function and($key, $value)
	{
 	    self::$query = self::$query." AND ";
    	self::$query = self::$query.$key." = :".$key;
    	self::bind_set($key, $value);
    	return new static;
	}

	public function get()
	{
    	$stmt = self::$conn->prepare(self::$query);
    	foreach(self::$bind as $key => $value)
    	{
         	$stmt->bindValue($key, $value);
    	}
    	$stmt->execute();
    	$result = $stmt->fetchAll();
      self::reset_bind();
    	return $result;
	}

	public function insert()
	{
	    self::$query = "INSERT ";
	    $counter = 0;
	    return new static;
	}

	public function into($table_name)
	{
	    self::$query = self::$query." INTO ".$table_name;
	    return new static;
	}

   private function column_single($column)
  {
      self::$query = self::$query."(".$column.")";
      return new static;
  }

   private function column_array($columns)
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

	public function columns($columns)
	{
	    if(is_array($columns))
        self::column_array($columns);
      else
        self::column_single($columns);
      return new static;    
  }

   private function values_single($value)
  {
      self::$query = self::$query." VALUES(?)";
      self::$bind[] = $value;

      return new static;
  }

   private function values_array($values)
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
  }

	public function values($values)
	{
	    if(is_array($values))
        self::values_array($values);
      else
        self::values_single($values);
      return new static;
	}

	public function save()
	{
       $stmt = self::prepare_statement();
       $stmt->execute(self::$bind);
       self::reset_bind();	
	}

  public function execute()
  {
      $stmt = self::prepare_statement(); 
      foreach(self::$bind as $key => $value)
      {
          $stmt->bindValue($key, $value);
      }
      $result = $stmt->execute();
      self::reset_bind();
      return $result; 
  }

   private function prepare_statement()
  {
     return self::$conn->prepare(self::$query);
  }

   private function reset_bind()
  {
      self::$bind = array();
  }

}

?>