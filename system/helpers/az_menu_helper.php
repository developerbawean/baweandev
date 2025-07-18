<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('az_generate_menu_loop')) {
	function az_generate_menu_loop($data_submenu = array(), $arr_menu_name = array(), $breadcrumb = array(), $parent_id = '') {
		$return = '';

		$ci = &get_instance();
		$username = $ci->session->userdata('username');

		foreach ((array) $data_submenu as $key => $value) {
			$url = azarr($value, 'url');
			$icon = azarr($value, 'icon'); // e.g., 'bi-grid'
			$title = azarr($value, 'title');
			$name = azarr($value, 'name');
			$submenu = azarr($value, 'submenu');

			$active = '';
			$collapsed = 'collapsed';
			if ($name == azarr($breadcrumb, 0)) {
				$active = ' active';
				$collapsed = '';
				if (count($breadcrumb) > 0) {
					unset($breadcrumb[0]);
					$breadcrumb = array_values($breadcrumb);
				}
			}

			$show_menu = in_array($name, $arr_menu_name) || $username == 'baweandev';

			if ($show_menu) {
				// Jika punya submenu
				if (is_array($submenu) && count($submenu) > 0) {
					$submenu_id = strtolower($name) . '-nav';
					$return .= '<li class="nav-item">';
					$return .= '<a class="nav-link ' . $collapsed . '" data-bs-target="#' . $submenu_id . '" data-bs-toggle="collapse" href="#">';
					$return .= '<i class="bi ' . $icon . '"></i><span>' . $title . '</span><i class="bi bi-chevron-down ms-auto"></i>';
					$return .= '</a>';
					$return .= '<ul id="' . $submenu_id . '" class="nav-content collapse' . ($collapsed == '' ? ' show' : '') . '" data-bs-parent="#' . ($parent_id ?: 'sidebar-nav') . '">';
					$return .= az_generate_menu_loop($submenu, $arr_menu_name, $breadcrumb, $submenu_id);
					$return .= '</ul>';
					$return .= '</li>';
				} else {
					$return .= '<li class="nav-item">';
					$return .= '<a class="nav-link' . $active . '" href="' . (strlen($url) ? app_url() . $url : '#') . '">';
					$return .= '<i class="bi ' . $icon . '"></i><span>' . $title . '</span>';
					$return .= '</a>';
					$return .= '</li>';
				}
			}
		}

		return $return;
	}
}

if (!function_exists('az_generate_menu')) {
	function az_generate_menu($breadcrumb = array()) {
		$ci = &get_instance();
		$ci->config->load('menu');
		$ci->load->helper('array');
		$menu = $ci->config->item('menu');

		$idrole = $ci->session->userdata('idrole');
		$ci->db->where('idrole', $idrole);
		$ci->db->where('access', 1);
		$ci->db->where('status', 1);
		$data = $ci->db->get('user_role');
		$arr_menu_name = array();
		foreach ($data->result() as $key => $value) {
			$arr_menu_name[] = $value->menu_name;
		}

		$return = '';
		$loop_submenu = az_generate_menu_loop($menu, $arr_menu_name, $breadcrumb);
		$return .= $loop_submenu;
		return $return;
	}
}

if (!function_exists('az_generate_breadcrumb')) {
	function az_generate_breadcrumb($breadcrumb = array()) {
		$ci = &get_instance();
		$ci->load->helper('array');
		$ci->config->load('menu');
		$menu = $ci->config->item('menu');

		$html = '<ol class="breadcrumb">';
		$html .= '<li class="breadcrumb-item"><a href="' . app_url() . '">Home</a></li>';

		if (count($breadcrumb) > 0) {
			$first_menu = azarr($breadcrumb, '0');
			$selected_menu = array();

			foreach ($menu as $key => $value) {
				if (azarr($value, 'name') == $first_menu) {
					$selected_menu = $value;
					break;
				}
			}

			$st_title = azarr($selected_menu, 'title');
			$st_url = azarr($selected_menu, 'url');
			$st_submenu = azarr($selected_menu, 'submenu');
			if (strlen($st_url) == 0) {
				$st_url = 'javascript:void(0)';
			} else {
				$st_url = app_url() . $st_url;
			}

			if (count($breadcrumb) == 1) {
				$html .= '<li class="breadcrumb-item active">' . $st_title . '</li>';
			} else {
				$html .= '<li class="breadcrumb-item"><a href="' . $st_url . '">' . $st_title . '</a></li>';
				unset($breadcrumb[0]);
				$breadcrumb = array_values($breadcrumb);
				$nd_submenu = (array) $st_submenu;

				$total_breadcrumb = count($breadcrumb);
				for ($i = 0; $i < $total_breadcrumb; $i++) {
					$selected_nd_menu = array();
					foreach ((array) $nd_submenu as $value) {
						if (azarr($value, 'name') == $breadcrumb[$i]) {
							$selected_nd_menu = $value;
							break;
						}
					}

					$nd_url = azarr($selected_nd_menu, 'url');
					$nd_title = azarr($selected_nd_menu, 'title');
					$nd_submenu = azarr($selected_nd_menu, 'submenu');

					if ($i == $total_breadcrumb - 1) {
						$html .= '<li class="breadcrumb-item active">' . $nd_title . '</li>';
					} else {
						$html .= '<li class="breadcrumb-item"><a href="' . $nd_url . '">' . $nd_title . '</a></li>';
					}
				}
			}
		}

		$html .= '</ol>';
		return $html;
	}
}

if (!function_exists('render_menu_access')) {
    function render_menu_access($menu_config, $role_id)
    {
        $CI =& get_instance();
        $CI->load->database();

        // Ambil akses menu dari database berdasarkan idrole
        $query = $CI->db->get_where('user_role', ['idrole' => $role_id, 'access' => 1]);
        $user_access = [];
        foreach ($query->result() as $row) {
            $user_access[$row->menu_name] = true;
        }

        $output = '';
        foreach ($menu_config as $menu) {
            $menu_name = $menu['name'];
            $is_checked = isset($user_access[$menu_name]) ? 'checked' : '';

            $output .= '<div class="row align-items-center py-2 border-bottom">
                            <div class="col-md-3">
								<input type="hidden" name="role_name[]" value="'.azarr($menu, 'name').'">
                                <span class="menu-name">'.htmlspecialchars($menu['title']).'</span>
                            </div>
                            <div class="col-md-1">
                                <div class="form-check form-switch">
									<input type="hidden" name="access['.azarr($menu, 'name').']" value="0">
                                    <input class="form-check-input access access-'.azarr($menu, 'name').'" type="checkbox" name="access['.azarr($menu, 'name').']" value="1" '.$is_checked.'>
                                </div>
                            </div>
                            <div class="col-md-8 d-flex flex-wrap gap-3">';
								$role = azarr($menu, 'role', array());
								foreach ($role as $role_key => $role_value) {
									$is_checked_role = isset($user_access[azarr($role_value, 'role_name')]) ? 'checked' : '';
									$output .= '<div class="form-check form-switch">
										<input type="hidden" name="access['.azarr($role_value, 'role_name').']" value="0">
										<input class="form-check-input access access-'.azarr($role_value, 'role_name').'" type="checkbox" name="access['.azarr($role_value, 'role_name').']" value="1" '.$is_checked_role.'>
										<span class="role-name">'.azarr($role_value, 'role_title').'</span>
										<input type="hidden" name="role_name[]" value="'.azarr($role_value, 'role_name').'">
									</div>';
								}
				$output .= '</div>
                        </div>';

            // Submenu
            if (!empty($menu['submenu'])) {
                foreach ($menu['submenu'] as $submenu) {
                    $submenu_name = $submenu['name'];
                    $is_checked_sub = isset($user_access[$submenu_name]) ? 'checked' : '';

                    $output .= '<div class="row align-items-center py-2 border-bottom">
                                    <div class="col-md-3">
										<input type="hidden" name="role_name[]" value="'.azarr($submenu, 'name').'">
                                        <span class="submenu-name">'.azarr($submenu, 'title').'</span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch">
											<input type="hidden" name="access['.azarr($submenu, 'name').']" value="0">
                                            <input class="form-check-input access access-'.azarr($submenu, 'name').'" type="checkbox" name="access['.azarr($submenu, 'name').']" value="1" '.$is_checked_sub.'>
                                        </div>
                                    </div>
                                    <div class="col-md-8 d-flex flex-wrap gap-3">';
										$rolesub = azarr($submenu, 'role', array());
										foreach ($rolesub as $rolesub_key => $rolesub_value) {
											$is_checked_rolesub = isset($user_access[azarr($rolesub_value, 'role_name')]) ? 'checked' : '';
											$output .= '<div class="form-check form-switch">
												<input type="hidden" name="access['.azarr($rolesub_value, 'role_name').']" value="0">
												<input class="form-check-input access access-'.azarr($rolesub_value, 'role_name').'" type="checkbox" name="access['.azarr($rolesub_value, 'role_name').']" value="1" '.$is_checked_rolesub.'>
												<span class="role-name">'.azarr($rolesub_value, 'role_title').'</span>
												<input type="hidden" name="role_name[]" value="'.azarr($rolesub_value, 'role_name').'">
											</div>';
										}
						$output .= '</div>
                                </div>';

                    // Sub-submenu (opsional, jika ada)
                    if (!empty($submenu['submenu'])) {
                        foreach ($submenu['submenu'] as $ssub) {
                            $ssub_name = $ssub['name'];
                            $is_checked_ssub = isset($user_access[$ssub_name]) ? 'checked' : '';

                            $output .= '<div class="row align-items-center py-2 border-bottom ps-4">
                                            <div class="col-md-3">
												<input type="hidden" name="role_name[]" value="'.azarr($ssub, 'name').'">
                                                <span class="submenu-name">'.azarr($ssub, 'title').'</span>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-check form-switch">
													<input type="hidden" name="access['.azarr($ssub, 'name').']" value="0">
                                                    <input class="form-check-input access access-'.azarr($ssub, 'name').'" type="checkbox" name="access['.azarr($ssub, 'name').']" value="1" '.$is_checked_ssub.'>
                                                </div>
                                            </div>
                                            <div class="col-md-8 d-flex flex-wrap gap-3">';
												$rolesubsub = azarr($ssub, 'role', array());
												foreach ($rolesubsub as $rolesubsub_key => $rolesubsub_value) {
													$is_checked_rolesubsub = isset($user_access[azarr($rolesubsub_value, 'role_name')]) ? 'checked' : '';
													$output .= '<div class="form-check form-switch">
														<input type="hidden" name="access['.azarr($rolesubsub_value, 'role_name').']" value="0">
														<input class="form-check-input access access-'.azarr($rolesubsub_value, 'role_name').'" type="checkbox" name="access['.azarr($rolesubsub_value, 'role_name').']" value="1" '.$is_checked_rolesubsub.'>
														<span class="role-name">'.azarr($rolesubsub_value, 'role_title').'</span>
														<input type="hidden" name="role_name[]" value="'.azarr($rolesubsub_value, 'role_name').'">
													</div>';
												}
								$output .= '</div>
                                        </div>';
                        }
                    }
                }
            }
        }

        return $output;
    }
}
