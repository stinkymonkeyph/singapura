<?php 

namespace Core;
use Core\Session;
use Core\Error;
use Exception;
use Core\Request;

class Router
{
	private static $path;
	private static $chunk_path;
	private static $request_type;
	private static $csrf_token;
	private static $path_found = False;
	private static $variables = array();

	public function __construct(Request $request)
	{
		self::$path = $request->uri();
		self::$request_type = $request->type();
		self::$csrf_token = $request->csrf_token();
	}

	public function get($path, $method)
	{	
		if(self::$request_type === 'GET' && self::$path_found != True)
		{
			self::extract_get_data($path);
			self::execute_route($path, $method);
		}
	}

	public function extract_get_data($path)
	{
		if(strpos($path, '/{') !== false)
		{
			$exploded_path = explode('{', $path);
			self::$chunk_path = $exploded_path[0];

			foreach($exploded_path as $chunk)
			{
				if(strpos($chunk, '}') !== false)
				{
					$clean_variable = str_replace('}', '', $chunk);
					$clean_variable = str_replace('/', '', $clean_variable);
					self::$variables[] = $clean_variable;
				}
			}

			if(strpos(self::$path, self::$chunk_path) !== false)
			{
				$explode_chunks = explode('/', self::$chunk_path);
				$explode_path = explode('/', self::$path);
				$path_size = sizeof($explode_path);
				$chunk_size = sizeof($explode_chunks);
				$path_chunk_diff = $path_size - $chunk_size;
				$variable_size = sizeof(self::$variables);

				if($path_chunk_diff == $variable_size)
				{
					$counter = 0;
					for (; $path_chunk_diff <= $chunk_size-1;) 
					{ 
						$path_chunk_diff++;
						$_GET[self::$variables[$counter]] = $explode_path[$path_chunk_diff];
						$counter++;
					}
					self::$path = $path;
					if(self::$path[sizeof(self::$path)] !== '/')
						self::$path .= '/';
				}
			}
		}
	}

	public function post($path, $method)
	{
		if(self::$request_type === 'POST' && self::$path_found !== True)
		{
			if(Session::token_exists(self::$csrf_token))
			{
				self::execute_route($path, $method);
				Session::revoke_csrf_token(self::$csrf_token);
			}
			else
			{
				throw new Exception('Router Error : Invalid csrf token, cannot verify post request');
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
			throw new Exception('Router Error: Invalid route');
	}

}


?>