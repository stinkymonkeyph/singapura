<?php 

/**
	Sample Class
**/

namespace App\Controller;

use Core\Router;
use App\Model\Cat;

class CatController
{

	public static function hello_world()
	{
	
		$result = Cat::select()->from(Cat::$table)->get();
		foreach($result as $cat)
		{
			echo $cat['name'] . '<br>';
		}
	}

}

?>