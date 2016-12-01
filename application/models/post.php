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
    public $date;
    public $description;
    public $url;
    public $user;
    public $likes;
    public $dislikes;

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

    public function likePost($id)
    {
        // prevent data from being escaped by FALSE parameter
        $this->db->set('likes', 'likes+1', FALSE);
        $this->db->where('id', $id);
        $result = $this->db->update('post');
        echo $result;
    }

    public function dislikePost($id)
    {
        // prevent data from being escaped by FALSE parameter
        $this->db->set('dislikes', 'dislikes+1', FALSE);
        $this->db->where('id', $id);
        $result = $this->db->update('post');
        echo $result;
    }

}