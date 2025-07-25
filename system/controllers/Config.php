<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('bd_auth');
		bd_check_auth('config_settings');
		$this->load->helper('az_menu');
		$this->load->helper('array');
		$this->config->load('menu');
		$this->load->library('RajaOngkir');

	}

	public function index()
	{
		$this->load->library('AZApp');
		$app = $this->azapp;
		$data_header['title'] = azlang('Configurationt');
		$data_header['breadcrumb'] = array('settings','config_settings');
		$app->set_data_header($data_header);

		$response = $this->rajaongkir->endpoints->province();
		$data['province'] = $response['data'] ?? [];

		$data['config_application'] = get_config_application();	

		$file = $app->add_file();
		$file->set_file_size('1 MB');
		$file->set_id('img');
		$file->set_file_dir('img/favicon.jpeg');
		$file->set_path(base_url() . AZAPP . 'assets/');
		$data['logo'] = $file->render();

		$view = $this->load->view('config/v_config', $data, true);
		$app->add_content($view);

		$js = az_add_js('config/vjs_config');
		$app->add_js($js);

		echo $app->render();	
	}

	public function save()
	{

		$err_code = 0;
        $err_message = "";

		$this->form_validation->set_rules('app_name', 'Nama Aplikasi', 'required');
		$this->form_validation->set_rules('about', 'About', 'required');

		if($this->form_validation->run() == FALSE){
			$err_code++;
			$err_message = validation_errors();
		}

		$data_post = $this->input->post();
		// echo"<pre>";print_r($data_post);die;

		if ($err_code == 0) {
			foreach ($data_post as $key => $value) {
				$this->db->where('key', $key);
				$this->db->update('config', ['value' => $value]);
			}
		}

		$data = [
			"err_code" => $err_code,
			"err_message" => $err_message,
		];
		// var_dump($data);die;
		echo json_encode($data);
	}
}
