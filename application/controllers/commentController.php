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
        $this->load->database();
    }

    /**
     *
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
            case 'PUT':
                $this->put();
                break;

            case 'DELETE':
                $this->delete();
                break;
        }
    }

    private function get()
    {
        $data = array();
        $data["id"] = $this->uri->segment(3);
        $data["post"] = $this->post->getPost($this->uri->segment(3));
        $this->load->view('commentView', $data);
    }

    private function post()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        if($json->user == '' || $json->comment == '' ||($json->post == '' && $json->parentComment == '')){
            echo json_encode(array("error" => "Fields Cannot be empty."));
            return;
        }
        $insertedId = $this->comment->saveComment($json);
        echo json_encode(array("insertedId" => $insertedId));
    }
}