<?php 

namespace Core\Singapura;

class Request extends Session
{
	private static $uri;
	private static $request_type;
	private static $csrf_token;

	public function __construct()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$request_uri = explode('?', $uri, 2);
		self::$uri = '/'.str_replace('/public','', $request_uri[0].'/');
		self::$uri = str_replace('//', '/', self::$uri);
		self::$request_type = $_SERVER['REQUEST_METHOD'];
		if(self::$request_type === 'POST')
		{
			self::$csrf_token = $_POST['csrf_token'];
		}

	}
	
	public function is_valid_token($token)
	{
		return self::token_exists($token);
	}

	public function revoke_token($token)
	{
		self::revoke_csrf_token($token);
	}

	public function uri()
	{
		return self::$uri;
	}

	public function type()
	{
		return self::$request_type;
	}

	public function post_data()
	{
		return $_POST;
	}

	public function get_data()
	{
		return $_GET;
	}

	public function csrf_token()
	{
		return self::$csrf_token;
	}
}

?>