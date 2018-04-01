# Singapura
***A micro php framework***
> <br>
> <img height="300px" src="https://github.com/stinkymonkeyph/singapura/blob/master/who.jpg"></img>
> <br>

## Learning is Fun
Been using php frameworks lately, it's too mainstream. How about ? making our own and learning the shit out of these frameworks

# Propositum
Develop a micro php fucking web framework, that doesn't come with unnecessary packages

# Cliché
Yes I'm reinventing the wheel, another piece of shit

# TODO

1. Add complex query support for the database handler
2. Error Tracing
3. CLI commands using engine file
4. Session Handling

# Project tree

> <br>
> <img height="300px" src="https://github.com/stinkymonkeyph/singapura/blob/master/tree.JPG"></img>
> <br>

## Folder/Files

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

	Route::get('list/cat', 'CatController@list_cat');

	// Sample Route using function as a parameter
	
	Route::get('/', function(){
		return View::render('body');
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
   located at - core/database.php <br>

   ***SOON TO BE UPDATED*** 

# Special Thanks

> **Adam Shaw** for creating phpti, thank you for making template inheritance simplier <br>
> **phpti** - https://github.com/arshaw/phpti


# Inspiration

> **Taylor Otwell** the man behind Laravel Framework <br>
> **Laravel** - https://github.com/laravel/laravel



