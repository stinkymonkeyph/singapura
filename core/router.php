<?php 

namespace Core;

class Router
{
	private static $path;

	public static function parse_route($uri)
	{
		$request_uri = explode('?', $uri, 2);
		self::$path = str_replace('/public','',$request_uri[0].'/');	
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

		
		self::$path = str_replace('//', '/', self::$path);

		if(self::$path == $path)
		{
			if(is_callable($method))
			{
				$method();
			}
			else if(is_array($method))
			{
				$class_function = self::extract_class_function($method[0]);
				$class =  self::append_controller_prefix($class_function[0]);
				$function = $class_function[1];
				self::execute_class_function($class, $function);
			}
			else if(strpos($method, '@') !== false)
			{
				$class_function = self::extract_class_function($method);
				$class = self::append_controller_prefix($class_function[0]);
				$function = $class_function[1];
				self::execute_class_function($class, $function);
			}
		}

	}
			
	private static function extract_class_function($class_function)
	{
		return explode('@', $class_function);
	}

	private static function append_controller_prefix($class)
	{
		return 'App\Controller\\'. $class;
	}

	private static function execute_class_function($class, $function)
	{
		$class::$function(); 
	}

	public static function load_routes()
	{
		include __DIR__.'/../routes/routes.php';
	}

}


?>