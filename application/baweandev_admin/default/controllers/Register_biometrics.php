<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_biometrics extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('bd_auth');
		bd_check_auth('register_biometrics');
		$this->load->helper('az_menu');
		$this->load->helper('array');

	}

	public function index()
	{
		$this->load->library('AZApp');
		$app = $this->azapp;

		$view = $this->load->view('register_biometrics/v_register_biometrics', '', true);
		$app->add_content($view);

		$js = az_add_js('register_biometrics/vjs_register_biometrics');
		$app->add_js($js);

        $data_header['title'] = azlang('Register Biometrics');
		$data_header['breadcrumb'] = array('device_control','register_biometrics');
		$app->set_data_header($data_header);

		echo $app->render();	
	}

	public function save()
	{

		$err_code = 0;
        $err_message = "";

		$this->form_validation->set_rules('iduser', 'User', 'required');

		if($this->form_validation->run() == FALSE){
			$err_code++;
			$err_message = validation_errors();
		}

		if ($err_code == 0) {
			$iduser = $this->input->post('iduser');

			// Simpan ke database
			$data = array(
				'iduser' => $iduser,
				'card_uid' => $this->input->post('card_uid'),
				'fingerprint' => $this->input->post('fingerprint'),
				'vein' => $this->input->post('vein'),
				'face' => $this->input->post('face'),
				'aktif' => 1
			);

			$this->db->insert('user_biometrics', $data);
		}

		$data = [
			"err_code" => $err_code,
			"err_message" => $err_message,
		];
		// var_dump($data);die;
		echo json_encode($data);
	}

}
