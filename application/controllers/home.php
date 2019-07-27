<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class index_graph extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $data = array();
        $customer_id=$this->session->userdata('id');
	    $data['data'] = $this->db->query("SELECT * FROM rides where customer_id='$customer_id' order by id desc")->result();
        $data['main_content'] = $this->load->view('home',$data,true);
        $this->load->view('index',$data);
    }
}