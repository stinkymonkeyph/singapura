<?php 

namespace Core;
@session_start();

class Session
{
	// Session and Token Handler Class
	private static $private_key = "someprivatekey";
	private static $encryption_method = "aes128";

	public static function start_session()
	{
		if(!isset($_SESSION['csrf_tokens']))
			$_SESSION['csrf_tokens'] = array();
	}

	public static function generate_csrf_token()
	{
		//generate some random token
		$token = md5(mt_rand(time(),time())) . md5(self::$private_key);
		
		if(!self::token_exists($token))
			$_SESSION['csrf_tokens'][] = $token; //store in session array
		else
			self::generate_csrf_token();

		echo $token ;
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

	public static function ecnrypt_session($name, $value)
	{
		$encrypted_value = @openssl_encrypt(
				$value, 
				self::$encryption_method, 
				md5(self::$private_key)
		); 
		$_SESSION[$name] = $encrypted_value; 
	}

	public static function decrypt_session($name)
	{
		$decrypt_session = openssl_decrypt(
				$_SESSION[$name], 
				self::$encryption_method, 
				md5(self::$private_key)
		);
		return $decrypt_session;
	}


	public static function token_exists($token)
	{
		return in_array($token, $_SESSION['csrf_tokens']);
	}

}


?>