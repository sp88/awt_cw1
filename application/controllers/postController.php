<?php

/**
 * Created by PhpStorm.
 * User: Sahan
 * Date: 18-11-2016
 * Time: 00:56
 */
class PostController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('post');
        $this->load->library('pagination');
        $this->load->database();
    }

    /**
     *
     */
    public function post()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $sort = $this->input->get('sort','date');
                $this->get($sort);
                break;

            case 'POST' :
                $data = file_get_contents("php://input");
                $json = json_decode($data);
                $this->postPost($json);
                break;

        }
    }

    /**
     *
     */
    private function get($sort)
    {
        $data = $this->post->getList($sort);
        $this->load->view("index", $data);
    }


    /**
     * @param $data
     * Save data for entered post
     */
    private function postPost($data)
    {
        // validate whether values for all fields are present
        if($data->date == '' || $data->description == '' || $data->url == '' || $data->user == ''){
            echo json_encode(array('error'=>'Date/Description/Data/User cannot be empty for Post entered.'));
            return;
        }

        // if necessary data are present, save in DB
        $post = array('id'=>$data->id, 'date'=> $data->date, 'description'=>$data->description,
            'url'=>$data->url, 'user'=>$data->user);
        echo $this->db->insert('post', $post);
    }


    /**
     * Send data to like a specific post
     */
    public function likePost()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        $result = $this->post->likePost($json->id);
        echo json_encode(array('success'=> $result));
    }

    /**
     * Send data to dislike a specific post
     */
    public function dislikePost()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        $result = $this->post->dislikePost($json->id);
        echo json_encode(array('success'=> $result));
    }

}