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
 		self::insert_cat();
 		self::delete_cat();
		// Returns a View along with data as array
		return View::render(
			'cats',
			[
				'cats' => $all,
				'cat_filtered' => $filtered
			]
		);
	}

	public static function update_cat()
	{
		
 		$update = DB::update(Cat::table)->set(['name' => 'Kanye'])->where('name', 'Ash')->execute(); //update query
	}

	public static function delete_cat()
	{
		$delete = DB::delete()->from(Cat::table)->where('name','alisha')->execute(); //delete query
	}

	public static function insert_cat()
	{
		$insert = DB::insert()->into(Cat::table)->columns(['name'])->values(['alisha'])->save();

	}

}

?>