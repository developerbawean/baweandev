<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('bd_auth');
		bd_check_auth('user_settings');
		$this->load->helper('az_menu');
		$this->load->helper('array');
		$this->load->library('AZApp');
		$this->controller = 'user';
		$this->table = 'user';

	}

	public function index()
	{
		$app = $this->azapp;
		$crud = $app->add_crud();

		// $view = $this->load->view('user/v_user', '', true);
		// $app->add_content($view);
		$crud->set_column(array('#', 'Nama', 'No. Handphone','Email','Jabatan', azlang('Action')));
		$crud->set_id($this->controller);
		$crud->set_default_url(true);

		$crud->set_top_filter_btn('
			<button type="button" class="btn btn-success" id="resetFilterBtn">Excel</button>
			<button type="button" class="btn btn-danger" id="resetFilterBtn">PDF</button>
		');
		$btn = " <button class='btn btn-outline-success btn-excel' type='button' id='btn_export'><i class='fa fa-file-excel'></i> Export</button>";
		$btn .= " <button class='btn btn-outline-success btn-excel' type='button' id='btn_export'><i class='fa fa-file-excel'></i> Export</button>";
		$crud->set_btn_top_custom($btn);

		$v_filter = $this->load->view('user/vf_user', '', true);
		$crud->set_top_filter($v_filter);

		$v_modal = $this->load->view('user/v_user', '', true);
		$crud->set_form('form');
		$crud->set_modal($v_modal);
		$crud->set_modal_title(azlang("User"));
		$v_modal = $crud->generate_modal();

		$crud = $crud->render();
		$crud .= $v_modal;	
		$app->add_content($crud);

        $data_header['title'] = azlang('Users');
		$data_header['breadcrumb'] = array('settings','user_settings');
		$app->set_data_header($data_header);

		echo $app->render();	
	}

	public function get() 
	{
		$crud = $this->azapp->add_crud();

		$crud->set_select('iduser, user.name, phone, email, title');
		$crud->set_select_table('iduser, user.name, phone, email, title');
		$crud->set_filter('user.name, phone, email, title');
		$crud->set_sorting('user.name, phone, email, title');
		$crud->add_join_manual('role', 'user.idrole = role.idrole', 'left');
		$crud->set_id($this->controller);
		$crud->add_where("user.status > 0");
		$crud->set_table($this->table);
		$crud->set_custom_style('custom_style');
		echo $crud->get_table();
	}
	public function custom_style($key, $value, $data)
	{
		return $value;
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

	public function edit()
	{
		$this->db->join('role', 'user.idrole = role.idrole', 'left');
		az_crud_edit('iduser, user.name, title, phone, email');
	}

	public function delete()
	{

	}
}
