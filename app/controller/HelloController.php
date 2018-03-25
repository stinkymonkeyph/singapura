<?php 

/**
	Sample Class
**/

namespace App\Controller;

use Core\Router;
use Core\Database;

class HelloController 
{

	public static function hello_world()
	{
		echo "hello world <br>";
		$result = Database::select()->from('cat')->get();

		foreach($result as $cat)
		{
			echo $cat['name'];
		}
	}

}

?>