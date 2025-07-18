<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('bd_check_auth')) {
	function bd_check_auth($menu = '') {
		$ci = &get_instance();

		if (strlen($ci->session->userdata("iduser")) == 0) {
			redirect(app_url() . "login");
		} else {
			$idoutlet = $ci->session->userdata('idoutlet');
			$idrole = $ci->session->userdata('idrole');
			$Baweandev = $ci->session->userdata('username');

			$ci->db->where('idoutlet', $idoutlet);
			$ci->db->where('idrole', $idrole);
			$ci->db->where('status', 1);
			$ci->db->where('access', 1);
			$data = $ci->db->get('user_role');
			// echo"<pre>";print_r($ci->db->last_query());die;

			$arr_role = array();
			foreach ($data->result() as $key => $value) {
				$arr_role[] = $value->menu_name;
			}

			if (!in_array($menu, $arr_role)) {
				if ($Baweandev != 'baweandev') {
					// var_dump($Baweandev);
					// var_dump($menu);
					// var_dump($arr_role);die;
					redirect(app_url());
				}
			}
		}
	}
}