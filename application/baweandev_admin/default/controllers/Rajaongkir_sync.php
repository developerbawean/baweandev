<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Rajaongkir_sync extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('RajaOngkir');
        $this->load->database();
    }

    public function sync_all() {
        $this->sync_provinces();
        $this->sync_cities();
        $this->sync_subdistricts();
        echo "Semua data berhasil disinkron!";
    }

    public function sync_provinces() {
        $data = json_decode($this->rajaongkir->endpoints->province(), true);
        if (isset($data['data'])) {
            foreach ($data['data'] as $prov) {
                $this->db->replace('provinces', [
                    'idprovince' => $prov['id'],
                    'province_name' => $prov['name']
                ]);
            }
        }
    }

    public function sync_cities() {
        $provinces = $this->db->get('provinces')->result();
        foreach ($provinces as $prov) {
            $data = json_decode($this->rajaongkir->endpoints->city($prov->idprovince), true);
            // echo"<pre>";print_r($data);die;
            if (isset($data['data'])) {
                foreach ($data['data'] as $city) {
                    $this->db->replace('cities', [
                        'idcity' => $city['id'],
                        'idprovince' => $prov->idprovince,
                        'city_name' => $city['name']
                    ]);
                }
            }
        }
    }

    public function sync_subdistricts() {
        $cities = $this->db->get('cities')->result();
        foreach ($cities as $city) {
            $data = json_decode($this->rajaongkir->endpoints->subdistrict($city->idcity), true);
            if (isset($data['data'])) {
                foreach ($data['data'] as $sub) {
                    $this->db->replace('subdistricts', [
                        'idsubdistrict' => $sub['subdistrict_id'],
                        'idcity' => $city->idcity,
                        'subdistrict_name' => $sub['subdistrict_name']
                    ]);
                }
            }
        }
    }
}
