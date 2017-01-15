<?php

class VotePostController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('user');
        $this->load->model('post');
        $this->load->model('votePost');
        $this->load->database();
    }

    public function getVotePost($id)
    {
        echo $id;
    }

    public function postVotePost()
    {
        $data = file_get_contents("php://input");
        $result = $this->votePost->post(json_decode($data));
        echo json_encode($result);
    }

    public function updateVotePost($id, $vote)
    {
        echo $id." ".$vote;
    }

    public function deleteVotePost($id)
    {
        echo $id;
    }
}