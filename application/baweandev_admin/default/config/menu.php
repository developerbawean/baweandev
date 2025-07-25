<?php
    $config['menu'] = array(         
        array(
            "name" => 'dashboard',
            'title' => azlang('Dashboard'),
            'icon' => 'bi-grid',
            'url' => 'home',
            "role" => array(
                array(
                    'role_name' => 'role_dashboard_save',
                    'role_title' => 'save Role Access'
                ),
            ),
            'submenu' => array(),
        ),
        array(
            "name" => 'device_control',
            'title' => azlang('Device Control'),
            'icon' => 'bi-menu-button-wide',
            'url' => '',
            'role' => array(),
            'submenu' => array(
                array(
                    "name" => "register_biometrics",
                    "title" => "Register Biometrics",
                    'icon' => 'bi-circle',
                    "url" => "register_biometrics",
                    "submenu" => array()
                ),
            ),
        ),
        array(
            "name" => 'settings',
            'title' => 'Setting',
            'icon' => 'bi-gear-fill',
            'url' => '',
            "role" => array(
                array(
                    'role_name' => 'role_role_settings',
                    'role_title' => 'save Role'
                ),
            ),
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
                    "submenu" => array(),
                     "role" => array(
                        array(
                            'role_name' => 'role_role_settings_save',
                            'role_title' => 'save Role Access'
                        ),
                    ),
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

