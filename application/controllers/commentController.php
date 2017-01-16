<?php

/**
 * Created by PhpStorm.
 * User: Sahan
 * Date: 17-11-2016
 * Time: 23:38
 */
class CommentController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('comment');
        $this->load->model('post');
        $this->load->model('user');
        $this->load->database();
    }

    /**
     * Main controller for Class
     */
    public function comment()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->get();
                break;

            case 'POST' :
                $this->post();
                break;

        }
    }

    /**
     * Return nested comments for given comment ID
     */
    private function get()
    {
        $data = array();
        $thepost = $this->post->getPost($this->uri->segment(3));
        $user = $this->user->getUser($thepost->user);
        $thepost->user = $user->username;
        $data["post"] = $thepost;
        $data["comments"] = $this->comment->getNestedComments($this->uri->segment(3));
        $this->load->view('commentView', $data);
//        echo json_encode($data);
//        print_r($thepost);
    }

    /**
     * POST request to insert Level 1 comment
     */
    private function post()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        if($json->comment == '' || $json->post == '' ){
            echo json_encode(array("error" => "Fields Cannot be empty."));
            return;
        }
        // get user from the session
        $json->user = $this->session->userdata('id');
        $insertedId = $this->comment->saveComment($json);
        echo json_encode(array("insertedId" => $insertedId));
    }

    /**
     * POST request to insert reply to given comment
     */
    public function reply()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        if($json->comment == '' || $json->parentComment == ''){
            echo json_encode(array("error" => "Fields Cannot be empty."));
            return;
        }
        $json->user = $this->session->userdata('id');
        $insertedId = $this->comment->saveComment($json);
        echo json_encode(array("replyId" => $insertedId));
    }
}