<?php
/**
 * AZApp
 * @author	M. Isman Subakti
 * @copyright	12-04-2016
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("AZ.php");

class CI_AZSelect2 extends CI_AZ{
	protected $ci;
	protected $placeholder = "";
	protected $input_length = 0;
	protected $url = "";
	protected $delay = 250;
	protected $select_parent = "";
	protected $original_id = "";
	protected $custom_post = array();
	protected $param_data = array();
	protected $default_value = array();
	protected $is_js_only = false;
	protected $is_disabled = false;

	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->helper("array");
	}

	public function set_placeholder($data) {
		return $this->placeholder = $data;
	}

	public function set_disabled($disabled = true) {
		$this->is_disabled = $disabled;
	}

	public function set_input_length($data) {
		return $this->input_length = $data;
	}

	public function set_url($data) {
		return $this->url = $data;
	}

	public function set_delay($data) {
		return $this->delay = $data;
	}

	public function set_select_parent($data) {
		return $this->select_parent = $data;
	}

	public function set_original_id($data) {
		return $this->original_id = $data;
	}

	public function add_custom_post($key, $value) {
		return $this->custom_post[$key] = $value;
	}

	public function add_param_data($key, $value) {
		return $this->param_data[$key] = $value;
	}

	function set_default_value($data) {
		return $this->default_value = $data;
	}

	public function get_js_only($data){
		return $this->is_js_only = $data;
	}

	public function render() {
		$data_attr = "";
		foreach ($this->attr as $key => $value) {
			$data_attr .= " ".$key."='".$value."'";
		}
		if ($this->is_disabled) {
			$data_attr .= " disabled";
		}

		if (strlen($this->original_id) > 0) {
			$name = $this->original_id;
			if (strlen($this->name) > 0) {
				$name = $this->name;
			}
			$data = '
				<select id="'.$this->original_id.'" name="'.$name.'"'.$data_attr.' class="form-select select select2-ajax'.$this->class.'">';	
		}
		else {
			$name = "id".$this->id;
			if (strlen($this->name) > 0) {
				$name = $this->name;
			}
			$data = '
				<select id="id'.$this->id.'" name="'.$name.'"'.$data_attr.' class="form-select select select2-ajax'.$this->class.'">';
		}

		if(sizeof($this->default_value) > 0){
			$data .= '<option value="'.azarr($this->default_value,'id').'">'.azarr($this->default_value,'label').'</option>';
		}

		$data .='
			</select>
		';

		$js_ready = '';
		
		if (strlen($this->original_id) > 0) {
			$js_ready .= 'jQuery("#'.$this->original_id.'").select2({';
		}
		else {
			$js_ready .= 'jQuery("#id'.$this->id.'").select2({';
		}

		$js_ready .= '
			            placeholder: "~ '.$this->placeholder.' ~",
			            allowClear: true,
			            minimumInputLength: '.$this->input_length.',
			            ajax: { 
			                url: "'.app_url().$this->url.'",
			                dataType: "json",
			                delay: '.$this->delay.',
			                data: function(params) {
			                  return {
			                      term: params.term,
			                      page: params.page || 1,
			                      parent: jQuery("#'.$this->select_parent.'").val(),';
		foreach ($this->custom_post as $key => $value) {
			$js_ready .= 			  $key.': jQuery("#'.$value.'").val(),';
		}

		foreach ($this->param_data as $key => $value) {
			$js_ready .= 			  $key.': "'.$value.'",';
		}

		$js_ready .= '	                      
			                  }
			                },
			                cache: true
			            }
			        });';
		$js = '';
		$id_new = 'id'.$this->id;
		if (strlen($this->original_id) > 0) {
			$id_new = $this->original_id;
		}
		if (count($this->list) > 0) {
			foreach ($this->list as $key => $value) {
				$js .= 'jQuery("#'.$id_new.'").append(new Option("'.$value.'", "'.$key.'", true, true)).trigger("change");';
			}
		}

		if (strlen($this->select_parent) > 0) {
			$js .= '
			jQuery("body").on("change", "#'.$this->select_parent.'", function() {
				jQuery("#'.$id_new.'").val("").trigger("change");
			});';
		}

		if($this->is_js_only){
			return $js_ready;
		}

		$ci =& get_instance();
		$ci->load->library('AZApp');
		$azapp = $ci->azapp;
		$azapp->add_js_ready($js_ready);
		$azapp->add_js($js);

		return $data;
	}

}