<?php 
use Core\Singapura\Session;

class Helper
{
	function link_asset($path)
	{
		echo 'http://'.$_SERVER['HTTP_HOST'].'/'.$path;
	}

	function csrf_token()
	{
		echo Session::generate_csrf_token();
	}
}

?>