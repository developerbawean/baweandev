<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->library('RajaOngkir');

    }

	public function get_role(){
		$limit = 20;
		$q = $this->input->get("term");
		$page = $this->input->get("page");

		$offset = ($page - 1) * $limit;

		$this->db->order_by("title");
		if (varlen($q) > 0) {
			$this->db->like("title", $q);
		}
		$this->db->select("idrole as id, title as text");
		$this->db->where('status', '1');

		$data = $this->db->get("role", $limit, $offset);

		if (varlen($q) > 0) {
			$this->db->like("title", $q);
		}
		$this->db->where('status', '1');
		$cdata = $this->db->get("role");
		$count = $cdata->num_rows();

		$endCount = $offset + $limit;
		$morePages = $endCount < $count;

		$results = array(
		  "results" => $data->result_array(),
		  "pagination" => array(
		  	"more" => $morePages
		  )
		);
		echo json_encode($results);
	}
    
	public function get_outlet(){
		$limit = 20;
		$q = $this->input->get("term");
		$page = $this->input->get("page");

		$offset = ($page - 1) * $limit;

		$this->db->order_by("outlet_name");
		if (varlen($q) > 0) {
			$this->db->like("outlet_name", $q);
		}
		$this->db->select("idoutlet as id, outlet_name as text");
		$this->db->where('status', '1');

		$data = $this->db->get("outlet", $limit, $offset);

		if (varlen($q) > 0) {
			$this->db->like("outlet_name", $q);
		}
		$this->db->where('status', '1');
		$cdata = $this->db->get("outlet");
		$count = $cdata->num_rows();

		$endCount = $offset + $limit;
		$morePages = $endCount < $count;

		$results = array(
		  "results" => $data->result_array(),
		  "pagination" => array(
		  	"more" => $morePages
		  )
		);
		echo json_encode($results);
	}

	public function get_user(){
		$limit = 20;
		$q = $this->input->get("term");
		$page = $this->input->get("page");

		$offset = ($page - 1) * $limit;

		$this->db->order_by("name");
		if (varlen($q) > 0) {
			$this->db->like("name", $q);
		}
		$this->db->select("iduser as id, name as text");
		$this->db->where('status', '1');
		$this->db->where('is_active', '1');
		$data = $this->db->get("user", $limit, $offset);

		if (varlen($q) > 0) {
			$this->db->like("name", $q);
		}
		$this->db->where('status', '1');
		$this->db->where('is_active', '1');
		$cdata = $this->db->get("user");
		$count = $cdata->num_rows();

		$endCount = $offset + $limit;
		$morePages = $endCount < $count;

		$results = array(
		  "results" => $data->result_array(),
		  "pagination" => array(
		  	"more" => $morePages
		  )
		);
		echo json_encode($results);
	}

	public function get_city_by_province()
	{
		$province_id = $this->input->post('id');
		$response = $this->rajaongkir->endpoints->city($province_id);
		$cities = $response['data'] ?? [];

		echo json_encode($cities);
	}

}	
