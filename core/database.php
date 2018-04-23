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
  private static $has_where = False;

  public function __construct()
  {
        $conn = new DatabaseConnector();
        self::$conn = $conn->db_handler();
  }

  public function update($table)
  {
      //update()->set()->where()->execute();
      self::$query = 'UPDATE '.$table ;

      return new static;
  }

  private function set_single($key, $value)
  {
      self::$query .= ' SET '.$key.' =:'.$key.'_update';
      self::bind_set($key.'_update', $value);
      return new static;
  }

  private function set_array($key_value)
  {
      self::$query .= ' SET ';
      $counter = 0;
      foreach($key_value as $key => $value)
      {
          self::$query .= $key.' = :'.$key.'_update';
          self::bind_set($key.'_update', $value);
          if($counter+1 < count($key_value))
          {
             self::$query .= ', ';
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
        self::$query = 'DELETE ';

        return new static;
  }

	public function select($attributes = null)
	{
      //select(attributes)->from(table_name)->where(column, value)->get();
   	  self::$query = 'SELECT ';
    	
      $counter = 0;
    	if($attributes === null)
   	  {
        self::$query .= ' * ';
    	}
      else
    	{
          foreach($attributes as $column => $value)
          {
              self::$query .= $value;
              if($counter+1 < count($attributes))
              {
                self::$query .= ', ';
              }
              $counter++;
          }
    	}

    	return new static;
	}

  public function from($table_name)
  {    
        
	 	  self::$query .= ' FROM '.$table_name;
    	return new static;
  }

 	public function where($key, $value)
	{
   
      self::$query .=  ' WHERE ';
    	self::$query .= $key.' =:'.$key.' ';
    	self::bind_set($key, $value);
    	return new static;
	}

  public function where_or($key_value)
  {
      self::$query .= ' WHERE ' ;
      $counter = 0;
      foreach($key_value as $key => $value)
      {
          self::$query .= $key.' =:'.$key.' ';
          self::bind_set($key, $value);
          if($counter+1 < count($key_value))
          {
              self::$query .= ' OR ';
          }
          $counter++;
      }
      return new static;
  }

  public function where_and($key_value)
  {
        self::$query .= ' WHERE ';
        $counter = 0;
        foreach($key_value as $key => $value)
        {
            self::$query .= $key.' =:'.$key.' ';
            self::bind_set($key, $value);
            if($counter+1 < count($key_value))
            {
                self::$query .= ' AND ';
            }
            $counter++;
        }
        return new static;
  }

	private function bind_set($key, $value)
	{
    	self::$bind[':'.$key] = self::sanitize_data($value);
    	return new static;
	}

	public function and($key, $value)
	{
      $prefix = self::random_key_prefix();
 	    self::$query .= ' AND ';
    	self::$query .= $key.' = :'.$prefix.$key;
    	self::bind_set($prefix.$key, $value);
    	return new static;
	}

  private function random_key_prefix()
  {
      return mt_rand(0, 5000);
  }

  public function or($key, $value)
  {
      $prefix = self::random_key_prefix();
      self::$query .=  ' OR ';
      self::$query .= $key.' = :'.$prefix.$key;
      self::bind_set($prefix.$key, $value);
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
	    self::$query = 'INSERT ';
	    $counter = 0;
	    return new static;
	}

	public function into($table_name)
	{
	    self::$query .= ' INTO '.$table_name;
	    return new static;
	}

  private function column_single($column)
  {
      self::$query .= '('.$column.')';
      return new static;
  }

  private function column_array($columns)
  {
      self::$query .= '(';
      $counter = 0;
      foreach($columns as $column)
      {
          self::$query .= $column;
          if($counter+1 < count($columns))
          {
            self::$query .= ',';
          }
          $counter++;
      }
      self::$query .= ')';
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
      self::$query .= ' VALUES(?)';
      self::$bind[] = self::sanitize_data($value);

      return new static;
  }

  private function values_array($values)
  {
      self::$query .= ' VALUES(';
      $counter = 0;
      foreach($values as $value)
      {
          self::$bind[] = self::sanitize_data($value);
          self::$query .= '?';
          if($counter+1 < count($values))
          {
              self::$query .= ',';
          }
          $counter++;
      }
      self::$query .= ') ';
  }

	public function values($values)
	{
	    if(is_array($values))
        self::values_array($values);
      else
        self::values_single($values);
      return new static;
	}

  public function raw($raw)
  {
      //using raw function is dangerous, sanitize your data
      return self::$conn->query($raw);
  }

  private function join_append($column_one, $column_two)
  {
      self::$query .= ' ON '.$column_one.' = '.$column_two.' ';
      return new static;
  }

  public function left_join($table, $column_one, $column_two)
  {
      self::$query .= ' LEFT JOIN '.$table.' ';
      self::join_append($column_one, $column_two);
      return new static;
  }

  public function right_join($table, $column_one, $column_two)
  {
      self::$query .=  ' RIGHT JOIN '.$table.' ';
      self::join_append($column_one, $column_two);
      return new static;
  }

  public function cross_join($table, $column_one = null, $column_two = null)
  {
      self::$query .=  ' CROSS JOIN '.$table.' ';
      if(!is_null($column_one) && !is_null($column_two))
        self::join_append($column_one, $column_two); 
      return new static;
  }

  public function join($table, $column_one = null, $column_two = null)
  {
      self::$query .= ' JOIN '.$table.' ';
      if(!is_null($column_one) && !is_null($column_two))
        self::join_append($column_one, $column_two);
      return new static; ;
  }

  // end statements section
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

  private function sanitize_data($data)
  {
      return htmlentities($data);
  }

}

?>