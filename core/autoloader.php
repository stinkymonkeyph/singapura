<?php 
	

	spl_autoload_register('autoload_register');

	function autoload_register( $class_name ) 
	{
		
		$paths = array(
			'/../app/controller/' ,
			'/../app/models/'
		);

		foreach($paths as $path)
		{
			$file = __DIR__ . $path . $class_name . ".php" ; 
			
			if( file_exists( $file ) ) 
			{
				require $file;
			}
		
		}
	
	}


?>