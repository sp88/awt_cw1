<?php

/**
 * Created by PhpStorm.
 * User: Sahan
 * Date: 17-11-2016
 * Time: 21:19
 */
class Comment extends CI_Model
{
    public $id;
    public $user;
    public $comment;
    public $post;
    public $parentComment;
    public $likes;
    public $dislikes;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function saveComment($data)
    {
        $this->db->insert('comment', $data);
        return $this->db->insert_id();
    }
}