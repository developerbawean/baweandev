<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->library('AZApp');
		$app = $this->azapp;
		
		$this->load->view('welcome_message');
		echo $app->render();	
		// echo"<pre>";print_r($app->render());die;
	}
}
