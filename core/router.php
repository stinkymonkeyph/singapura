<?php 

namespace Core;

class Router
{
	private static $path;

	public static function parse_route($uri)
	{
		$request_uri = explode('?', $uri, 2);
		self::$path = str_replace('/public','',$request_uri[0]);	
	}

	public static function get($path, $method)
	{
		self::execute_route($path, $method);
	}

	public static function post($path, $method)
	{
		self::execute_route($path, $method);
	}

	private static function execute_route($path, $method)
	{

		if(self::$path == $path)
		{
			if(is_array($method))
			{
				$class_function = explode('@', $method[0]);
				$class_name = 'App\Controller\\'. $class_function[0];
				$function = $class_function[1];
				$class_name::$function(); 
			}
			else
			{
				$method();
			}

		}
			
	}

}


?>