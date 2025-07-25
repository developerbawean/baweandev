<?php
/**
 * AZApp
 * @author	M. Isman Subakti
 * @copyright	06-04-2016
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("AZ.php");

class CI_AZFile extends CI_AZ {
	protected $ci;
	protected $file_size = '500 KB';
	protected $file_accept = 'image/*';
	protected $page_id = '';
	protected $file_dir = 'upload';
	protected $file_type = 'Image';

	protected $max_size = '500';
	protected $allowed_type = 'jpg|jpeg|png';

	protected $path = '';
	protected $title = '';
	protected $alt = '';
	protected $show_buttons = true;

	public function __construct() {
		$this->ci =& get_instance();
	}

	public function set_title($data) {
		return $this->title = $data;
	}
	public function set_alt($data) {
		return $this->alt = $data;
	}
	public function set_file_size($data) {
		return $this->file_size = $data;
	}
	public function set_file_accept($data) {
		return $this->file_accept = $data;
	}
	public function set_page_id($data) {
		return $this->page_id = $data;
	}
	public function set_file_dir($data) {
		return $this->file_dir = $data;
	}
	public function set_file_type($data) {
		return $this->file_type = $data;
	}
	public function set_max_size($data) {
		return $this->max_size = $data;
	}
	public function set_allowed_type($data) {
		return $this->allowed_type = $data;
	}
	public function set_path($data) {
		return $this->path = $data;
	}

	public function show_buttons($bool = true) {
		$this->show_buttons = $bool;
		return $this;
	}

	public function render() {
		$html = '<img id="'.$this->id.'" src="'.$this->path.$this->file_dir.'" alt="'.$this->alt.'" class="rounded-circle" width="100">';		
		// var_dump($this->show_buttons);die;
		if ($this->show_buttons) {
			$html .= '<div class="pt-2">';
			$html .= '<a href="'.$this->path.'" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a> ';
			$html .= '<a href="'.$this->path.'" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>';
			$html .= '</div>';
		}
		return $html;
	}

	// public function render() {
	// 	if (strlen($this->name) == 0) {
	// 		$this->name = $this->id;
	// 	}
	// 	if (strlen($this->path) == 0) {
	// 		$this->path = base_url().AZAPP.'assets';
	// 	}
	// 	$data_attr = "";
	// 	foreach ($this->attr as $key => $value) {
	// 		$data_attr .= " ".$key."='".$value."'";
	// 	}

	// 	$data = '
	// 		<div class="container-choose-file '.$this->id.'">
	// 			<div class="container-new-file">
	// 				<button class="btn btn-primary az-btn-primary btn-choose-file" type="button"><i class="fa fa-arrow-up"></i> '.azlang('Choose '.$this->file_type.' File').'</button>
	// 				<div class="txt-info-file">'.azlang('Maximal file size').' '.$this->file_size.'</div>
	// 				<div class="choose-file-wrap"></div>
	// 				<input type="file" id="'.$this->id.'" name="'.$this->name.'" accept="'.$this->file_accept.'" class="az-file-upload" '.$data_attr.'/>
	// 				<div class="az-selected-file">

	// 				</div>
	// 				<input type="hidden" name="is_delete_'.$this->id.'" id="is_delete_'.$this->id.'"/>
	// 			</div>
	// 			<div class="image-file-view">
	// 				<img class="az-image-file-view-'.$this->id.'"/>
	// 			</div>
	// 			<div class="container-found-file">';
			
	// 	if (strtolower($this->file_type) == 'image') {
	// 		$data .= '
	// 				<div class="image-file">
	// 					<img class="az-image-file-'.$this->id.'" title="'.$this->title.'" alt="'.$this->alt.'"/>
	// 				</div>
	// 			'
	// 		;			
	// 	}


	// 	$data .= '
	// 				<a class="btn-download-file-'.$this->id.'" target="_blank"><button type="button" class="btn-primary az-btn-primary btn-xs btn">'.azlang('Download File').'</button></a>
	// 				<button type="button" class="btn-danger btn-xs btn btn-delete-'.$this->id.'">'.azlang('Delete File').'</button>
	// 			</div>
	// 		</div>'
	// 	;

	// 	//js	
	// 	$data_js = "
	// 		jQuery('.az-file-upload').on('change', function() {
	// 			var file_uploaded = jQuery(this).val().split('\\\\').pop();
	// 			jQuery(this).parents('.container-choose-file').find('.az-selected-file').text(file_uploaded);
	// 		});

	// 		jQuery(document).on('show.bs.modal', '.modal', function () {
	// 			jQuery('.az-selected-file').text('');
	// 			jQuery('.image-file-view').hide();
	// 		});

	// 		jQuery('.btn-add-".$this->page_id."').click(function() {
	// 			jQuery('.container-found-file').hide();
	// 			jQuery('.container-new-file').show();
	// 			jQuery('.image-file-view img').attr('src', '');
	// 		});

	// 		jQuery('.btn-delete-".$this->id."').click(function() {
	// 			jQuery('.container-choose-file.".$this->id." .container-found-file').hide();
	// 			jQuery('.container-choose-file.".$this->id." .container-new-file').show();
	// 			jQuery('#is_delete_".$this->id."').val('1');
	// 		});


	// 		// function callback_".$this->id."(response) {
	// 		// 	var res_".$this->id." = response[0].".$this->id.";

	// 		// 	if (res_".$this->id." != null) {
	// 		// 		jQuery('.container-choose-file.".$this->id." .container-found-file').show();
	// 		// 		jQuery('.container-choose-file.".$this->id." .container-new-file').hide();
	// 		// 		var href_file = '".$this->path.'/'.$this->file_dir."/'+res_".$this->id.";
	// 		// 		jQuery('.btn-download-file-".$this->id."').attr('href', href_file);
	// 		// 		jQuery('.az-image-file-".$this->id."').attr('src', href_file);
	// 		// 	}
	// 		// 	else {
	// 		// 		jQuery('.container-choose-file.".$this->id." .container-found-file').hide();
	// 		// 		jQuery('.container-choose-file.".$this->id." .container-new-file').show();
	// 		// 	}
	// 		// }

	// 		function callback_".$this->id."(response) {
	// 			var res_".$this->id." = response[0].".$this->id.";
	// 			var res_gcs_".$this->id." = response[0].gcs_".$this->id." || null;
	// 			var res_gcs_url_".$this->id." = response[0].gcs_url_".$this->id." || null;

	// 			if (res_".$this->id." != null) {
	// 				jQuery('.container-choose-file.".$this->id." .container-found-file').show();
	// 				jQuery('.container-choose-file.".$this->id." .container-new-file').hide();
	// 				if(res_gcs_".$this->id." != null){
	// 					var href_file = res_gcs_".$this->id.";
	// 				}else{
	// 					var href_file = '".$this->path.'/'.$this->file_dir."/'+res_".$this->id.";
	// 				}
	// 				if(res_gcs_url_".$this->id." != null){
	// 					jQuery('.btn-download-file-".$this->id."').attr('href', res_gcs_url_".$this->id.");
	// 				}else{
	// 					jQuery('.btn-download-file-".$this->id."').attr('href', href_file);
	// 				}
	// 				jQuery('.az-image-file-".$this->id."').attr('src', href_file);
	// 			}
	// 			else {
	// 				jQuery('.container-choose-file.".$this->id." .container-found-file').hide();
	// 				jQuery('.container-choose-file.".$this->id." .container-new-file').show();
	// 			}
	// 		}
	// 	";


	// 	if (strtolower($this->file_type) == 'image') {
	// 		$data_js .= "
	// 			function readURL_".$this->id."(input) {
	// 			    if (input.files && input.files[0]) {
	// 			        var reader = new FileReader();

	// 			        reader.onload = function (e) {
	// 			        	jQuery('.image-file-view').show();
	// 			            jQuery('.az-image-file-view-".$this->id."').attr('src', e.target.result);
	// 			            jQuery('.container-found-file').parent('.image-file-view').show();
	// 			        };

	// 			        reader.readAsDataURL(input.files[0]);
	// 			    }
	// 			}

	// 			jQuery('body').on('change', '#".$this->id."', function(){
	// 			    readURL_".$this->id."(this);
	// 			});
	// 		";
	// 	}

	// 	$ci =& get_instance();
	// 	$ci->load->library('AZApp');
	// 	$azapp = $ci->azapp;
	// 	$azapp->add_js_ready($data_js);

	//     return $data;
	// }


	// function save($insert_id, $idtable, $table, $idpost, $path = '', $filename = '', $encrypt = true, $column_name = '') {
	// 	$ci =& get_instance();
	// 	$err_code = 0;
	// 	$err_message = '';
	// 	$data = array();
	// 	if (strlen($path) == 0) {
	// 		$path = APPPATH.'assets/'.$this->file_dir;
	// 	}

	// 	if (!file_exists($path)) {
	// 	    mkdir($path, 0777, true);
	// 	}

	// 	$is_delete = $ci->input->post('is_delete_'.$this->id);
	// 	if ($is_delete == '1') {
	// 		$ci->db->where($idtable, $insert_id);
	// 		$check = $ci->db->get($table);

	// 		$column_path = $this->id;
	// 		if (strlen($column_name) > 0) {
	// 			$column_path = $column_name;
	// 		}
	// 		if ($check->num_rows() > 0) {
	// 			// $column_path = $this->id;
	// 			$filepath = $check->row()->$column_path;
	// 			@unlink($path.'/'.$filepath);
	// 		}

	// 		$ci->db->where($idtable, $insert_id);
	// 		$ci->db->update($table, array($column_path => NULL));
	// 	}
	// 	if(isset($_FILES[$this->id]['tmp_name'])){
	// 		$config['overwrite'] = false;
	// 		$config['max_size']	= $this->max_size;
	// 		$config['encrypt_name'] = $encrypt;
	// 		$ci->load->library('upload', $config);

	// 		$config['upload_path'] = $path.'/';
	// 		$config['allowed_types'] = $this->allowed_type;

	// 		$new_name = time().$insert_id.'-'.$_FILES[$this->id]['name'];
	// 		$config['file_name'] = $new_name;
	// 		if (strlen($filename) > 0) {
	// 			$config['file_name'] = $filename;
	// 		}
	// 		$ci->upload->initialize($config);
	// 		if (!$ci->upload->do_upload($this->id)){
	// 			$err_code++;
	// 			$err_message = $ci->upload->display_errors();
	// 		}
	// 		else {
	// 			$col_update = $this->id;
	// 			if (strlen($column_name) > 0) {
	// 				$col_update = $column_name;
	// 			}

	// 			$data = array('upload_data' => $ci->upload->data());
	// 			$data_update[$col_update] = azarr($ci->upload->data(), 'file_name');
	// 			// if (strlen($filename) > 0) {
	// 			// 	$xformat = $_FILES[$this->id]['name'];
	// 			// 	$ext = pathinfo($xformat, PATHINFO_EXTENSION);

	// 			// 	$data_update[$this->id] = $filename.'.'.$ext;
	// 			// }
	// 			$ci->db->where($idtable, $insert_id);
	// 			$ci->db->update($table, $data_update);
	// 		}
			
	// 		if ($err_code > 0) {
	// 			if (strlen($idpost) == 0) {
	// 				$ci->db->where($idtable, $insert_id);
	// 				$ci->db->delete($table);
	// 			}
	// 		}
	// 	}
		

	// 	$return = array(
	// 		'err_code' => $err_code,
	// 		'err_message' => $err_message,
	// 		'data' => $data
	// 	);

	// 	return $return;
	// }

	// function save_compress($insert_id, $idtable, $table, $idpost, $path = '', $filename = '', $encrypt = true, $column_name = '') {
	// 	$ci =& get_instance();
	// 	$err_code = 0;
	// 	$err_message = '';
	// 	$data = array();
	// 	if (strlen($path) == 0) {
	// 		$path = APPPATH.'assets/'.$this->file_dir;
	// 	}

	// 	if (!file_exists($path)) {
	// 	    mkdir($path, 0777, true);
	// 	}

	// 	$is_delete = $ci->input->post('is_delete_'.$this->id);
	// 	if ($is_delete == '1') {
	// 		$ci->db->where($idtable, $insert_id);
	// 		$check = $ci->db->get($table);

	// 		$column_path = $this->id;
	// 		if (strlen($column_name) > 0) {
	// 			$column_path = $column_name;
	// 		}
	// 		if ($check->num_rows() > 0) {
	// 			// $column_path = $this->id;
	// 			$filepath = $check->row()->$column_path;
	// 			@unlink($path.'/'.$filepath);
	// 		}

	// 		$ci->db->where($idtable, $insert_id);
	// 		$ci->db->update($table, array($column_path => NULL));
	// 	}
	// 	if(isset($_FILES[$this->id]['tmp_name'])){
	// 		$config['overwrite'] = false;
	// 		$config['max_size']	= $this->max_size;
	// 		$config['encrypt_name'] = $encrypt;
	// 		$ci->load->library('upload', $config);

	// 		$config['upload_path'] = $path.'/';
	// 		$config['allowed_types'] = $this->allowed_type;

	// 		$new_name = time().$insert_id.'-'.$_FILES[$this->id]['name'];
	// 		$config['file_name'] = $new_name;
	// 		if (strlen($filename) > 0) {
	// 			$config['file_name'] = $filename;
	// 		}
	// 		$ci->upload->initialize($config);
	// 		if (!$ci->upload->do_upload($this->id)){
	// 			$err_code++;
	// 			$err_message = $ci->upload->display_errors();
	// 		}
	// 		else {
	// 			$col_update = $this->id;
	// 			if (strlen($column_name) > 0) {
	// 				$col_update = $column_name;
	// 			}

	// 			  // Ambil data file yang diupload
	// 			  $data = $ci->upload->data();
	// 			  $file_path = $data['full_path']; // Lokasi file yang diupload
		  
	// 			  // Konfigurasi image manipulation untuk kompres gambar
	// 			  $config_image['image_library'] = 'gd2';
	// 			  $config_image['source_image']  = $file_path; // Lokasi file gambar yang diupload
	// 			  $config_image['create_thumb'] = FALSE;  // Tidak membuat thumbnail
	// 			  $config_image['maintain_ratio'] = TRUE;  // Mempertahankan rasio gambar
	// 			  $config_image['width']         = 800;    // Tentukan lebar gambar setelah kompres
	// 			  $config_image['height']        = 600;    // Tentukan tinggi gambar setelah kompres
	// 			  $config_image['quality']       = '75%';   // Tentukan kualitas gambar setelah kompres
	// 			  $ci->load->library('image_lib', $config_image);
		  
	// 			  // Coba kompres gambar
	// 			  if (!$ci->image_lib->resize()) {
	// 				$err_code++;
	// 				$err_message = $ci->image_lib->display_errors();  
	// 			  }

	// 			$data = array('upload_data' => $ci->upload->data());
	// 			$data_update[$col_update] = azarr($ci->upload->data(), 'file_name');
	// 			// if (strlen($filename) > 0) {
	// 			// 	$xformat = $_FILES[$this->id]['name'];
	// 			// 	$ext = pathinfo($xformat, PATHINFO_EXTENSION);

	// 			// 	$data_update[$this->id] = $filename.'.'.$ext;
	// 			// }
	// 			$ci->db->where($idtable, $insert_id);
	// 			$ci->db->update($table, $data_update);
	// 		}
			
	// 		if ($err_code > 0) {
	// 			if (strlen($idpost) == 0) {
	// 				$ci->db->where($idtable, $insert_id);
	// 				$ci->db->delete($table);
	// 			}
	// 		}
	// 	}
		

	// 	$return = array(
	// 		'err_code' => $err_code,
	// 		'err_message' => $err_message,
	// 		'data' => $data
	// 	);

	// 	return $return;
	// }

}