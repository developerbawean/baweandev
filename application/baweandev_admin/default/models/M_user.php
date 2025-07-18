<?php 

if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_user extends CI_Model {
    public function get_login_attempt($username)
    {
        return $this->db->get_where('login_attempts', ['username' => $username])->row();
    }

    public function update_login_attempt($username, $ip)
    {
        $attempt = $this->get_login_attempt($username);
        $now = date('Y-m-d H:i:s');

        if ($attempt) {
            $this->db->where('username', $username);
            $this->db->update('login_attempts', [
                'attempts' => $attempt->attempts + 1,
                'last_attempt' => $now
            ]);
        } else {
            $this->db->insert('login_attempts', [
                'username' => $username,
                'ip_address' => $ip,
                'attempts' => 1,
                'last_attempt' => $now
            ]);
        }
    }

    public function clear_login_attempt($username)
    {
        $this->db->where('username', $username);
        $this->db->delete('login_attempts');
    }
}
