<?php
/**
 * AZApp
 * @author	M. Isman Subakti
 * @copyright	07-03-2016
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("AZ.php");

class CI_AZAppCRUD extends CI_AZ {
	protected $ci = "";
	protected $column = "";
	protected $sort = "";
	protected $width = "";
	protected $th_class = "";
	protected $select = "";
	protected $select_align = "";
	protected $select_number = "";
	protected $select_decimal = "";
	protected $select_date = "";
	protected $filter = "";
	protected $table = "";
	protected $sorting = "";
	protected $join = array();
	protected $join_manual = array();
	protected $select_table = "";
	protected $column_show = array();
	protected $cfilter = array();
	protected $where = array();
	protected $having = array();
	protected $order_by = "";
	protected $url = "";
	protected $url_edit = "";
	protected $url_delete = "";
	protected $url_save = "";
	protected $ttotal_item = "true";
	protected $tinfo = "true";
	protected $tpaginate = "true";
	protected $form = "";
	protected $modal = "";
	protected $modal_title = "";
	protected $special_filter = array();
	protected $single_filter = true;
	protected $custom_style = "";
	protected $edit = true;
	protected $delete = true;
	protected $btn_add = true;
	protected $limit_entries = true;
	protected $btn_save_modal = true;
	protected $custom_btn = "";
	protected $default_url = false;
	protected $callback_save = "";
	protected $callback_add = "";
	protected $callback_delete = "";
	protected $callback_edit = "";
	protected $top_filter = "";
	protected $btn_reset = "";
	protected $btn_top_custom = "";
	protected $data_save = array();
	protected $filter_placeholder = "";
	protected $top_filter_btn = "";
	protected $selected_delete = true;
	protected $selected_button = array();	
	protected $btn_left_modal = array();
	protected $btn_right_modal = array();
	protected $callback_table_complete = '';
	protected $group_by = '';
	protected $aodata = array();
	protected $idtable = '';

	protected $custom_first_column = false;
	protected $last_column_sorting = false;

	// select union
	protected $select_union = "";
	protected $union = '';
	protected $select_id = '';
	// end select union
	protected $manual_query = "";
	//last query
	protected $last_query = "";

	//additional response
	protected $additional_response = null;

	protected $edit_type = "1";

	//close modal on save 
	protected $close_modal_on_save = true;
	protected $before_save = "";

	public function __construct() {
		$this->ci =& get_instance();
		// $this->ci->load->helper("az_crud");
		$this->ci->load->helper("array");
		$this->ci->load->library("encryption");
	}

	public function set_column($data) {
		return $this->column = $data;
	}

	public function set_sort($data) {
		return $this->sort = $data;
	}

	public function set_width($data) {
		return $this->width = $data;
	}

	public function set_th_class($data) {
		return $this->th_class = $data;
	}

	public function set_select($data) {
		return $this->select = $data;
	}

	// select union
	public function set_select_union($data) {
		return $this->select_union = $data;
	}

	public function set_select_id($data) {
		return $this->select_id = $data;
	}
	// end select union

	public function set_manual_query($data) {
		return $this->manual_query = $data;
	}

	public function set_select_table($data) {
		return $this->select_table = $data;
	}

	public function set_select_align($data) {
		return $this->select_align = $data;
	}

	public function set_select_number($data) {
		return $this->select_number = $data;
	}

	public function set_select_decimal($data) {
		return $this->select_decimal = $data;
	}

	public function set_select_date($data) {
		return $this->select_date = $data;
	}

	public function set_filter($data) {
		return $this->filter = $data;
	}

	public function set_table($data) {
		return $this->table = $data;
	}

	public function set_sorting($data) {
		return $this->sorting = $data;
	}

	public function set_top_filter($data) {
		return $this->top_filter = $data;
	}

	public function set_btn_reset($data) {
		return $this->btn_reset = $data;
	}

	public function set_close_modal_on_save($data) {
		return $this->close_modal_on_save = $data;
	}

	public function add_join($data, $type = "", $other = "", $join_x = "") {
		$rdata = array(
			"join" => $data,
			"type" => $type,
			"other" => $other,
			"join_x" => $join_x
		);
		return $this->join[] = $rdata;
	}

	public function add_join_manual($join, $on, $type = 'inner') {
		$jm_data = array(
			"join" => $join,
			"on" => $on,
			"type" => $type
		);
		return $this->join_manual[] = $jm_data;
	}

	public function set_join_multiple($data) {
		return $this->join_multiple = $data;
	}

	public function set_column_show($data) {
		return $this->cfilter = $data;
	}

	public function add_where($data) {
		return $this->where[] = $data;
	}

	public function add_having($data) {
		return $this->having[] = $data;
	}

	public function set_order_by($data) {
		return $this->order_by = $data;
	}

	public function set_url($data) {
		return $this->url = $data;
	}

	public function set_url_edit($data) {
		return $this->url_edit = $data;
	}

	public function set_url_save($data) {
		return $this->url_save = $data;
	}

	public function set_url_delete($data) {
		return $this->url_delete = $data;
	}

	public function set_tinfo($data) {
		return $this->tinfo = $data;
	}

	public function set_ttotal_item($data) {
		return $this->ttotal_item = $data;
	}

	public function set_tpaginate($data) {
		return $this->tpaginate = $data;
	}

	public function set_form($data) {
		return $this->form = $data;
	}

	public function set_modal($data) {
		return $this->modal = $data;
	}
	
	public function set_modal_title($data) {
		return $this->modal_title = $data;
	}

	public function set_special_filter($data) {
		return $this->special_filter = $data;
	}

	public function set_single_filter($data) {
		return $this->single_filter = $data;
	}

	public function set_custom_style($data) {
		return $this->custom_style = $data;
	}

	public function set_edit($data) {
		return $this->edit = $data;
	}

	public function set_delete($data) {
		return $this->delete = $data;
	}

	public function set_custom_first_column($data) {
		return $this->custom_first_column = $data;
	}

	public function set_last_column_sorting($data) {
		return $this->last_column_sorting = $data;
	}

	public function set_btn_add($data) {
		return $this->btn_add = $data;
	}

	public function set_limit_entries($data) {
		return $this->limit_entries = $data;
	}

	public function set_btn_save_modal($data) {
		return $this->btn_save_modal = $data;
	}

	public function set_custom_btn($data) {
		return $this->custom_btn = $data;
	}

	public function set_default_url($data) {
		return $this->default_url = $data;
	}
	
	public function set_before_save($data){
		$this->before_save = $data;
	}

	public function set_callback_save($data) {
		return $this->callback_save = $data;
	}

	public function set_callback_delete($data) {
		return $this->callback_delete = $data;
	}

	public function set_callback_add($data) {
		return $this->callback_add = $data;
	}

	public function set_callback_edit($data) {
		return $this->callback_edit = $data;
	}

	public function set_btn_top_custom($data) {
		return $this->btn_top_custom = $data;
	}

	public function add_data_save($key, $value) {
		return $this->data_save[$key] = $value;
	}

	public function set_filter_placeholder($data) {
		return $this->filter_placeholder = $data;
	}

	public function set_top_filter_btn($data) {
		return $this->top_filter_btn = $data;
	}

	public function set_selected_delete($data) {
		return $this->selected_delete = $data;
	}

	public function add_selected_button($key, $data) {
		return $this->selected_button[$key] = $data;
	}

	public function add_btn_left_modal($key, $data) {
		return $this->btn_left_modal[$key] = $data;
	}

	public function add_btn_right_modal($key, $data) {
		return $this->btn_right_modal[$key] = $data;
	}

	public function set_callback_table_complete($data) {
		return $this->callback_table_complete = $data;
	}

	public function set_group_by($data) {
		return $this->group_by = $data;
	}

	public function add_aodata($key, $data) {
		return $this->aodata[$key] = $data;
	}
	public function set_idtable($data) {
		return $this->idtable = $data;
	}

	public function set_current_last_query($data)
	{
		return $this->last_query = $data;
	}

	public function get_last_query()
	{
		return $this->last_query;
	}

	public function set_additional_response($data)
	{
		return $this->additional_response = $data;
	}

	public function set_edit_type($data) {
		return $this->edit_type = $data;
	}

	public function render() {
		$ci =& get_instance();

		$btn_add_position = "pos-relative";
		$hide_search = "";
		if ($this->single_filter == true) {
			$btn_add_position = "pull-left";
			$hide_search = "f";
		}
		
		$limit_entries = "";
		if ($this->limit_entries) {
			$limit_entries = "l";
		}

		$table ='';
		$table .='
			<section class="section">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">';
						if (strlen($this->top_filter) > 0) {
		$table .= '			<div class="card-header">
								<button class="btn btn-primary btn-sm" id="toggleFilterBtn_'.$this->id.'">
									<i class="bi bi-funnel"></i> Show Filter
								</button>
							</div>
							<div id="filterForm" class="p-3 bg-light border-bottom filterForm-'.$this->id.'" style="display: none;">
								'.$this->top_filter.'
								<div class="col-12" style="padding : 20px 0px 10px 0px;">
									<button type="button" class="btn btn-primary me-2" id="applyFilterBtn_'.$this->id.'">Filter</button>';
									if (strlen($this->btn_reset) > 0) {
		$table .= '						<button type="button" class="btn btn-secondary" id="resetFilterBtn_'.$this->id.'">Reset Filter</button>';
									}
		$table .= '					'.$this->top_filter_btn.'
								</div>
							</div>';
						}
		$table .= '			<div class="card-body">';
		$table .= 				'<div class="'.$btn_add_position.' btn-top-table">';
									if ($this->btn_add) {
										$table .= '<button class="btn btn-outline-primary btn-add-'.$this->id.'" type="button"><i class="bi bi-plus"></i> '.azlang('Add').'</button>';
									}		
		$table .= '				</div>';
		$table .= '				<table id="myDataTable_'.$this->id.'" class="table table-striped table-hover">
									<thead>
										<tr role="row" class="heading">';
											$table_column = azarr_explode($this->column);
											$col_width = azarr_explode($this->width);
											$th_class = azarr_explode($this->th_class);

											$last_col = count($table_column) - 1;			
											if (count($col_width) == 0) {
												$col_width[0] = '10px';
												$col_width[$last_col] = '200px';
											}

											if (count($th_class) == 0) {
												$th_class[0] = 'no-sort';
												if($this->last_column_sorting == false) {
													$th_class[$last_col] = 'no-sort';
												}
											}

											$i = 0;
											foreach ($table_column as $value) {
												$column_width = '';
												if (isset($col_width[$i])) {
													$column_width = "width='".$col_width[$i]."'";
												}

												$column_class = '';
												if (isset($th_class[$i])) {
													$column_class = "class='".$th_class[$i]."'";
												}
												$i++;

		$table .= 								"<th ".$column_width." ".$column_class.">";
		$table .= 									$value;
		$table .= 								"</th>";
											}	
		$table .= '						</tr>
									</thead>
									<tbody>
										<tr>
											<td>agsdg</td>
											<td>agsdg</td>
											<td>agsdg</td>
											<td>agsdg</td>
											<td>agsdg</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		';
		if ($this->default_url) {
			// var_dump($this->default_url);die;
			if (strlen($this->url) == 0) {
				$this->url = "app_url+'".$this->id."/get'";
			}
			if (strlen($this->url_edit) == 0) {
				$this->url_edit = "app_url+'".$this->id."/edit'";
			}

			if (strlen($this->url_delete) == 0) {
				$this->url_delete = "app_url+'".$this->id."/delete'";
			}
			if (strlen($this->url_save) == 0) {
				$this->url_save = "app_url+'".$this->id."/save'";
			}
		}

		$js_table = '
			$(document).ready(function() {
				var table = $("#myDataTable_'.$this->id.'").DataTable({
					"pagingType": "full_numbers",
					"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
					"responsive": true,
					"processing": true,
					"serverSide": true,
					"dom": \'<"row"<"col-sm-6 col-sm-offset-6"'.$hide_search.'>> <"row"<"col-sm-12"tr>><"row"<"col-sm-6"'.$limit_entries.'><"col-sm-6"p>><"row"<"col-sm-12"i>>\',
					"ajax": {
						"url": '.$this->url.', 
						"type": "POST",
					},
				});

				// --- Logika Show/Hide Filter ---
				$("#toggleFilterBtn_'.$this->id.'").on("click", function() {
					$("#filterForm").slideToggle(function() {
						if ($(this).is(":visible")) {
							$("#toggleFilterBtn_'.$this->id.'").html(\'<i class="bi bi-funnel"></i>Hide Filter\');
						} else {
							$("#toggleFilterBtn_'.$this->id.'").html(\'<i class="bi bi-funnel"></i> Show Filter\');
						}
					});
				});

				$("#applyFilterBtn_'.$this->id.'").on("click", function() {
					var nama = $("#filterNama").val();
					var jabatan = $("#filterJabatan").val();
					var status = $("#filterStatus").val();

					table.search("").columns().search("").draw();

					if (nama) {
						table.column(1).search(nama).draw();
					}
					if (jabatan) {
						table.column(3).search(jabatan).draw();
					}

					if (status) {
						table.column(4).search(status).draw();
					}
				});

				$("#resetFilterBtn_'.$this->id.'").on("click", function() {
					$("#filterNama").val("");
					$("#filterJabatan").val("");
					$("#filterStatus").val("");
					table.search("").columns().search("").draw();
				});
			});
		';
			

		$ci->load->library('AZApp');
		$azapp = $ci->azapp;
		$azapp->add_js_ready($js_table);

		return $table;
	}

	public function get_table() {
		$records = array();
		$records["aaData"] = array();
		$records["sMessage"] = "";

		$select = $this->select;
		$select_union = $this->select_union; // select union
		$select_id = $this->select_id;
		$select_align = azarr_explode($this->select_align);
		$select_number = azarr_explode($this->select_number);
		$select_decimal = azarr_explode($this->select_decimal);
		$select_date = azarr_explode($this->select_date);
		$filter = $this->filter;
		$table = $this->table;
		$select_table = $this->select_table;
		$sorting = azarr_explode($this->sorting);
		$join  = $this->join;
		$join_manual = $this->join_manual;
		$column_show = $this->column_show;
		$cfilter = '';
		$top_filter = array();
		$_REQUEST = array_merge($this->ci->input->get(), $_REQUEST);
		if (isset($_REQUEST['cfilter'])) {
			$cfilter = $_REQUEST['cfilter'];
		}

		if (isset($_REQUEST['topfilter'])) {
			$top_filter = $_REQUEST['topfilter'];
		}

		// parse_str($_SERVER['QUERY_STRING'], $str);
		// $top_filter = $str['topfilter'];

		$where = $this->where;
		$order_by = azarr_explode($this->order_by);

		$column_show = array();

		if(strlen($select) > 0){
			$column_show = azarr_explode($select);
		}

		// jika menggunakan select_union
		if (strlen($select_union) > 0) {

			// ambil apa yang diselect di query pertamanya saja dan teks "SELECT".
			$column_show = str_replace("SELECT", "", $select);
			$column_show = explode(" ",$column_show);
			$column_show = str_replace(",", "", $column_show);

			$arr_arr_column_show = array();
			$loop = true;
			foreach ($column_show as $key => $value) {
				// ambil data yang ada nilainya dari query select saja
				if (strlen($value) > 0 && $loop == true) {

					// jika nilai mengandung kata "FROM", lalu kata "FROM" dihapus dari nilainya
					if(preg_match("/FROM/i", $value)) {
					  $loop = false;
					  $value = preg_replace("/FROM/i", "", $value);
					  $value = preg_replace('/\s+/', '', $value);
					}
					// jika nilai mengandung simbol `, maka dihilangkan
					$value = preg_replace("/`/i", "", $value);
					$arr_column_show[] = $value;
				}
			}

			$column_show = $arr_column_show;
			// ambil apa yang diselect di query kedua saja dan teks "SELECT".
			$column_show_union = str_replace("SELECT", "", $select_union);
			$column_show_union = explode(" ",$column_show_union);

			$arr_arr_column_show_union = array();
			$loop = true;
			foreach ($column_show_union as $key => $value) {
				// ambil data yang ada nilainya dari query select saja
				if (strlen($value) > 0 && $loop == true) {

					// jika nilai mengandung kata "FROM", lalu kata "FROM" dihapus dari nilainya
					if(preg_match("/FROM/i", $value)) {
					  $loop = false;
					  $value = preg_replace("/FROM/i", "", $value);
					  $value = preg_replace('/\s+/', '', $value);
					  $value = preg_replace("/`/i", "", $value);
					}
					// jika nilai mengandung simbol `, maka dihilangkan
					$value = preg_replace("/`/i", "", $value);
					$arr_column_show_union[] = $value;
				}
			}
			$column_show_union = $arr_column_show_union;
		}

		if(strlen($select_table) > 0){
			$column_show = azarr_explode($select_table);
		}

		$iTotalRecords = 0;
		
		$data_filter = ''; //filter untuk select union
		if($filter != ''){
			if (strlen(azarr($_REQUEST, 'sSearch')) > 0) {
				$arr_filter = explode(',', $filter);
				foreach ($arr_filter as $key => $value) {
					$value = trim($value);
					if ($key == 0) {
						$this->ci->db->group_start();
						$this->ci->db->like($value, $_REQUEST["sSearch"]);

						$data_filter = " (".$value." LIKE '%".$_REQUEST["sSearch"]."%' ESCAPE '!'";
					}
					else {
						$this->ci->db->or_like($value, $_REQUEST["sSearch"]);

						$data_filter .= " OR ".$value." LIKE '%".$_REQUEST["sSearch"]."%' ESCAPE '!'";
					}
					if (($key + 1) == count($arr_filter)) {
						$this->ci->db->group_end();

						$data_filter .= ")";
					}
				}
			}
		}

		if(count($where) > 0){
			foreach($where as $pw_k => $pw_v){
				$this->ci->db->where($pw_v);
			}
		}

		if (count($top_filter) > 0) {
			foreach ($top_filter as $key => $value) {
				$key = $this->ci->encrypt->decode($key);
				$check = explode("~az~", $value);
				$check_tpwh = explode("~aztpwh~", $value);
				if (count($check) > 1) {
					$top_filter1 = azarr($check, "0");
					$top_filter2 = azarr($check, "1");
					$check_date = explode("-", $top_filter1);
					if (count($check_date) > 1) {
						$top_filter1 = Date("Y-m-d H:i:s", strtotime($top_filter1." 00:00:00"));
						$top_filter2 = Date("Y-m-d H:i:s", strtotime($top_filter2." 23:59:59"));
					}
					$this->ci->db->where("(".$key." BETWEEN '".$top_filter1."' AND '".$top_filter2."')");
				}
				else if (count($check_tpwh) > 1) {
					$tpwh_val = azarr($check_tpwh, "1");
					if (strlen($tpwh_val) > 0) {
						$this->ci->db->where($key, $tpwh_val);
					}
				}
				else {
					if (strlen($value) > 0) {
						$is_id = '.id';
						if (strpos($key, $is_id) !== false) {
							$this->ci->db->where($key, $value);
						} else {
							$this->ci->db->like($key, $value);
						}
					}
				}
			}
		}


		if (count($join) > 0) {
			foreach ($join as $key => $value) {
				$data_join = azarr($value, 'join');
				$data_type = azarr($value, 'type');
				$data_other = azarr($value, 'other');
				$data_join_x = azarr($value, 'join_x');
				$data_join_y = azarr($value, 'join_y');

				$join_target = $table;
				if (strlen($data_other) > 0) {
					$join_target = $data_other;
				}

				$data_join_col = "id".$data_join;
				if (strlen($data_join_x) > 0) {
					$data_join_col = $data_join_x;
				}

				if (strlen($data_type) > 0) {
					$this->ci->db->join($data_join, $data_join.".".$data_join_col." = ".$join_target.".".$data_join_col, $data_type);
				}
				else {
					$this->ci->db->join($data_join, $data_join.".".$data_join_col." = ".$join_target.".".$data_join_col);
				}
			}
		}

		if (count($join_manual) > 0) {
			foreach ($join_manual as $key => $value) {
				$jm_join = azarr($value, 'join');
				$jm_on = azarr($value, 'on');
				$jm_type = azarr($value, 'type');
				$this->ci->db->join($jm_join, $jm_on, $jm_type);
			}
		}

		if($cfilter != ''){
			foreach($cfilter as $pcf_k => $pcf_v){
				$pcf_k = $this->ci->encrypt->decode($pcf_k);
				if(strlen($pcf_v) > 0){
					$this->ci->db->like($pcf_k, $pcf_v);
				}
			}
		}

		if(strlen($this->group_by) > 0){
			$this->ci->db->group_by($this->group_by);
		}  
		
		if(count($this->having) > 0){
			foreach($this->having as $hv){
				$this->ci->db->having($hv);
			}
		}  

		if (strlen($select_union) > 0) {
			$link = '';
			// cek apakah ada filter search
			if ($data_filter != '') {
				if(preg_match("/WHERE/i", $select.' UNION '.$select_union)) {
		            $link = ' AND ';
		        }
		        else {
		        	$link = ' WHERE ';
		        }
			}
			// $query_union = $this->ci->db->query($select.' UNION '.$select_union.$link.$data_filter);
			$query_union = $this->ci->db->query('select * from ('.$select.' UNION '.$select_union.') as new_query '.$link.$data_filter);
			$last_query_union = $this->ci->db->last_query();
			$iTotalRecords = $query_union->num_rows();
		}

		if(strlen($this->manual_query) > 0) {
			// var_dump($this->manual_query);
			$manuq = $this->manual_query;

			if(strlen($this->group_by) > 0){
				$manuq = $manuq.' GROUP BY '.$this->group_by;
			}

			// Add manual HAVING clause after GROUP BY
			if(count($this->having) > 0){
				$manuq .= ' HAVING ' . implode(' AND ', $this->having);
			}

			$iTotalRecords = $this->ci->db->query($manuq)->num_rows();
		}

		// jika tidak menggunakan select_union
		if (strlen($select_union) == 0 && strlen($this->manual_query) == 0) {
			$this->ci->db->select($select);
			$iTotalRecords = $this->ci->db->get($table)->num_rows();
		}
		// var_dump($iTotalRecords);

		$iTotalDisplayRecords = $iTotalRecords;

		$iDisplayLength = intval(azarr($_REQUEST, 'length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval(azarr($_REQUEST, 'start'));
		$draw = intval($_REQUEST['draw']);

		$this->ci->db->limit($iDisplayLength);
		$this->ci->db->offset($iDisplayStart);

		if($filter != ''){
			if (strlen(azarr($_REQUEST, 'sSearch')) > 0) {
				$arr_filter = explode(',', $filter);
				foreach ($arr_filter as $key => $value) {
					$value = trim($value);
					if ($key == 0) {
						$this->ci->db->group_start();
						$this->ci->db->like($value, $_REQUEST["sSearch"]);
					}
					else {
						$this->ci->db->or_like($value, $_REQUEST["sSearch"]);
					}
					if (($key + 1) == count($arr_filter)) {
						$this->ci->db->group_end();
					}
				}
			}
		}
		
		$data_order_by = ''; // order by select_union
		$iSortCol_0 = azarr($_REQUEST, "iSortCol_0");
		foreach($sorting as $ps_k => $ps_v){
	        if($iSortCol_0 == ($ps_k + 1)) {          
	            $this->ci->db->order_by($ps_v, $_REQUEST["sSortDir_0"]);
	            $data_order_by = ' ORDER BY '.$ps_v.' '.$_REQUEST["sSortDir_0"];
	        }
		}

		if(count($where) > 0){
			foreach($where as $pw_k => $pw_v){
				$this->ci->db->where($pw_v);
			}
		}       

		// $select = implode(", ", $select);
		if (strlen($select_union) == 0) {
			$this->ci->db->select(array($select), false);
		}

		if (count($join) > 0) {
			foreach ($join as $key => $value) {
				$data_join = azarr($value, 'join');
				$data_type = azarr($value, 'type');
				$data_other = azarr($value, 'other');
				$data_join_x = azarr($value, 'join_x');

				$join_target = $table;
				if (strlen($data_other) > 0) {
					$join_target = $data_other;
				}

				$data_join_col = "id".$data_join;
				if (strlen($data_join_x) > 0) {
					$data_join_col = $data_join_x;
				}

				if (strlen($data_type) > 0) {
					$this->ci->db->join($data_join, $data_join.".".$data_join_col." = ".$join_target.".".$data_join_col, $data_type);
				}
				else {
					$this->ci->db->join($data_join, $data_join.".".$data_join_col." = ".$join_target.".".$data_join_col);
				}
			}
		}


		if (count($join_manual) > 0) {
			foreach ($join_manual as $key => $value) {
				$jm_join = azarr($value, 'join');
				$jm_on = azarr($value, 'on');
				$jm_type = azarr($value, 'type');
				$this->ci->db->join($jm_join, $jm_on, $jm_type);
			}
		}

		if($cfilter != ''){
			foreach($cfilter as $pcf_k => $pcf_v){
				$pcf_k = $this->ci->encrypt->decode($pcf_k);
				if(strlen($pcf_v) > 0){
					$this->ci->db->like($pcf_k, $pcf_v);
				}
			}
		}	

		if (count($top_filter) > 0) {
			foreach ($top_filter as $key => $value) {
				$key = $this->ci->encrypt->decode($key);
				$check = explode("~az~", $value);
				$check_tpwh = explode("~aztpwh~", $value);
				if (count($check) > 1) {
					$top_filter1 = azarr($check, "0");
					$top_filter2 = azarr($check, "1");
					$check_date = explode("-", $top_filter1);
					if (count($check_date) > 1) {
						$top_filter1 = Date("Y-m-d H:i:s", strtotime($top_filter1." 00:00:00"));
						$top_filter2 = Date("Y-m-d H:i:s", strtotime($top_filter2." 23:59:59"));
					}
					$this->ci->db->where("(".$key." BETWEEN '".$top_filter1."' AND '".$top_filter2."')");
				}
				else if (count($check_tpwh) > 1) {
					$tpwh_val = azarr($check_tpwh, "1");
					if (strlen($tpwh_val) > 0) {
						$this->ci->db->where($key, $tpwh_val);
					}
				}
				else {
					if (strlen($value) > 0) {
						$is_id = '.id';
						if (strpos($key, $is_id) !== false) {
							$this->ci->db->where($key, $value);
						} else {
							$this->ci->db->like($key, $value);
						}
					}
				}
			}
		}

		foreach($order_by as $po_k => $po_v){
			$this->ci->db->order_by($po_v);
		}

		if(strlen($this->group_by) > 0){
			$this->ci->db->group_by($this->group_by);
		}  
		
		if(count($this->having) > 0){
			foreach($this->having as $hv){
				$this->ci->db->having($hv);
			}
		}  

		if(strlen($select_union) > 0) {
			$limit = '';
			if (strlen($iDisplayLength) > 0) {
				$limit = 'LIMIT '.$iDisplayLength;

				$offset = '';
				if (strlen($iDisplayStart) > 0) {
					$offset = 'OFFSET '.$iDisplayStart;
				}
			}
			
			$query_union = $this->ci->db->query($last_query_union.' '.$data_order_by.' '.$limit.' '.$offset);
			$ambil = $query_union;

			$idtable = $select_id;
		}

		if(strlen($this->manual_query) > 0) {
			$this->ci->db->reset_query();
			// echo $this->manual_query;die;

			// manual order by
			$manual_po = '';
			if(count($order_by) > 0) {
				$m_po = '';
				foreach($order_by as $po_k => $po_v){
					if($po_k == 0) {
						$m_po .= $po_v;
					} else {
						$m_po .= ', '.$po_v;
					}
				}

				$manual_po = ' ORDER BY '.$m_po;
			}

			// manual group by
			$manual_group = '';
			if(strlen($this->group_by) > 0){
				$manual_group = ' GROUP BY '.$this->group_by;
			}

			// manual having
			$manual_having = '';
			if(count($this->having) > 0){
				$manual_having = ' HAVING ' . implode(' AND ', $this->having);
			}

			// manual filter
			$manual_filter = '';
			if(strlen($data_filter) > 0) {
				$manual_filter = ' WHERE '.$data_filter;
			}

			$manual_query = $this->manual_query.$manual_filter.$manual_group.$manual_having.$manual_po.' LIMIT '.$iDisplayStart.', '.$iDisplayLength;
			// echo $manual_query;die;
			$ambil = $this->ci->db->query($manual_query);

			if(strlen($data_filter) > 0) {
				$iTotalDisplayRecords = $ambil->num_rows();
			}
		}

		if(strlen($select_union) == 0 && strlen($this->manual_query) == 0) {
			$ambil = $this->ci->db->get($table);
		}

		$idtable = 'id'.$table;
		if (strlen($this->idtable) > 0) {
			$idtable = $this->idtable;
		}


		$current_last_query = $this->ci->db->last_query();
		$current_last_query = str_replace(" LIMIT ".$iDisplayStart.', '.$iDisplayLength,'',$current_last_query);
		$current_last_query = str_replace(" LIMIT ".$iDisplayLength,'',$current_last_query);
		$this->last_query = $current_last_query;

		// echo"<pre>";print_r($this->ci->db->last_query());die;
		$arr_column_show = array();
		foreach($column_show as $ps_value){
			$xvalue = explode(".", $ps_value);
			if(count($xvalue) > 1){
				$ps_value = $xvalue[1];
			}
			if($ps_value != $idtable){
				$arr_column_show[] = $ps_value;
			}
		}
		$i = 0;
		foreach ($ambil->result_array() as $value) {
			$i++;
			$no = $iDisplayStart + $i;

			$arr_get = array("no" => $no);
			if ($this->custom_first_column) {
				$arr_get = array();
			}
			foreach ($arr_column_show as $acs_value) {
				// $arr_get[$acs_value] = $value[$acs_value];
				$arr_get[$acs_value] = azarr($value, $acs_value);
			}

			$btn_ = "";
			if ($this->edit) {
				$btn_ .= '<button class="btn btn-outline-warning btn-sm btn-edit-'.$this->id.'" data_id= "'.$value[$idtable].'"><i class="bi bi-pencil-square"></i> '.azlang('Edit').'</button>';
			}
			if ($this->delete) {
				$btn_ .= '<button class="btn btn-outline-danger btn-sm btn-delete-'.$this->id.'" data_id= "'.$value[$idtable].'"><i class="bi bi-trash"></i> '.azlang('Delete').'</button>';
			}

			if (strlen($this->custom_btn) > 0) {
				$custom_button = $this->custom_btn;
				$btn_ .= $this->ci->$custom_button($value);
			}

			$arr_get["action"] = $btn_;
			$arr_get_ok = array();
			$numb = -1;
			foreach ($arr_get as $acs_key => $acs_value) {
				$get_ok = $acs_value;

				// if ($acs_key != "action") {
				// 	$get_ok = htmlspecialchars($get_ok);	
				// }

				//ALIGN
				$palign = "";
				if ($acs_key == "no" || $acs_key == "action") {
					$palign = " class='txt-center' style=' display: flex;justify-content: center; align-items: center; gap: 5px;'";
				}
				if (count($select_align) > 0) {
					$palign_x = azarr($select_align, $numb, '');
					if (strlen($palign_x) > 0) {
						$palign = " class='txt-".$palign_x."'";
					}
				}

				//NUMBER SEPARATOR THOUSAND
				if (count($select_number) > 0) {
					if (in_array($numb, $select_number)) {
						if (is_numeric($acs_value)) {
							$get_ok = number_format($acs_value, 0, '', '.');
						}
					}
				}

				//NUMBER SEPARATOR THOUSAND
				if (count($select_decimal) > 0) {
					if (in_array($numb, $select_decimal)) {
						if (is_numeric($acs_value)) {
							$get_ok = number_format($acs_value, 2, ',', '.');
						}
					}
				}

				//FORMAT DATE
				if (count($select_date) > 0) {
					if (in_array($numb, $select_date)) {
						$get_ok = Date('d-m-Y', strtotime($acs_value));
					}
				}

				//CUSTOM STYLE
				if (strlen($this->custom_style) > 0) {
					$style_column = $this->custom_style;
					$get_ok = $this->ci->$style_column($acs_key, $get_ok, $value);
				}

				$arr_get_ok[] = "<div".$palign.">".$get_ok."</div>";
				$numb++;
			}

			$records["aaData"][] = $arr_get_ok;
		}
		$records["draw"] = $draw;
		$records["iTotalRecords"] = $iTotalRecords;
		$records["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		if($this->additional_response != null){
			$records["additional_response"] = $this->additional_response;
		}

		return json_encode($records);
	}

	public function generate_modal() {
		$modal = '<div class="modal fade az-modal az-modal-'.$this->id.'" data-width="800">
				    <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				            <div class="modal-header">
				                <div class="az-modal-close" data-dismiss="modal" aria-hidden="true">
				                	<div class="caret-close"></div>
				                	<div class="modal-btn-close">
				                		<button type="button" class="close">X</button>
				                	</div>
				                </div>
				                <h4 class="modal-title"><span>'.azlang('Add').'</span>&nbsp;'.$this->modal_title.'</h4>

				            </div>
				            <div class="modal-body">';
		$modal .= $this->modal;
		$modal .= '    		</div>
				            <div class="modal-footer">
				                <div class="pull-right">';

        if ($this->btn_left_modal) {
        	foreach ($this->btn_left_modal as $key => $value) {
				$modal .='	      <button class="btn btn-primary az-btn-primary btn-'.$key.'" type="button">'.$value.'</button>';
        	}
        }

        if ($this->btn_save_modal) {
			$modal .='	          <button class="btn btn-primary az-btn-primary btn-save-'.$this->id.'" type="button">'.azlang('Save').'</button>';
        }

        if ($this->btn_right_modal) {
        	foreach ($this->btn_right_modal as $key => $value) {
				$modal .='	      <button class="btn btn-primary az-btn-primary btn-'.$key.'" type="button">'.$value.'</button>';
        	}
        }


		$modal .= '
				                </div>
				            </div>
				        </div>
				    </div>
				</div>';
		return $modal;
	}

}