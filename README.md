# Singapura
A micro php framework
> <br>
> <img height="300px" src="https://github.com/stinkymonkeyph/singapura/blob/master/who.jpg"></img>
> <br>

## made for fun, made to learn
Been using php frameworks lately, it's too mainstream. How about ? making our own and learning the shit out of these frameworks

# Propositum

Develop a micro php fucking web framework, that doesn't come with unnecessary packages

# Cliché

Reinventing the wheel ! Another piece of shit

# TODO

1. Add complex query support for the database handler

# Project tree

> <br>
> <img height="300px" src="https://github.com/stinkymonkeyph/singapura/blob/master/tree.JPG"></img>
> <br>

## Folder/Files

1. app.
	* Contains the folders controller and model

2. core.
	 * cotains the core files of the framework
	 	* autoloader
	 	* router
	 	* database handler
	 	* config
	 * external folder
	 	* contains external scripts/files from other author

3. public.
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


 # Manual

 1. Configuration
 	* located at - core/config.php
 	...
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
 	...

# Special Thanks

> **Adam Shaw** for creating phpti, thank you for making template inheritance simplier <br>
> **phpti** - https://github.com/arshaw/phpti


# Inspiration

> **Taylor Otwell** the man behind Laravel Framework <br>
> **Laravel** - https://github.com/laravel/laravel



