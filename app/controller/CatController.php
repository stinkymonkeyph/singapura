<?php 

// Sample Class
namespace App\Controller;

// Default namespace used
use Core\Router;
use Core\View;
use Core\Database as DB;

// User defined namespace used
use App\Model\Cat; 

class CatController
{

	public function list_cat()
	{
		$all = DB::select()->from(Cat::table)->get(); //gets all cat, uses Cat model table constant 
 		$filtered = DB::select()->from(Cat::table)->where('name', 'alisha')->get(); //filtered query
 		$join = DB::select(['cat.name as cat','breed.name as breed'])->from(Cat::table)->join('breed','cat.breed_id','breed.id')->get();
 		self::insert_cat();
 		//self::delete_cat();
 		//self::update_cat();
		// Returns a View along with data as array
		return View::render(
			'cats',
			[
				'cats' => $all,
				'cat_filtered' => $filtered,
				'join' => $join
			]
		);
	}

	public static function update_cat()
	{
 		DB::update(Cat::table)->set('name','alisha')->where('name', 'kanye')->execute(); 
	}

	public static function delete_cat()
	{
		DB::delete()->from(Cat::table)->where('name','alisha')->execute(); 
	}

	public static function insert_cat()
	{
		DB::insert()->into(Cat::table)->columns(['name','breed_id'])->values(['kanye', 1])->save();
	}

}

?>