<?php

class VotePost extends  CI_Model
{
    public $post;
    public $user;
    public $vote;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get(){
        $id = $this->uri->segment(2);
        echo $id;
    }

    public function post($json)
    {
        $query = $this->db->get_where('user_post', array('user'=>$this->session->userdata('id'), 'post'=>$json->post));
        if ( $query->num_rows() == 1 )
        {
            $results = array();
            foreach ($query->result('votePost') as $row){
                $results[] = $row;
            }
            // delete vote if same vote status number is passed
            if($results[0]->vote == $json->vote){
                $this->delete($json->post);

            } else {
                // else change vote
                $this->update($json->post);
            }

        } else {
            // enter vote post if not exist
            $array = array(
                'user' => $this->session->userdata('id'),
                'post' => $json->post,
                'vote' => $json->vote
            );
            $this->db->set($array);
            $this->db->insert('user_post');
        }
        // return number of votes for the post
        return array('likes'=>$this->getLikes($json->post), 'dislikes'=>$this->getDisLikes($json->post));
    }

    public function delete($post)
    {
        $this->db->delete('user_post', array('user' => $this->session->userdata('id'), 'post'=>$post));
    }

    public function update($post)
    {
        $this->db->set('vote', '!field');
        $this->db->where('post', $post);
        $this->db->where('user', $this->session->userdata('id'));
        $this->db->update('user_post');
    }

    public function getLikes($post)
    {
        $query = $this->db->get_where('user_post', array('user'=>$this->session->userdata('id'), 'post'=>$post, 'vote'=>1));
        return $query->num_rows();
    }


    public function getDisLikes($post)
    {
        $query = $this->db->get_where('user_post', array('user'=>$this->session->userdata('id'), 'post'=>$post, 'vote'=>0));
        return $query->num_rows();
    }
}