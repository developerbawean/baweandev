<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends CI_Controller {

    public function load($type = '', $folder = '', $file = '')
    {
        $path = APPPATH . "assets/{$type}/{$folder}/{$file}";

        if (!file_exists($path)) {
            show_404();
            return;
        }

        // Set content type
        $mime_types = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
        ];

        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mime = isset($mime_types[$ext]) ? $mime_types[$ext] : 'application/octet-stream';

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($path));
        readfile($path);
    }
}
