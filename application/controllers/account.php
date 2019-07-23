<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}

	public function index(){
		$data = array();
        $data['main_content'] = $this->load->view('account',$data,true);
        $this->load->view('index',$data);
	}
	public function change_email() {
		$errors = false;
		$changedEmail = htmlspecialchars($_POST['changed_email']);
        $customer_id=$this->session->userdata('id');		
		if(empty($changedEmail)) {
			$error = true;
			$message['changed_email'] = 'You have to an enter an email address.';
		}
		if($error){
			$response['status'] = False;
			$response['message'] = $message;
		}else{
			// $data = array(
			// 	'id' => $customer_id,
			// 	'email' => $changedEmail
			// );
			$this->db->query("UPDATE rides SET destination='$changedEmail' WHERE id IN (select max(id) FROM rides where customer_id = $customer_id)");
		}
		$response['status']=true;
        $response['message']="<div class='alert alert-success' style='width: 100%'> <i class='fa fa-check-circle'></i> Your email id has been changed. <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
        echo json_encode($response);
        exit();
	}

	public function delete_account() {
		$errors = false;
		$customer_id=$this->session->userdata('id');
		$this->db->query("DELETE FROM rides WHERE id IN (SELECT id FROM rides WHERE customer_id = '$customer_id') ");
	}
}