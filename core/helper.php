<?php 
use Core\Session;

class Helper
{
	function link_asset($path)
	{
		echo str_replace('//', '/' ,'/public/'.$path);
	}

	function csrf_token()
	{
		echo Session::generate_csrf_token();
	}
}

?>