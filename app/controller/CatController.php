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

	public static function update_cat($key_value)
	{
		$value_key = array();

		foreach($key_value as $key => $value)
		{
			$value_key[] = ($key => $value);
		}

 		$update = DB::update(Cat::table)->set(['name' => 'Kanye'])->where('name', 'Ash')->execute() //update query
	}

}

?>