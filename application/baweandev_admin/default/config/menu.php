<?php
    $config['menu'] = array(         
        array(
            "name" => 'dashboard',
            'title' => azlang('Dashboard'),
            'icon' => 'bi-grid',
            'url' => 'home',
            'role' => array(),
            'submenu' => array(),
        ),
        array(
            "name" => 'lamp_smart',
            'title' => azlang('Remote Lampu'),
            'icon' => 'bi-menu-button-wide',
            'url' => 'Lampu',
            'role' => array(),
            'submenu' => array(
                array(
                    "name" => "remote_smart_lamp",
                    "title" => "Lampu Depan",
                    'icon' => 'bi-circle',
                    "url" => "remote_smart",
                    "submenu" => array()
                ),
            ),
        ),
        array(
            "name" => 'settings',
            'title' => 'Setting',
            'icon' => 'bi-gear-fill',
            'url' => '',
            'role' => array(),
            'submenu' => array(
                array(
                    "name" => "user_settings",
                    "title" => "Users",
                    'icon' => 'bi-circle',
                    "url" => "user",
                    "submenu" => array()
                ),
                array(
                    "name" => "role_settings",
                    "title" => "Role Management",
                    'icon' => 'bi-circle',
                    "url" => "role_access",
                    "submenu" => array()
                ),
                array(
                    "name" => "config_settings",
                    "title" => "Configuration",
                    'icon' => 'bi-circle',
                    "url" => "config",
                    "submenu" => array()
                ),
            ),
        ),
    );

