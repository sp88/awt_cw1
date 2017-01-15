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
        $query = $this->db->get('users');
        return $query->num_rows() == 1;
    }

    public function signup($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function login($username, $password)
    {
        $this->db->select('id, username');
//        $this->db->from('users');

//        $this->db->where('username', $username);
//        $this->db->where('password', $password);
//        $this->db->limit(1);
        $query = $this->db->get_where('users', array('username'=>$username, 'password'=>$password));


//        return $query->num_rows();
        if($query->num_rows() == 1)
        {
            $result = $query->result('user');
            $sess_array = array();
            foreach($result as $row)
            {
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($sess_array);
            }
            return TRUE;

        }
        else
        {
            return FALSE;
        }
    }


}