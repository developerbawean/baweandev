<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Restclient {
    public function post($url, $data = [], $headers = []) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
            'Content-Type: application/json'
        ], $headers));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return ['error' => curl_error($ch)];
        }
        curl_close($ch);
        return json_decode($response, true);
    }
}
