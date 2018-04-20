# Singapura
***A micro php framework***
> <br>
> <img height="300px" src="https://github.com/stinkymonkeyph/singapura/blob/master/who.jpg"></img>
> <br>

## Learning is Fun
Been using php frameworks lately, it's too mainstream. How about ? making our own and learning the shit out of these frameworks

# Propositum
Develop a micro php web framework

# Cliché
Yes! I'm reinventing the wheel, and it is another piece of shit

# TODO

1. Add complex query support for the database handler

# Folder Structures

> <br>
> <img height="300px" src="https://github.com/stinkymonkeyph/singapura/blob/master/tree.JPG"></img>
> <br>

1. app
	* Contains the folders controller and model

2. core
	 * cotains the core files of the framework
	 	* autoloader
	 	* router
	 	* database handler
	 	* config
	 * external folder
	 	* contains external scripts/files from other author

3. public
 	* contains index.php

4. routes
	* contains routes.php

5. views.
 	* will contain all view templates

6. engine 
	* runs framework features using CLI
		* run server
		* creating controller
		* creating model

 # Engine 

 1. Run PHP Server - using CLI
 	* php engine run_server
 	* php engine run_server ip:port

> <br>
> <img height="300px" width="800px" src="https://github.com/stinkymonkeyph/singapura/blob/master/server_cli.JPG"></img>
> <br>


 # Code Snippets - Usage - Manual - Description

 1. ***Configuration*** <br>
 	located at - core/config.php <br>
 	here you set the database configuration for your application
 	```php
 	<?php

 	namespace Core;

	class Config
	{
		  public static $db_name = "singapura";
		  public static $db_user = "root";
		  public static $db_pass = "";
		  public static $db_host = "localhost";
		  public static $dbms = "mysql"; //currently supports mysql
		  public static $debugging = True; //True or False  
	}

 2. ***Routing*** <br>
 	located at - routes/routes.php <br>
 	```php
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

	// Sample Route using a call back function to get all
	// post data request
	Route::post('/test/form', function()
	{
		$data = Core\Request::post_data();
		
		foreach($data as $key => $value)
		{
			echo $key .' = '. $value . '<br>' ;
		}
		var_dump($_SESSION['csrf_tokens']);
	});

	// Get data routing
	Route::get('/cat/lover/{id}/{data}', function()
	{
		$data = Core\Request::get_data();
		echo $data['id'] .'<br>';
		echo $data['data'] .'<br>';
	});

3. ***Controllers*** <br>
	located at - controller/your_controller
	```php
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
	 		$or = self::select_or();
	 		$and = self::select_and();
	 		$where_and = self::where_and();
	 		$where_or = self::where_or();
	 		
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
					'where_or' => $where_or
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
			return DB::select()->from(Cat::table)->where('name', 'ashley')
				   ->or('name', 'tom')->or('name', 'kittie')->get();
		}

		public function select_and()
		{
			return DB::select()->from(Cat::table)->where('name', 'ashley')
				   ->and('name', 'tom')->and('name', 'kittie')->get();
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
		}

	}

4. ***templating/view*** <br>
   Uses phpti, for php template inheritance <br>
   phpti website - http://arshaw.com/phpti/ <br>
   Template is rendered in index.php - located at public/index.php <br>

   Below is an example of a view structure <br>
   All files is located at /views

   ***master.php*** - the base template, located at /views/layout

   ```html 
   <!DOCTYPE html>
	<html>
	<head>
		<title><?php emptyblock('title') ?></title>
		<?php include_template('header') ?>
	</head>
	<body>
		<?php emptyblock('content') ?>
	</body>
	</html>
	```

  	***header.php*** - included in the base template ***master.php*** 

  	```html
	<link href="https://fonts.googleapis.com/css?family=Anton|Work+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php Helper::link_asset('asset/css/app.css') ?>">
  	```

  	***body.php*** - includes the base template

  	```html
  	<?php include_template('layout.master') ?>
	<?php startblock('title') ?>
		Welcome Meow
	<?php endblock('title') ?>
	<?php startblock('content') ?>
	<div class="container">
		<p class="head-title">Singapura</p>
		<p class="head-description"><b>A Micro PHP Web Framework</b></p>
		<p class="head-love">Made with &#10084 from <a href="https://github.com/stinkymonkeyph/singapura" class="link"><b>github</b></a></p>
		<center>
			<img src="<?php Helper::link_asset('asset/image/who.jpg') ?>" class="singapura" />
		</center>
		<b><p class="head-body">Propositum</p></b>
		<p class="head-body-description">
			Develop a micro php fucking web framework, that doesn't come <br> with unnecessary packages
		</p>
		<b><p class="head-body">Cliché</p></b>
		<p class="head-body-description">
			Reinventing the wheel ! Another piece of shit
		</p>
	</div>
	<?php endblock('content') ?>
  	```

  	***index.php*** code snippet, renders the template

  	```php
  	<?php
  	...
  	// Render Template
	Core\View::render_template();
  	...
  	```

5. ***Database Handler*** <br>
   located at - core/database.php <br> <br>
    A. Select Statements 
    ```php
    <?php
    use Core\Database as DB;

   	$select_all = DB::select()->from('cat');
   	$select_one = DB::select('name')->from('cat')->where('name', 'ashley')->execute();
   	$select_with_attributes = DB::select(['id','name'])->from('cat');	
   	```
    B. Insert Statements
    ```php
    <?php 
    use Core\Database as DB;

    $insert_single = DB::insert()->into('cat')->columns('name')->values('kanye')->save();
    $insert_array = DB::insert()->into('cat')->columns(['name', 'breed_id'])->values(['ashley',1])->save();
    ``` 
    C. Delete Statements
    ```php
    <?php 
    use Core\Database as DB;

    $delete_all = DB::delete()->from('cat')->execute();
    $delete_with_condition = DB::delete()->from('cat')->where('name', 'alisha')->execute();
    ```
    D. Update Statements
    ```php
    <?php 
    use Core\Database as DB;

    $update_simple = DB::update('cat')->set('name','alisha')->where('name','kanye')->execute();
    ```
    E. Multiple Where Statements
    ```php
    <?php 
    use Core\Database as DB;

    // where_and function only works with different attribute names
	// where_and function fails if you are comparing two same attributes
	// instead use where()->and()->and() if dealing with multiple and 
	// statements with same column names
    $where_and = DB::select()->from('cat')->where_and(
		[
			'name' => 'ashley',
			'breed_id' = 1
		]
    )->get();

    // where_or function only works with different attribute names
	// where_or function fails if you are comparing two same attributes
	// instead use where()->or()->or() if dealing with multiple OR 
	// statements with same column names
    $where_or = DB::sect()->from('cat')->where_or(
	    [
	    	'name' => 'ashley',
	    	'breed_id' = 1
	    ]
    )->get();
    
    ```
    F. AND Statements
    ```php
    <?php
    use Core\Database as DB;
    
    $single_and = DB::select()->from('cat')->where('name', 'alisha')->and('name', 'kanye')->get();
    $multiple_and = DB::select()->from('cat')->where('name', 'alisha')->and('name', 'kanye')
    				->and('name', 'kittie')->get();
    ```
    G. OR Statements
    ```php
    <?php
    use Core\Database as DB;

    $single_or = DB::select()->from('cat')->where('name', 'alisha')->or('name', 'kanye')->get();
    $multiple_or = DB::select()->from('cat')->where('name', 'alisha')->and('name', 'kanye')
    			   ->or('name', 'kittie')->get();
    ```
    H. JOIN Statements
    ```php
    <?php
    use Core\Database as DB;

    $select_join = DB::select(['cat.name as cat', 'breed.name as breed'])->from('cat')
    			   ->join('breed', 'cat.breed_id', 'breed.id')->get();
    ```
# Special Thanks

> **Adam Shaw** for creating phpti, thank you for making template inheritance simplier <br>
> **phpti** - https://github.com/arshaw/phpti


# Inspiration

> **Taylor Otwell** the man behind Laravel Framework <br>
> **Laravel** - https://github.com/laravel/laravel



