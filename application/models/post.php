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

    public function getList($sort)
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
            $this->db->order_by('date', 'ASC');
        } else if ($sort == 'vote') {
            $this->db->order_by('likes', 'DESC');
        } else {
            $this->db->order_by('date', 'DESC');
        }
        $query = $this->db->get('post', $config["per_page"], $page);
        $results = array();
        foreach ($query->result() as $row){
            $results[] = $row;
        }
        $data["results"] = $results;
        $data["links"] = $this->pagination->create_links();

        return $data;
    }

    public function insertEntry($data){
        $this->db->insert('post', $data);
    }

    public function getPost($id){
        $this->db->where('id', $id);
        $query = $this->db->get('post');
        if ( $query->num_rows() == 1 )
        {
            $results = array();
            foreach ($query->result('post') as $row){
                $results[] = $row;
            }
            return $results[0];
        }
        return false;
    }

    /**
     * @param $id
     * Save Like in DB for given Post
     */
    public function likePost($id)
    {
        // prevent data from being escaped by FALSE parameter
        $this->db->set('likes', 'likes+1', FALSE);
        $this->db->where('id', $id);
        $result = $this->db->update('post');
        echo $result;
    }

    /**
     * @param $id
     * Save Dislike in DB for given Post
     */
    public function dislikePost($id)
    {
        // prevent data from being escaped by FALSE parameter
        $this->db->set('dislikes', 'dislikes+1', FALSE);
        $this->db->where('id', $id);
        $result = $this->db->update('post');
        echo $result;
    }

    /**
     * @return mixed
     */
    private function record_count() {
        return $this->db->count_all("Post");
    }

}