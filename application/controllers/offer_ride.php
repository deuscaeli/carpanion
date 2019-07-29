<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_ride extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}
	
	public function index(){
		$data = array();
        $data['main_content'] = $this->load->view('offer_ride',$data,true);
        $this->load->view('index',$data);
	}

	public function offer_ride_action(){  
        $error = false;
        $leaving_from=htmlspecialchars($_POST['leaving_from']);
        $destination=htmlspecialchars($_POST['destination']);
        $leaving_date=htmlspecialchars($_POST['leaving_date']);
        $leaving_time=htmlspecialchars($_POST['leaving_time']);
        $seats=htmlspecialchars($_POST['seats']);
        $leaving_longitude=htmlspecialchars($_POST['leaving_longitude']);
        $leaving_latitude=htmlspecialchars($_POST['leaving_latitude']);
        $destination_longitude=htmlspecialchars($_POST['destination_longitude']);
        $destination_latitude=htmlspecialchars($_POST['destination_latitude']);
        $customer_id=$this->session->userdata('id');
        $liacence_update=$this->session->userdata('licence');

        if(empty($customer_id)){
			$message['customer_id'] = "Login is required.";
			$response['status']=False;
            $response['message']=$message;
            echo json_encode($response);
            exit();
        }
        
        if(empty($liacence_update)){
			$message['liacence_update'] = "<div class='alert alert-danger' style='width: 100%'> <i class='fa fa-check-circle'></i> Licence is required. Please update licence <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
			$response['status']=False;
            $response['message']=$message;
            echo json_encode($response);
            exit();
		}

		if(empty($leaving_from)){
            $error = true;
            $message['leaving_from'] = "Leaving from is required.";
        }

        if(empty($destination)){
            $error = true;
            $message['destination'] = "Destination id is required.";
        }

        if(empty($leaving_date)){
            $error = true;
            $message['leaving_date'] = "Leaving date is required.";
        }

        if(empty($leaving_time)){
            $error = true;
            $message['leaving_time'] = "Leaving time is required.";
        }

        if(empty($seats)){
            $error = true;
            $message['seats'] = "Seats is required.";
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
                'customer_id' => $customer_id,
                'leaving_from' => $leaving_from,
                'destination' => $destination,
                'leaving_date' => $leaving_date,
                'leaving_time' => $leaving_time,
                'seats' => $seats,
                'leaving_longitude' => $leaving_longitude,
                'leaving_latitude' => $leaving_latitude,
                'destination_longitude' => $destination_longitude,
                'destination_latitude' => $destination_latitude,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            );

            $data = $this->security->xss_clean($pkg);
            $event_id = $this->db->insert('rides',$data);
            // $destination = mysql_real_escape_string($destination);
            // $leaving_from = mysql_real_escape_string($leaving_from);
            // $event_id = $this->db->query("INSERT INTO rides (customer_id, leaving_from, destination, leaving_date, leaving_time, seats, leaving_longitude, leaving_latitude, destination_longitude, destination_latitude, created_at, updated_at) VALUES ('$customer_id', '$leaving_from', '$destination', '$leaving_date', '$leaving_time', '$seats', '$leaving_longitude', '$leaving_latitude', '$destination_longitude', '$destination_latitude', '$created_at', '$updated_at')");

            $response['status']=true;
            $response['message']="<div class='alert alert-success' style='width: 100%'> <i class='fa fa-check-circle'></i> Your ride is active for finding. <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
            echo json_encode($response);
            exit();
        }
    } 
}
