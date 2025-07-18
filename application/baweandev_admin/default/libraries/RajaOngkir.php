<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/RajaOngkir/Endpoints.php';
require_once __DIR__ . '/RajaOngkir/RESTClient.php';

class RajaOngkir
{
    public $endpoints;

    public function __construct($params = [])
    {
        $ci =& get_instance();
        $ci->load->config('rajaongkir');

        $api_key = isset($params['api_key']) ? $params['api_key'] : $ci->config->item('rajaongkir_api_key');
        $account_type = isset($params['account_type']) ? $params['account_type'] : $ci->config->item('rajaongkir_account_type');

        if (!$api_key) {
            throw new Exception("API key is required.");
        }

        $this->endpoints = new Endpoints($api_key, $account_type);
    }
}
