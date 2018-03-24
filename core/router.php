<?php 

namespace Core;

class Router
{
	private static $path ;
	public static function get_route($uri)
	{
		$request_uri = explode('?', $uri, 2);
		$path = $request_uri[0];
	}
}


?>