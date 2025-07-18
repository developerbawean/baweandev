<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('az_select_role')) {
    function az_select_role($id = 'role', $class = '', $attr = 'role')
    {
        $ci = &get_instance();
        $ci->load->library('encryption');
        $azapp = $ci->load->library('AZApp');
        $select = $ci->azapp->add_select2();
        $select->set_id($id);
        $select->set_url('data/get_role');
        $select->set_placeholder('Select a Role');
        if (strlen($class) > 0) {
            $select->add_class($class);
        }
        if (strlen($attr) > 0) {
            $select->add_attr('data-id', $ci->encryption->encrypt($attr . '.idrole'));
            $select->add_attr('w', 'true');
        }

        return $select->render();
    }
}

if (!function_exists('az_select_outlet')) {
    function az_select_outlet($id = 'outlet', $class = '', $attr = 'outlet')
    {
        $ci = &get_instance();
        $ci->load->library('encryption');
        $azapp = $ci->load->library('AZApp');
        $select = $ci->azapp->add_select2();
        $select->set_id($id);
        $select->set_url('data/get_outlet');
        $select->set_placeholder('Select a outlet');
        if (strlen($class) > 0) {
            $select->add_class($class);
        }
        if (strlen($attr) > 0) {
            $select->add_attr('data-id', $ci->encryption->encrypt($attr . '.idoutlet'));
            $select->add_attr('w', 'true');
        }

        return $select->render();
    }
}