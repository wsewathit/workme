<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$location = APPPATH.'modules/fontend/controllers/fontend_controller'.EXT;
if (is_file($location)) {
	include_once $location;
}

class Fontend extends Fontend_controller {

	public function __construct(){
		parent::__construct(); 
		
	}
	public function index()
	{
		$this->template->set_template('default');
		$this->template->write('title','HELLO MYGIT');
		$this->template->write_view('head','template/head_view');
		$this->template->write_view('content','index_view');
		$this->template->write_view('footer','template/footer_view');
		$this->template->render();
	}

	
}