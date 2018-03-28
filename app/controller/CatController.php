<?php 


// Sample Class

namespace App\Controller;


// Default namespace used

use Core\Router;
use Core\View;
use Core\Database as DB;

// User defined namespace used

use App\Model\Cat; //sample usage of Cat model

class CatController
{

	public static function list_cat()
	{
		
		$all = DB::select()->from(Cat::table)->get(); //gets all cat, uses Cat model table constant 
 		$filtered = DB::select()->from(Cat::table)->where('name', 'Ash')->get(); //filtered query
 		
 		
		// Returns a View along with data as array

		return View::render(
			'body',
			[
				'cats' => $all,
				'cat_filtered' => $filtered
			]
		);
	}

}

?>