<?php

require dirname(__FILE__).'/flash.php';

// Load BaseModel and all models from models directory
require dirname(__FILE__).'/base_model.php';
foreach (glob(dirname(__FILE__).'/../models/*.php') as $filename){
	require $filename;
}

/**
 * App
 * provides interface for database manipulation, accessing config, rendering views, and JSON responses
 */
class App {
	
	private $directory;
	public $db;
	public $config;
	
	public function __construct(){
		// Save current directory path
		$this->directory = dirname(__FILE__);
		
		// Load configuration options
		$this->config = require $this->directory.'/config.php';
			
		// Load database instance and tell it to connect with given config
		$this->db = require $this->directory.'/database.php';
		$this->db->connect($this->config->database);

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
	}	
	
	/**
	 * Renders given view with given set of variables
	 *
	 * @param string $viewfile path of the view file relative to the views directory, without the ending .php
	 * @param array  $vars     variables for the view; optional `flashMessages` list is merged after session
	 *                         flash from flash_take_all() (each item is a string or legacy `message` array)
	 */
	public function renderView($viewfile, $vars = array()) {
		$sessionFlash = flash_take_all();
		$extraFlash = array();
		if (isset($vars['flashMessages']) && is_array($vars['flashMessages'])) {
			$extraFlash = $vars['flashMessages'];
			unset($vars['flashMessages']);
		}
		$vars['flashMessages'] = array_merge($sessionFlash, $extraFlash);

		// Render array to usable variables
		foreach ($vars as $key => $value) {
			$$key = $value;
		}
		
		// Start capturing of output
		ob_start();
		include $this->directory.'/../views/'.$viewfile.'.php';
		// Assign output to $content which will be rendered in layout
		$content = ob_get_contents();
		// Stop output capturing
		ob_end_clean();
		// Render $content in layout
		include $this->directory.'/../views/layouts/layout.php';
	}

	/**
	 * Send a JSON response and end the request.
	 *
	 * @param array $payload Data to json_encode
	 * @param int   $statusCode HTTP status (default 200)
	 */
	public function renderJson($payload, $statusCode = 200) {
		header('Content-Type: application/json; charset=utf-8');
		http_response_code($statusCode);
		echo json_encode($payload);
		exit;
	}

}

return new App();
