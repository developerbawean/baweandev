<?php
namespace RajaOngkir;

class RESTClient
{
    protected $api_key;
    protected $endpoint;
    protected $account_type;
    protected $base_url = 'https://rajaongkir.komerce.id/api/v1/';

    public function __construct($api_key, $endpoint, $account_type = 'starter')
    {
        $this->api_key = $api_key;
        $this->endpoint = $endpoint;
        $this->account_type = $account_type;
    }

    protected function buildUrl($params = [])
    {
        $map = [
            'cost' => 'calculate/domestic-cost',
            'internationalCost' => 'calculate/international-cost',
            'waybill' => 'waybill',
            'province' => 'destination/province',
            'city' => 'destination/city',
            'internationalOrigin' => 'destination/international-origin',
            'internationalDestination' => 'destination/international-destination',
            'currency' => 'currency',
        ];

        $url = isset($map[$this->endpoint]) ? $this->base_url . $map[$this->endpoint] : $this->base_url . $this->endpoint;

        // khusus untuk city dengan province_id sebagai path parameter
        if ($this->endpoint === 'city' && isset($params['province'])) {
            $url .= '/' . $params['province'];
            unset($params['province']); // hapus agar tidak dijadikan query string
        }

        return $url;
    }

    public function get($params = [])
    {
        $url = $this->buildUrl($params); // <-- kirim params ke buildUrl

        if (!empty($params)) {
            $url .= '?' . http_build_query($params); // sisanya jadi query string
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'key: ' . $this->api_key,
                'Content-Type: application/json',
            ],
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error #: $err");
        }
        return $response;
    }

    public function post($params = [])
    {
        $url = $this->buildUrl();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => [
                'key: ' . $this->api_key,
                'Content-Type: application/json',
            ],
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error #: $err");
        }
        return $response;
    }
}
