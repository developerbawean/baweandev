<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lampu extends CI_Controller {

    private $data_path;

    public function __construct() {
        parent::__construct();
        $this->data_path = APPPATH. 'assets/data/lampu_config.json';
        // var_dump($this->data_path);
    }

    public function set_wifi() {
        $ssid = $this->input->post('ssid');
        $password = $this->input->post('password');

        $data = [
            'ssid' => $ssid,
            'password' => $password,
        ];

        file_put_contents($this->data_path, json_encode($data));
        echo json_encode(['status' => 'success', 'message' => 'WiFi saved']);
    }

    public function get_wifi() {
        if (file_exists($this->data_path)) {
            echo file_get_contents($this->data_path);
        } else {
            echo json_encode(['ssid' => '', 'password' => '']);
        }
    }

    public function set_status() {
        $status = $this->input->post('status'); // 'on' or 'off'
        $config = $this->_read_config();
        $config['status'] = $status;
        file_put_contents($this->data_path, json_encode($config));
        echo json_encode(['status' => 'success', 'message' => 'Status updated']);
    }

    public function get_status() {
        $config = $this->_read_config();
        echo json_encode(['status' => $config['status'] ?? 'off']);
    }

    private function _read_config() {
        if (!file_exists($this->data_path)) return [];
        return json_decode(file_get_contents($this->data_path), true);
    }
}
