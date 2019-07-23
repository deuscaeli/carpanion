<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}
	
	public function index(){
		$data = array();
        $data['main_content'] = $this->load->view('register',$data,true);
        $this->load->view('index',$data);
	}
	
	
	public function register_customer(){  
        $error = false;
        $name=htmlspecialchars($_POST['name']);
        $email=htmlspecialchars($_POST['email']);
        $phone=htmlspecialchars($_POST['phone']);
        $password=htmlspecialchars($_POST['password']);
        $confirm_password=htmlspecialchars($_POST['confirm_password']);
        $gender=htmlspecialchars($_POST['gender']);

        $folder = "upload/person/".time()."/";
        if(isset($_FILES["licence"]["tmp_name"])){
            if(!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $file_name=$_FILES["licence"]["name"];
            $file_tmp=$_FILES["licence"]["tmp_name"];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            if(empty($file_name)){
                $licence = '';
            }else{
                move_uploaded_file($_FILES["licence"]["tmp_name"],$folder.$file_name);
                $licence=$folder.$file_name;
            }
        }


        if(empty($name)){
            $error = true;
            $message['name'] = "Name is required.";
        }

        if(empty($email)){
            $error = true;
            $message['email'] = "Email id is required.";

        }else if(!strpos($email,'@illinois.edu')){
            $error = true;
            $message['email'] = "Email id needs to be an Illinois Email Account.";
        }else{
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$res = $this->db->get_where('customer',array('email'=>$email))->num_rows();
				if($res==1){
					$error = true;
					$message['email'] = "Email id already exists";
				}
			}else{
				$error = true;
				$message['email'] = "Email id is invalid";
			}
            
        }

        if(empty($phone)){
            $error = true;
            $message['phone'] = "Phone number is required.";
        }else{
            $res = $this->db->get_where('customer',array('phone'=>$phone))->num_rows();
            if($res==1){
                $error = true;
                $message['phone'] = "phone already exists";
            }
        }

        if(empty($password)){
            $error = true;
            $message['password'] = "Password is required.";
        }else{
            
            if($password!=$confirm_password){
                $error = true;
                $message['password'] = "Password didn't matched.";
            }
        }

        if(empty($gender)){
            $error = true;
            $message['gender'] = "Gender is required.";
        }

        if($error){
            $response['status']=False;
            $response['message']=$message;
            echo json_encode($response);
            exit();
        }else{
            $created_at = date('Y-m-d G:i:s');
            $updated_at = date('Y-m-d G:i:s');

            $pkg= array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'gender' => $gender,
                'licence' => $licence,
                'password' => md5($password),
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            );

            $data = $this->security->xss_clean($pkg);
            $event_id = $this->db->insert('customer',$data);

            $response['status']=true;
            $response['message']="<div class='alert alert-success delete_msg pull' style='width: 100%'> <i class='fa fa-check-circle'></i> Your registration successful. <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
            echo json_encode($response);
            exit();
        }
    } 
}
