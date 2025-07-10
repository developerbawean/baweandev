<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('bd_check_auth')) {
	function bd_check_auth($menu = '', $app = '') {
		$ci = &get_instance();

		if (strlen($ci->session->userdata("iduser")) == 0) {
			redirect(app_url() . "login");
		} else {
			$idrole = $ci->session->userdata('idrole');
			$Baweandev = $ci->session->userdata('username');

			$ci->db->where('idrole', $idrole);

			$ci->db->where('status', 1);
			$ci->db->where('access', 1);
			$data = $ci->db->get('user_role');

			$arr_role = array();
			foreach ($data->result() as $key => $value) {
				$arr_role[] = $value->menu_name;
			}

			if (!in_array($menu, $arr_role)) {
				if ($Baweandev != 'Baweandev') {
					redirect(app_url());
				}
			}
		}
	}
}