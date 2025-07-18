<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
        parent::__construct();
    }

	public function index(){

		if (strlen($this->session->userdata("iduser")) > 0) {
			redirect(app_url()."home");
		}
		$this->load->view("v_login");
	}

	public function process() {
		$this->load->helper("array");
		$this->load->helper("az_core");
		$username = azarr($_POST, "username");
		$password = azarr($_POST, "password");
		// var_dump($username);
		// var_dump($password);die;

		$ip_address = $this->input->server('HTTP_X_FORWARDED_FOR') 
		? explode(',', $this->input->server('HTTP_X_FORWARDED_FOR'))[0]
		: $this->input->ip_address();

		// Cek apakah user sedang diblokir
		$this->db->where('username', $username);
		$this->db->where('ip_address', $ip_address);
		$attempt = $this->db->get('login_attempts')->row();

		if ($attempt && $attempt->attempts >= 3) {
			$last_time = strtotime($attempt->last_attempt);
			$now = time();
			$wait_seconds = 180; // 3 menit

			if (($now - $last_time) < $wait_seconds) {
				$remaining = $wait_seconds - ($now - $last_time);
				$minutes = floor($remaining / 60);
				$seconds = $remaining % 60;
				$this->session->set_flashdata("error_login", "Terlalu banyak percobaan login. Coba lagi dalam $minutes menit $seconds detik.");
				redirect(app_url()."login");
				return;
			}
		}

		$this->db->select('username, iduser, user.name as user_name, user.idrole, role.name as role_name, user.idoutlet');
		$this->db->where("username", $username);
		$this->db->where("password", sha1($password));
		$this->db->where('user.status', 1);
		$this->db->join('role', 'role.idrole = user.idrole', 'left');
		$data = $this->db->get("user");
		// echo"<pre>";print_r($this->db->last_query());die;

		if ($data->num_rows() > 0) {
			 // Cek apakah masih dalam masa blokir
			if ($attempt && $attempt->attempts >= 3) {
				$last_time = strtotime($attempt->last_attempt);
				$now = time();
				$wait_seconds = 180;

				if (($now - $last_time) < $wait_seconds) {
					$remaining = $wait_seconds - ($now - $last_time);
					$minutes = floor($remaining / 60);
					$seconds = $remaining % 60;
					$this->session->set_flashdata("error_login", "Terlalu banyak percobaan login. Coba lagi dalam $minutes menit $seconds detik.");
					redirect(app_url()."login");
					return;
				}
			}

			// Kalau masa blokir sudah lewat, baru izinkan login sukses
			// Reset login attempt
			$this->db->where('username', $username);
			$this->db->where('ip_address', $ip_address);
			$this->db->delete('login_attempts');

			$data_username = $data->row()->username;
			$data_id = $data->row()->iduser;
			$data_nama_user = $data->row()->user_name;
			$data_idoutlet = $data->row()->idoutlet;
			$data_idrole = $data->row()->idrole;
			$data_role_name = $data->row()->role_name;

			$this->session->set_userdata("username", $data_username);
			$this->session->set_userdata("iduser", $data_id);
			$this->session->set_userdata("name", $data_nama_user);
			$this->session->set_userdata('idoutlet', $data_idoutlet);
			$this->session->set_userdata('idrole', $data_idrole);
			$this->session->set_userdata('role_name', $data_role_name);

			$this->load->helper("string");
			$str = random_string("alnum", 16);
			$random_str = $this->input->ip_address()."-".$str;
			$this->session->set_userdata("trans_session", $random_str);


			// Simpan log login
			$this->db->insert('login_logs', [
				'username' => $username,
				'ip_address' => $ip_address
			]);

			redirect(app_url()."home");
		}		
		else {
			// Gagal login: update login attempts
			if ($attempt) {
				$this->db->where('username', $username);
				$this->db->where('ip_address', $ip_address);
				$this->db->update('login_attempts', [
					'attempts' => $attempt->attempts + 1,
					'last_attempt' => date('Y-m-d H:i:s')
				]);
			} else {
				$this->db->insert('login_attempts', [
					'username' => $username,
					'ip_address' => $ip_address,
					'attempts' => 1,
					'last_attempt' => date('Y-m-d H:i:s')
				]);
			}

			$this->session->set_flashdata("error_login", azlang('Wrong Username/Password'));
			redirect(app_url()."login");
		}	
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect(app_url());
	}
}