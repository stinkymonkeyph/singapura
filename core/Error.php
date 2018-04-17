<?php 

namespace Core;

use Core\View;
use Core\Config;
use Throwable;

class Error
{
	public function catch_error(Throwable $error)
	{
		if(Config::$debugging)
		{
			$trace = explode("\n", $error->getTraceAsString());
			$class = explode(":", $trace[0]);
			View::render_error(
				[
					'errors' => $error->getMessage(),
					'traces' => $trace
				]
			);
		}
	}

}

?>