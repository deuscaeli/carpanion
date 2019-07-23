<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}
	
	public function index(){
		$data = array();
        $data['main_content'] = $this->load->view('contact',$data,true);
        $this->load->view('index',$data);
	}
}
