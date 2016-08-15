<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$location = APPPATH.'modules/project/controllers/project_controller'.EXT;
if (is_file($location)) {
	include_once $location;
}

class Project extends Project_controller {

	public function __construct(){
		parent::__construct(); 
		
	}
	public function index()
	{
		$this->template->set_template('default');
		$this->template->write_view('content','index_view');
		$this->template->render();
	}

	
}