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
		$all = self::select_all();
 		$filtered = self::filter_cat();
 		$join = self::select_join();
 		$raw = self::select_raw();
 		
 		//self::insert_cat();
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

	public function select_all()
	{
		return  DB::select()->from(Cat::table)->get(); //gets all cat, uses Cat model table constant ;	
	}

	public function filter_cat()
	{
		return DB::select()->from(Cat::table)->where('name', 'alisha')->get(); //filtered query
	}

	public function select_join()
	{
		return DB::select(['cat.name as cat','breed.name as breed'])->from(Cat::table)->join('breed','cat.breed_id','breed.id')->get();
		//sample query using join function
	}

	public function select_raw()
	{
		return DB::raw("SELECT * FROM cat"); 
		//sample query using raw 
		// raw function can execute any query provided by the developer
		// take note that data should be sanitize, raw function does not sanitize data
	}

	public function update_cat()
	{
 		DB::update(Cat::table)->set('name','alisha')->where('name', 'kanye')->execute();
	}

	public function delete_cat()
	{
		DB::delete()->from(Cat::table)->where('name', 'alisha')->execute(); 
	}

	public function insert_cat()
	{
		DB::insert()->into(Cat::table)->columns(['name', 'breed_id'])->values(['kanye', 1])->save();
	}

}

?>