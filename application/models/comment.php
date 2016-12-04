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
    public $childComments = array();

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

    /**
     * @param $id
     * @return array
     * Get a list of nested comments for a given post ID
     */
    public function getNestedComments($id)
    {
        $comments = array();
        // add all level 1 comments
        $this->db->where('post', $id);
        $query = $this->db->get('comment');
        foreach ($query->result('comment') as $row){
            $comments[] = $row;
        }
        // recursively add level comments
        foreach ($comments as $comment){
            $this->db->where('parentComment', $comment->id);
            $query = $this->db->get('comment');
            foreach ($query->result('comment') as $row){
                $comment->childComments[] = $row;
                $this->getNestedComments($row->id);
            }
        }
        return $comments;
    }
}