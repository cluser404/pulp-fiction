<?php namespace lib;

class Controller {
	function dispatch($templateEngine, $vars) {
		switch ($_SERVER["REQUEST_METHOD"]) {
			case "GET":
				$this->get($vars);
				break;
			case "POST":
				$this->post($vars);
				break;
			case "PUT":
				$this->put($vars);
				break;
			case "DELETE":
				$this->delete($vars);
				break;
		}
	}
}
?>