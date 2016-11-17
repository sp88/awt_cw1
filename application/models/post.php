<?php

/**
 * Created by PhpStorm.
 * User: Sahan
 * Date: 17-11-2016
 * Time: 21:35
 */
class Post extends CI_Model
{
    public $id;
    public $description;
    public $url;
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insertEntry($data){
        $this->db->insert('post', $data);
    }

    public function getEntry($id){

    }

    public function getEntryPage($limit, $offset){

    }

}