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

        $config = array();
        $config["base_url"] = base_url() . "/index.php/postController/post";
        $config["total_rows"] = $this->record_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config["prev_link"] = 'Previous';
        $config["next_link"] = 'Next';
//        $config['full_tag_open'] = '<ul class="pagination" id="search_page_pagination">';
//        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if($sort == 'date'){
            $this->db->order_by('date', 'DESC');
        } else if ($sort == 'vote') {
            $this->db->order_by('likes', 'DESC');
        }
        $query = $this->db->get('post', $config["per_page"], $page);
        $results = array();
        foreach ($query->result() as $row){
            $results[] = $row;
        }
        $data["results"] = $results;
        $data["links"] = $this->pagination->create_links();

        $this->load->view("index", $data);
    }

    /**
     * @return mixed
     */
    private function record_count() {
        return $this->db->count_all("Post");
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