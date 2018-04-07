<?php 

// Default namespace used

use Core\Router as Route;
use Core\View;

// Declare all routes below

// Sample Route using controller@function

Route::get('/list/cat', 'CatController@list_cat');

// Sample Route using a call back function
Route::get('/', function(){
	return View::render('body');
});

Route::get('/test/form', function()
{
	return View::render('form');
});

Route::post('/test/form', function()
{
	$data = Route::get_post_data();
	
	foreach($data as $key => $value)
	{
		echo $key .' = '. $value . '<br>' ;
	}

});

?>