<?php

class User extends CI_Model
{
    public $id;
    public $username;
    public $password;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function checkIfUsernameExist($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('user');
        return $query->num_rows() == 1;
    }

    public function signup($data)
    {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function login($username, $password)
    {
        $this->db ->select('id, username, password');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->limit(1);

        $query = $this->db->get('user');

        if($query->num_rows() == 1)
        {
            $result = $query->result();
            $sess_array = array();
            foreach($result as $row)
            {
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return true;

        }
        else
        {
            return false;
        }
    }


}