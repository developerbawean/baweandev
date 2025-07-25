<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(BASEPATH.'/libraries/REST_Controller.php');

class Api_absensi extends REST_Controller
{
    private $valid_token = '12345SECRET'; // ganti dengan token kamu

    public function __construct() {
        parent::__construct();
        $this->load->database();
        header('Content-Type: application/json');
    }

    private function check_token() {
        $headers = getallheaders();
        if (!isset($headers['X-Api-Key']) || $headers['X-Api-Key'] !== $this->valid_token) {
            $this->output_response(['status' => false, 'message' => 'Token tidak valid'], 403);
            return false;
        }
        return true;
    }

    private function output_response($data, $http_code = 200) {
        $this->output
            ->set_status_header($http_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function user_get()
    {
        if (!$this->check_token()) return;

        // Ambil parameter paging dari query string (GET)
        $page = (int) $this->input->get('page');
        $limit = (int) $this->input->get('limit');

        // Set default jika tidak dikirim
        if ($page < 1) $page = 1;
        if ($limit < 1 || $limit > 50) $limit = 10; // batasi max 50 user per halaman

        $offset = ($page - 1) * $limit;

        // Ambil data user aktif dan is_active=1 dari database dengan limit dan offset
        $this->db->where('status', 1);
        $this->db->where('is_active', 1);
        $this->db->limit($limit, $offset);

        $query = $this->db->get('user');
        $users = $query->result_array();

        // Format respons untuk front-end
        $this->output_response([
            'status' => true,
            'page' => $page,
            'limit' => $limit,
            'count' => count($users),
            'data' => $users
        ]);
    }

    // POST: register_card (data: uid, iduser, createdby)
    public function register_card_post() {
        if (!$this->check_token()) return;

        $uid = $this->input->post('uid');
        $iduser = $this->input->post('iduser');
        $createdby = $this->input->post('createdby');

        if (!$uid || !$iduser) {
            $this->output_response(['status' => false, 'message' => 'UID dan ID User wajib diisi'], 400);
            return;
        }

        $cek = $this->db->get_where('user_biometrics', ['card_uid' => $uid]);
        if ($cek->num_rows() > 0) {
            $this->output_response(['status' => false, 'message' => 'Kartu sudah terdaftar'], 409);
            return;
        }

        $data = [
            'iduser' => $this->input->post('iduser'),
            'card_uid' => $this->input->post('card_uid'),
            'fingerprint_data' => $this->input->post('fingerprint_data'),
            'vein_data' => $this->input->post('vein_data'),
            'face_data' => $this->input->post('face_data'),
            'created' => date('Y-m-d H:i:s'),
            'createdby' => 'web', // bisa ganti dengan user login
            'status' => 1
        ];

        $this->db->insert('user_biometrics', $data);
        $this->output_response(['status' => true, 'message' => 'Kartu berhasil didaftarkan', 'data' => $data]);
    }

    // POST: absensi (data: uid)
    public function absensi_post()
    {
        if (!$this->check_token()) return;

        $uid = $this->input->post('uid');
        $response = [
            'status'  => true,
            'message' => '',
            'code'    => 200,
            'data'    => null
        ];

        if (!$uid) {
            $response['status']  = false;
            $response['message'] = 'UID kartu wajib diisi';
            $response['code']    = 400;
            return $this->output_response($response, 400);
        }

        $user = $this->db->get_where('user_biometrics', [
            'card_uid' => $uid,
            'status'   => 1
        ])->row();

        if (!$user) {
            $response['status']  = false;
            $response['message'] = 'Kartu tidak terdaftar atau tidak aktif';
            $response['code']    = 403;
            return $this->output_response($response, 403);
        }

        $this->db->where('iduser', $user->iduser);
        $this->db->where('DATE(waktu)', date('Y-m-d'));
        $check_absen = $this->db->get('absensi');

        if ($check_absen->num_rows() > 0) {
            $response['status']  = false;
            $response['message'] = 'Anda sudah melakukan absensi hari ini';
            $response['code']    = 403;
        } else {
            $absen_data = [
                'iduser'    => $user->iduser,
                'card_uid'  => $uid,
                'waktu'     => date('Y-m-d H:i:s')
            ];
            $this->db->insert('absensi', $absen_data);
            $response['data'] = $absen_data;
            $response['message'] = 'Absensi berhasil';
        }

        return $this->output_response($response, $response['code']);
    }

    // POST: login (data: username, password)
    public function login_post() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (!$username || !$password) {
            $this->output_response(['status' => false, 'message' => 'Username dan password wajib diisi'], 400);
            return;
        }

        $this->db->where('username', $username);
        $this->db->where('password', sha1($password));
        $this->db->where('status', 1);
        $this->db->where('is_active', 1);
        $user = $this->db->get('user')->row_array();

        if ($user) {
            $this->output_response([
                'status' => true,
                'message' => 'Login berhasil',
                'token' => $this->valid_token,
                'user' => $user
            ]);
        } else {
            $this->output_response(['status' => false, 'message' => 'Username atau password salah'], 401);
        }
    }
}
