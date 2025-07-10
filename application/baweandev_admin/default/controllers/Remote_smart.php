<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remote_smart extends CI_Controller {

    private $data_path;

    public function __construct() {
        parent::__construct();
        $this->data_path = APPPATH. 'assets/data/lampu_config.json';
        // pastikan folder data sudah ada dan bisa ditulis
    }

    public function index() {
        $this->load->library('AZApp');
        $app = $this->azapp;
        $data_header['title'] = azlang('Dashboard');
        $data_header['breadcrumb'] = array('dashboard');
        $app->set_data_header($data_header);

        $status = 'off';
        if (file_exists($this->data_path)) {
            $config = json_decode(file_get_contents($this->data_path), true);
            $status = isset($config['status']) ? $config['status'] : 'off';
        }
        $data['status'] = $status;
        $view = $this->load->view('remote_smart/v_remote_smart', $data, true);
        $app->add_content($view);

        $js = az_add_js('remote_smart/vjs_remote_smart');
		$app->add_js($js);

        echo $app->render(); 
    }

    public function toggle() {
    // Hapus dulu pengecekan ajax agar mudah testing
    // if (!$this->input->is_ajax_request()) {
    //     show_error('No direct script access allowed');
    // }

    $current_status = 'off';
    if (file_exists($this->data_path)) {
        $config = json_decode(file_get_contents($this->data_path), true);
        $current_status = isset($config['status']) ? $config['status'] : 'off';
    }
    $new_status = ($current_status === 'on') ? 'off' : 'on';

    $config['status'] = $new_status;
    file_put_contents($this->data_path, json_encode($config));

    // Pastikan header JSON dan keluaran hanya JSON tanpa output lain
    $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => $new_status,
                    'message' => 'Lampu ' . strtoupper($new_status)
                ]));
        }

}