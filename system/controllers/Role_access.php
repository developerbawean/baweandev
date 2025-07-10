<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_access extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('bd_auth');
		bd_check_auth('role_settings');
		$this->load->helper('az_menu');
		$this->load->helper('array');
		$this->config->load('menu');
	}

	public function index()
	{
		$this->load->library('AZApp');
		$app = $this->azapp;
		$data_header['title'] = azlang('Role Management');
		$data_header['breadcrumb'] = array('settings','role_settings');
		$app->set_data_header($data_header);

		$role_id = $this->session->userdata('idrole');

		$menu_config = $this->config->item('menu');
		$role_id = $this->session->userdata('idrole');
		$data['menu_view'] = render_menu_access($menu_config, $role_id);

		$view = $this->load->view('Role_access/v_Role_access', $data, true);
		$app->add_content($view);

		$js = az_add_js('Role_access/vjs_Role_access');
		$app->add_js($js);

		echo $app->render();	
	}
}
