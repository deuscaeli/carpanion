<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}
	
	public function index(){
		$data = array();
        $data['main_content'] = $this->load->view('login',$data,true);
        $this->load->view('index',$data);
	}

	public function check_login(){  
        $error = false;
        $phone=htmlspecialchars($_POST['phone']);
        $password=htmlspecialchars($_POST['password']);

        if(empty($phone)){
            $error = true;
            $message['phone'] = "Phone number is required.";
        }else{
            $res = $this->db->get_where('customer',array('phone'=>$phone))->num_rows();
            if($res==0){
                $error = true;
                $message['phone'] = "Incorrect Phone number.";
            }
        }

        if(empty($password)){
            $error = true;
            $message['password'] = "Password is required.";
        }else{
            $result = $this->db->get_where('customer',array('phone'=>$phone,'password'=>md5($password)))->num_rows();
            if($result==0){
                $error = true;
                $message['password'] = "Incorrect password.";
            }
        }

        if($error){
            $response['status']=False;
            $response['message']=$message;
            echo json_encode($response);
            exit();
        }else{
            $result = $this->db->get_where('customer',array('phone'=>$phone,'password'=>md5($password)))->row();
            $data = array(
                'id' => $result->id,
                'name' => $result->name,
                'phone' => $result->phone,
                'email' =>$result->email,
                'status' =>$result->status,
                'is_login' => TRUE
            );
            $this->session->set_userdata($data);

            $response['status']=true;
            $response['message']="<div class='alert alert-success' style='width: 100%'> <i class='fa fa-check-circle'></i> Login successful <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
            echo json_encode($response);
            exit();
        }
    }  

    public function logout(){
        $this->session->sess_destroy();
        header('location:'.base_url());
    }
}
