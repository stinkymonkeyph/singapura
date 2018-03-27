<?php 

/**
	Sample Class
**/

namespace App\Controller;

use Core\Router;
use App\Model\Cat;
use Core\View;
use Core\Database as DB;

class CatController
{
	public static function list_cat()
	{
		
		$all = DB::select()->from(Cat::table)->get();
		$filtered = DB::select()->from(Cat::table)->where('name', 'Ash')->get();

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