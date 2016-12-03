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
        $data["post"] = $this->post->getPost($this->uri->segment(3));
        $this->load->view('commentView', $data);
    }
}