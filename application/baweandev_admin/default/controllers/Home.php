<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('bd_auth');
		bd_check_auth('dashboard');
	}

	public function index()
	{
		$this->load->library('AZApp');
		$app = $this->azapp;
		$data_header['title'] = azlang('Dashboard');
		$data_header['breadcrumb'] = array('dashboard');
		$app->set_data_header($data_header);


		$view = $this->load->view('home/v_home', '', true);
		$app->add_content($view);

		$js = az_add_js('home/vjs_home');
		$app->add_js($js);

		echo $app->render();	
	}
}
