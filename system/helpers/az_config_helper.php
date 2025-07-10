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

if (!function_exists('az_get_config_byoutlet')) {
    function az_get_config_byoutlet($key = '', $table = 'config', $idoutlet = '', $default = '')
    {
        $ci = &get_instance();
        $ci->db->where("key", $key);
        $ci->db->where("id_outlet", $idoutlet);
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

if (!function_exists('az_get_outlet_config')) {
    function az_get_outlet_config($key = '', $bool = true)
    {
        $ci = &get_instance();
        $idoutlet = $ci->session->userdata('idoutlet');
        $idoutlet_selected = $ci->session->userdata('idoutlet_selected');

        if (strlen($idoutlet_selected) > 0) {
            $idoutlet = $idoutlet_selected;
        }

        if (strlen($idoutlet) == 0) {
            return true;
        }

        $ci->db->where('idoutlet', $idoutlet);
        $ci->db->where('status', 1);
        $check = $ci->db->get('outlet');
        if ($check->num_rows() == 0) {
            return false;
        }


        $check = $check->row_array();
        if (array_key_exists($key, $check)) {
            if (!$bool) {
                return $check[$key];
            }
            if ($check[$key] == 1) {
                return true;
            }
        }

        return false;
    }
}
