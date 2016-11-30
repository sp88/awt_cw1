<?php

/**
 * Created by PhpStorm.
 * User: Sahan
 * Date: 18-11-2016
 * Time: 00:56
 */
class postController extends CI_Controller
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
                $offset = $this->input->get('offset',0);
                $limit = $this->input->get('limit',10);
                $this->get($limit, $offset);
                break;

            case 'POST' :
                $data = file_get_contents("php://input");
                $json = json_decode($data);
                $this->postPost($json);
                break;

//            case 'PUT':
//                $this->put();
//                break;

            case 'DELETE':
                $this->delete();
                break;
        }
    }

    /**
     * @param $limit
     * @param $offset
     */
    private function get($limit, $offset)
    {

        $config = array();
        $config["base_url"] = base_url() . "postController/post";
        $config["total_rows"] = $this->record_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
//        $config['full_tag_open'] = '<ul class="pagination" id="search_page_pagination">';
//        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
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

    private function delete()
    {
        $id = $this->input->delete('id');
        $this->db->delete('post', array('id' => $id));
    }

}