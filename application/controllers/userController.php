<?php
//start session in order to access it through CI
//session_start();
class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('user');
        $this->load->model('post');
        $this->load->library('session');
        $this->load->database();
    }


    /**
     * Get user information
     */
    public function get()
    {
        echo "get";
    }

    /**
     * Create new user in the Database
     */
    public function post()
    {
        $fileContent = file_get_contents("php://input");
        $json = json_decode($fileContent);

        // Check validation for user input in SignUp form
        if ($json == null || $json->username == '' || $json->password == '') {
            $this->output->set_status_header('400');
            echo json_encode(array('error'=> 'Username and Password cannot be empty!!'));
            return;
        }

        $data = array(
            'username' => $json->username,
            'email' => $json->email,
            'password' => md5($json->password)
        );
        $result = $this->user->checkIfUsernameExist($json->username);

        // if the username is already taken, we send a 409(Conflict Status)
        // giving the user a chance to enter a new username
        if ($result == TRUE) {
            $this->output->set_status_header('409');
            echo json_encode(array('error'=> 'Username already exist!'));
            return false;

        } else {
            $data['id'] = $this->user->signup($data);
            unset($data['password']);
            $data['logged_in'] = TRUE;
            $this->session->set_userdata($data);
            echo $this->load->view('navBar','',TRUE);
        }
    }

    /**
     * Login User
     * Creates Session for the user
     */
    public function login()
    {
        $fileContent = file_get_contents("php://input");
        $json = json_decode($fileContent);
        if($this->user->login($json->username, md5($json->password))){
            echo $this->load->view('navBar','',TRUE);
        }
        else {
            echo json_encode(array('error'=>"Something went wrong"));
        }
    }

    /**
     * Logout user from system
     * Destroys session data
     */
    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        echo $this->load->view('navBar','',TRUE);
    }


    public function visitProfile()
    {
        if(!$this->session->userdata('logged_in')){
            // if no session return home
            $this->load->view('index');
        }
        else{
            // load related data to the user
            $data['posts'] =  $this->post->getRecordsForUser($this->session->userdata('id'));
//            $data['comments'] =  $this->comment->
            $this->load->view('profileView', $data);
        }
    }

    public function getUserSpecificPosts()
    {
        $postList = $this->post->getRecordsForUser($this->session->userdata('id'));
//        print_r($postList);
        $this->load->view();
    }

}