<?php 

// Sample Class
namespace App\Controller;

// Default namespace used
use Core\Singapura\Router;
use Core\Singapura\View;
use Core\Singapura\Database as DB;

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
 		$or = self::select_or();
 		$and = self::select_and();
 		$where_and = self::where_and();
 		$where_or = self::where_or();
 		$multiple_join = self::cat_owner_join();
 		$cross_join = self::cat_cross_join();

 		//self::insert_raw();
 		//self::insert_cat();
 		//self::delete_cat();
 		//self::update_cat();

		// Returns a View along with data as array
		return View::render(
			'cats',
			[
				'cats' => $all,
				'cat_filtered' => $filtered,
				'join' => $join,
				'or' => $or,
				'and' => $and,
				'where_and' => $where_and,
				'where_or' => $where_or,
				'multiple_join' => $multiple_join,
				'cross_join' => $cross_join
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
		return DB::select(['cat.name as cat','breed.name as breed'])->from(Cat::table)
				   ->join('breed','cat.breed_id','breed.id')->get();
		//sample query using join function
	}

	public function select_raw()
	{
		return DB::raw("SELECT * FROM cat"); 
		//sample query using raw 
		// raw function can execute any query provided by the developer
		// take note that data should be sanitize, raw function does not sanitize data
	}

	public function select_or()
	{
		return DB::select()->from(Cat::table)->where('name', 'ashley')->or('name', 'tom')->or('name', 'kittie')->get();
	}

	public function select_and()
	{
		return DB::select()->from(Cat::table)->where('name', 'ashley')->and('name', 'tom')->and('name', 'kittie')->get();
	}

	public function where_and()
	{
		// where_and function only works with different attribute names
		// where_and function fails if you are comparing two same attributes
		// instead use where()->and()->and() if dealing with multiple and 
		// statements with same column names
		return DB::select()->from(Cat::table)->where_and(
			[
				'name' => 'ashley',
				'breed_id' => 1
			]
		)->get();
	}

	public function where_or()
	{
		// where_or function only works with different attribute names
		// where_or function fails if you are comparing two same attributes
		// instead use where()->or()->or() if dealing with multiple OR 
		// statements with same column names
		return DB::select()->from(Cat::table)->where_or(
			[
				'name' => 'ashley',
				'breed_id' => 1
			]
		)->get();
	}

	public function insert_raw()
	{
		return DB::raw('INSERT INTO cat (name, breed_id) values("tom",1)');
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
		DB::insert()->into('cat_owner')->columns(['cat_id', 'owner_id'])->values([1,1])->save();
	}

	public function cat_owner_join()
	{
		return DB::select(['cat.name as cat', 'owner.name as owner'])->from(Cat::table)
				   ->join('cat_owner', 'cat_owner.cat_id', 'cat.id')
				   ->join('owner', 'owner.id',  'cat_owner.owner_id')->get();
	}

	public function cat_cross_join()
	{
		return DB::select(['cat.name as cat', 'breed.name as breed'])->from(Cat::table)
				   ->cross_join('breed')->get();
	}

}

?>