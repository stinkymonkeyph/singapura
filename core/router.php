<?php 

namespace Core;
Use Core\Session;

class Router
{
	private static $path;
	private static $request_type;
	private static $csrf_token;

	public static function parse_route($uri)
	{
		$request_uri = explode('?', $uri, 2);
		self::$path = str_replace('/public','',	'/'.$request_uri[0].'/');
		self::$request_type = $_SERVER['REQUEST_METHOD'];
		if(self::$request_type === 'POST')
		{
			self::$csrf_token = $_POST['csrf_token'];	
		}
	}

	public static function get($path, $method)
	{	
		if(self::$request_type === 'GET')
			self::execute_route($path, $method);
	}

	public static function post($path, $method)
	{
		if(self::$request_type === 'POST')
		{
			if(self::is_token_valid(self::$csrf_token))
			{
				self::execute_route($path, $method);
				Session::revoke_csrf_token(self::$csrf_token);
			}
			else
			{
				echo "Invalid Token";
			}
		}
	}

	private static function execute_route($path, $method)
	{
		self::$path = str_replace('//', '/', self::$path);
		$last_pos = strlen($path) - 1;

		if($path[$last_pos] != '/')
			$path = $path.'/';

		if($path[0] != '/')
			$path = '/'.$path;
		
		if(self::$path == $path)
		{
			if(is_callable($method))
			{
				$method();
				return ;
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

	public static function get_post_data()
	{
		return $_POST;
	}

	private static function is_token_valid($token)
	{
		return Session::token_exists($token);
	}

}


?>