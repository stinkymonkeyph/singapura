<?php 

namespace Core\Singapura;

use Core\Singapura\View;
use Core\Singapura\Config;
use Throwable;

class Error
{
	public function catch_error(Throwable $error)
	{
		if(Config::$debugging)
		{
			$trace = explode("\n", $error->getTraceAsString());
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