<?php 

/**
	Sample Class
**/

namespace App\Controller;

use Core\Router;
use Core\Database;

class CatController
{

	public static function hello_world()
	{
	
		$result = Database::select()->from('cat')->get();
		foreach($result as $cat)
		{
			echo $cat['name'] . '<br>';
		}
	}

}

?>