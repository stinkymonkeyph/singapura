<?php 

namespace Core;
session_start();

class Session
{
	// Session and Token Handler Class

	private static $private_key = "someprivatekey";

	public static function start_session()
	{
		$_SESSION['csrf_tokens'] = array();
	}

	public static function generate_csrf_token()
	{
		//generate some random token
		$token = md5(bcrypt(mt_rand(time))) . md5($private_key);
		if(!self::token_exists($token))
			$_SESSION['csrf_tokens'][] = $token; //store in session array
		else
			self::generate_csrf_token();

		echo $csrf_token ;
	}

	public static function revoke_csrf_token($token)
	{
		$revoke = false;
		if(self::token_exists($token))
		{
			$key = array_search($token, $_SESSION['csrf_tokens']);
			unset($_SESSION['csrf_tokens'][$key]);
			$revoke = true;
		}
		return $revoke;
	}

	private static function token_exists($token)
	{
		return in_array($token, $_SESSION['csrf_tokens']);
	}

}


?>