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

		$this->db->where('status', 1);
		$data['role'] = $this->db->get('role');

		$view = $this->load->view('role_access/v_role_access', $data, true);
		$app->add_content($view);

		$js = az_add_js('role_access/vjs_role_access');
		$app->add_js($js);

		echo $app->render();	
	}

	public function save()
	{

		$err_code = 0;
        $err_message = "";

		$this->form_validation->set_rules('idoutlet', 'Outlet', 'required');
		$this->form_validation->set_rules('idrole', 'Role', 'required');

		if($this->form_validation->run() == FALSE){
			$err_code++;
			$err_message = validation_errors();
		}

		
		$idoutlet = $this->input->post('idoutlet');
		$role_id = $this->input->post('idrole');
		$access = $this->input->post('access');

		if ($err_code == 0) {
			if (!empty($access)) {
				foreach ($access as $menu_name => $val) {
					$access_value = ($val == '1') ? 1 : 0;
	
					// Cek apakah data sudah ada untuk kombinasi idoutlet, idrole, dan menu_name
					$this->db->where('idoutlet', $idoutlet);
					$this->db->where('idrole', $role_id);
					$this->db->where('menu_name', $menu_name);
					$data = $this->db->get('user_role');
	
					if ($data->num_rows() > 0) {
						// Update jika sudah ada
						$arr_update = array(
							'access' => $access_value
						);
						$this->db->where('idoutlet', $idoutlet);
						$this->db->where('idrole', $role_id);
						$this->db->where('menu_name', $menu_name);
						$this->db->update('user_role', $arr_update);
					} else {
						// Insert jika belum ada
						$arr_insert = array(
							'idoutlet' => $idoutlet,
							'idrole' => $role_id,
							'menu_name' => $menu_name,
							'access' => $access_value
						);
						$this->db->insert('user_role', $arr_insert);
					}
				}
			}
		}

		$data = [
			"err_code" => $err_code,
			"err_message" => $err_message,
		];
		// var_dump($data);die;
		echo json_encode($data);
	}

	function generate_access() {
		$id = $this->input->post('idrole');
		// var_dump($id);die;
		$this->db->where('idrole', $id);
		$data = $this->db->get('user_role');
		$return = array();
		foreach ($data->result() as $key => $value) {
			$ret = array(
				'menu_name' => $value->menu_name,
				'access' => $value->access
			);
			$return[] = $ret;
		}

		echo json_encode($return);
	}
}
