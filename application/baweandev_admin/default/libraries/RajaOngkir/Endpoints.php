<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/RESTClient.php';

use RajaOngkir\RESTClient;

class Endpoints
{
    private $api_key;
    private $account_type;

    public function __construct($api_key, $account_type = 'starter')
    {
        $this->api_key = $api_key;
        $this->account_type = $account_type;
    }

    // public function province($province_id = NULL)
    // {
    //     $params = [];
    //     if ($province_id !== NULL) {
    //         $params['id'] = $province_id;
    //     }
    //     $rest_client = new RESTClient($this->api_key, 'province', $this->account_type);
    //     return $rest_client->get($params);
    // }

    public function province($province_id = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();

        if ($province_id !== NULL) {
            $ci->db->where('idprovince', $province_id);
        }

        $query = $ci->db->get('provinces');

        if ($query->num_rows() > 0) {
            $data = [];
            foreach ($query->result() as $row) {
                $data[] = [
                    'idprovince' => $row->idprovince,
                    'province_name' => $row->province_name
                ];
            }
            return [
                'meta' => ['message' => 'Success get from local', 'code' => 200, 'status' => 'success'],
                'data' => $data
            ];
        }

        // Ambil dari API jika tidak ada
        try {
            $params = $province_id ? ['id' => $province_id] : [];
            $rest_client = new RESTClient($this->api_key, 'province', $this->account_type);
            $response = $rest_client->get($params);

            if (!empty($response['data'])) {
                foreach ($response['data'] as $prov) {
                    $ci->db->replace('provinces', [
                        'idprovince' => $prov['province_id'],
                        'province_name' => $prov['province']
                    ]);
                }
                return $response;
            }
        } catch (Exception $e) {
            log_message('error', 'province API error: ' . $e->getMessage());
        }

        return ['meta' => ['message' => 'Data not found', 'code' => 500, 'status' => 'error'], 'data' => []];
    }

//    public function city($province_id = NULL)
//     {
//         $params = [];
//         if ($province_id !== NULL) {
//             $params['province'] = $province_id;
//         }

//         $rest_client = new RESTClient($this->api_key, 'city', $this->account_type);
//         return $rest_client->get($params);
//     }

    public function city($province_id = NULL, $city_id = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();

        if ($province_id !== NULL) {
            $ci->db->where('idprovince', $province_id);
        }
        if ($city_id !== NULL) {
            $ci->db->where('idcity', $city_id);
        }

        $query = $ci->db->get('cities');

        if ($query->num_rows() > 0) {
            $data = [];
            foreach ($query->result() as $row) {
                $data[] = [
                    'idcity' => $row->idcity,
                    'idprovince' => $row->idprovince,
                    'type' => $row->city_type,
                    'city_name' => $row->city_name
                ];
            }

            return [
                'meta' => ['message' => 'Success get from local', 'code' => 200, 'status' => 'success'],
                'data' => $data
            ];
        }

        // Ambil dari API jika belum ada
        try {
            $endpoint = 'city';
            if ($province_id) {
                $endpoint .= '/' . $province_id;
            }

            $rest_client = new RESTClient($this->api_key, $endpoint, $this->account_type);
            $response = $rest_client->get();

            if (!empty($response['data'])) {
                foreach ($response['data'] as $city) {
                    $ci->db->replace('cities', [
                        'idcity' => $city['city_id'],
                        'idprovince' => $city['province_id'],
                        'city_name' => $city['city_name'],
                        'city_type' => $city['type']
                    ]);
                }
                return $response;
            }
        } catch (Exception $e) {
            log_message('error', 'city API error: ' . $e->getMessage());
        }

        return ['meta' => ['message' => 'Data not found', 'code' => 500, 'status' => 'error'], 'data' => []];
    }

    // public function subdistrict($city_id = NULL)
    // {
    //     $params = [];
    //     if ($city_id !== NULL) {
    //         $params['city_id'] = $city_id;
    //     }

    //     $rest_client = new RESTClient($this->api_key, 'subdistrict', $this->account_type);
    //     return $rest_client->get($params);
    // }

    public function subdistrict($city_id)
    {
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->where('idcity', $city_id);
        $query = $ci->db->get('subdistricts');

        if ($query->num_rows() > 0) {
            $data = [];
            foreach ($query->result() as $row) {
                $data[] = [
                    'idsubdistrict' => $row->idsubdistrict,
                    'idcity' => $row->idcity,
                    'subdistrict_name' => $row->subdistrict_name
                ];
            }

            return [
                'meta' => ['message' => 'Success get from local', 'code' => 200, 'status' => 'success'],
                'data' => $data
            ];
        }

        // Ambil dari API jika belum ada
        try {
            $rest_client = new RESTClient($this->api_key, 'subdistrict/' . $city_id, $this->account_type);
            $response = $rest_client->get();

            if (!empty($response['data'])) {
                foreach ($response['data'] as $sub) {
                    $ci->db->replace('subdistricts', [
                        'idsubdistrict' => $sub['subdistrict_id'],
                        'idcity' => $sub['city_id'],
                        'subdistrict_name' => $sub['subdistrict_name']
                    ]);
                }
                return $response;
            }
        } catch (Exception $e) {
            log_message('error', 'subdistrict API error: ' . $e->getMessage());
        }

        return ['meta' => ['message' => 'Data not found', 'code' => 500, 'status' => 'error'], 'data' => []];
    }

    public function cost($origin, $originType, $destination, $destinationType, $weight, $courier)
    {
        $params = [
            'origin' => $origin,
            'originType' => $originType,
            'destination' => $destination,
            'destinationType' => $destinationType,
            'weight' => $weight,
            'courier' => $courier,
        ];
        $rest_client = new RESTClient($this->api_key, 'cost', $this->account_type);
        return $rest_client->post($params);
    }

    public function internationalOrigin($province_id = NULL, $city_id = NULL)
    {
        $params = is_null($province_id) ? [] : ['province' => $province_id];
        if (!is_null($city_id)) {
            $params['id'] = $city_id;
        }
        $rest_client = new RESTClient($this->api_key, 'internationalOrigin', $this->account_type);
        return $rest_client->get($params);
    }

    public function internationalDestination($country_id = NULL)
    {
        $params = is_null($country_id) ? [] : ['id' => $country_id];
        $rest_client = new RESTClient($this->api_key, 'internationalDestination', $this->account_type);
        return $rest_client->get($params);
    }

    public function internationalCost($origin, $destination, $weight, $courier)
    {
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ];
        $rest_client = new RESTClient($this->api_key, 'internationalCost', $this->account_type);
        return $rest_client->post($params);
    }

    public function waybill($waybill_number, $courier)
    {
        $params = [
            'waybill' => $waybill_number,
            'courier' => $courier,
        ];
        $rest_client = new RESTClient($this->api_key, 'waybill', $this->account_type);
        return $rest_client->post($params);
    }

    public function currency()
    {
        $rest_client = new RESTClient($this->api_key, 'currency', $this->account_type);
        return $rest_client->get();
    }
}
