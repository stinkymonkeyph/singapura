<?php 

namespace Core;
use Core\Session;
use Core\Error;
use Exception;

class Router
{
	private static $path;
	private static $request_type;
	private static $csrf_token;
	private static $path_found = False;

	public function parse_route($uri)
	{
		$request_uri = explode('?', $uri, 2);
		self::$path = str_replace('/public','',	'/'.$request_uri[0].'/');
		self::$request_type = $_SERVER['REQUEST_METHOD'];
		if(self::$request_type === 'POST')
		{
			self::$csrf_token = $_POST['csrf_token'];	
		}
	}

	public function get($path, $method)
	{	
		if(self::$request_type === 'GET')
			self::execute_route($path, $method);
	}

	public function post($path, $method)
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
				throw new Exception("Router Error : Invalid csrf token, cannot verify post request");
			}
		} 	
	}

	private function execute_route($path, $method)
	{
		self::$path = str_replace('//', '/', self::$path);
		$last_pos = strlen($path) - 1;

		if($path[$last_pos] != '/')
			$path = $path.'/';

		if($path[0] != '/')
			$path = '/'.$path;
		
		if(self::$path == $path)
		{
			self::$path_found = True;
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
			
	private function extract_class_function($class_function)
	{
		return explode('@', $class_function);
	}

	private function append_controller_prefix($class)
	{
		return 'App\Controller\\'. $class;
	}

	private function execute_class_function($class, $function)
	{
		$class::$function(); 
	}

	public function load_routes()
	{
		include __DIR__.'/../routes/routes.php';

		if(!self::$path_found)
			throw new Exception("Router Error: Invalid route");
			
	}

	public function get_post_data()
	{
		return $_POST;
	}

	public function extract_post_data($name)
	{
		return $_POST[$name];
	}

	private function is_token_valid($token)
	{
		return Session::token_exists($token);
	}

}


?>