<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('az_get_config')) {
    function az_get_config($key = '', $table = 'config', $default = '')
    {
        $ci = &get_instance();
        // Cek apakah tabel ada
        if (!$ci->db->table_exists($table)) {
            return false;
        }
        // end cek table

        $ci->db->where("key", $key);
        $data = $ci->db->get($table);

        $value = $default;
        if ($data->num_rows() > 0) {
            $value = $data->row()->value;
        }
        return $value;
    }
}

if (!function_exists('az_set_config')) {
    function az_set_config($key = '', $value = '', $table = 'config')
    {
        $ci = &get_instance();

        $arr['value'] = $value;

        $ci->db->where("key", $key);
        $ci->db->update($table, $arr);
    }
}

if (!function_exists('get_config_application')) {
    function get_config_application($table ='config')
    {
        $ci = &get_instance();

        $ci->db->where('status', 1);
        $data = $ci->db->get($table);
        return $data;
    }
}

if (!function_exists('save_config_application')) {
    function save_config_application($table ='config', $key = '', $value = '')
    {
        $ci = &get_instance();

        $ci->db->where('key', $key);
        $data = $ci->db->get($table, $value);
        return $data;
    }
}
