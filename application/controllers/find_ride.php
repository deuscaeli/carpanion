<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Find_ride extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
    }
   
    public function index(){
        $data = array();
        $data['main_content'] = $this->load->view('find_ride',$data,true);
        $this->load->view('index',$data);
    }
 
    public function find_ride_action(){  
        $error = false;
        $leaving_from=htmlspecialchars($_POST['leaving_from']);
        $destination=htmlspecialchars($_POST['destination']);
        $leaving_date=htmlspecialchars($_POST['leaving_date']);
        $leaving_longitude=htmlspecialchars($_POST['leaving_longitude']);
        $leaving_latitude=htmlspecialchars($_POST['leaving_latitude']);
        $destination_longitude=htmlspecialchars($_POST['destination_longitude']);
        $destination_latitude=htmlspecialchars($_POST['destination_latitude']);
        $customer_id=$this->session->userdata('id');
 
        if(empty($customer_id)){
            $message['customer_id'] = "Login is required.";
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
 
        if($error){
            $response['status']=False;
            $response['message']=$message;
            echo json_encode($response);
            exit();
        }else{
            $event_id = $this->db->query("SELECT * FROM rides WHERE leaving_from = '$leaving_from' and destination = '$destination' and leaving_date = '$leaving_date' and id not in (select distinct(ride_id) from bookings) and customer_id <> $customer_id")->result();
 
            $table = '<div class="row">';
            if(count($event_id)){
                foreach($event_id as $myride){
                    $table .= '<div class="col-md-12">
                            <div class="card">
                                <h5 class="card-header">Ride Details <button class="btn btn-primary float-right" onclick="booking('.$myride->id.')">Book</button> </h5>
                                <div class="card-body">
                                    <p style="margin-bottom:2px;"><span class="text-warning">Source:</span> '.$myride->leaving_from.'</p>
                                    <p style="margin-bottom:2px;"><span class="text-warning">Destination:</span> '.$myride->destination.'</p>
                                    <p style="margin-bottom:2px;"><span class="text-warning">Date:</span> '.$myride->leaving_date.'</p>
                                    <p style="margin-bottom:2px;"><span class="text-warning">Time:</span> '.$myride->leaving_time.'</p>
                                   
                                </div>
                            </div>
                        </div>';
                }
            }else{
                $table .= '<div class="col-md-12">
                        <div class="card">
                            <h5 class="card-header">Ride Details</h5>
                            <div class="card-body">
                                <p><span class="text-danger">No rides Available.</span></p>
                            </div>
                        </div>
                    </div>';
            }
            $table .= "</div>";
 
            $response['status']=true;
            $response['message']=$table;
            echo json_encode($response);
            exit();
        }
    }

    function displayrecords(){
        $customer_id=$this->session->userdata('id');
	    $event_id = $this->db->query("SELECT * FROM rides where id not in (select distinct(ride_id) from bookings) and customer_id <> $customer_id")->result();
        $table = '<div class="row">';
            if(count($event_id)){
                foreach($event_id as $myride){
                    $table .= '<div class="col-md-12">
                            <div class="card">
                                <h5 class="card-header">Ride Details <button class="btn btn-primary float-right" onclick="booking('.$myride->id.')">Book</button> </h5>
                                <div class="card-body">
                                    <p style="margin-bottom:2px;"><span class="text-warning">Source:</span> '.$myride->leaving_from.'</p>
                                    <p style="margin-bottom:2px;"><span class="text-warning">Destination:</span> '.$myride->destination.'</p>
                                    <p style="margin-bottom:2px;"><span class="text-warning">Date:</span> '.$myride->leaving_date.'
                                    <span class="text-warning">Time:</span> '.$myride->leaving_time.'</p>
                                   
                                </div>
                            </div>
                        </div>';
                }
            }else{
                $table .= '<div class="col-md-12">
                        <div class="card">
                            <h5 class="card-header">Ride Details</h5>
                            <div class="card-body">
                                <p><span class="text-danger">No rides Available.</span></p>
                            </div>
                        </div>
                    </div>';
            }
        $table .= "</div>";

        $response['status']=true;
        $response['message']=$table;
        echo json_encode($response);
        exit();
    }
    
    public function find_ride_action_perform(){
        $error = false;
        $leaving_from='';//htmlspecialchars($_POST['leaving_from']);
        $destination='';//htmlspecialchars($_POST['destination']);
        $leaving_date='';//htmlspecialchars($_POST['leaving_date']);
        $leaving_longitude='';//htmlspecialchars($_POST['leaving_longitude']);
        $leaving_latitude='';//htmlspecialchars($_POST['leaving_latitude']);
        $destination_longitude='';//htmlspecialchars($_POST['destination_longitude']);
        $destination_latitude='';//htmlspecialchars($_POST['destination_latitude']);
        $ride_id=htmlspecialchars($_POST['ride_id']);
        $customer_id=$this->session->userdata('id');
 
 
        $created_at = date('Y-m-d G:i:s');
        $updated_at = date('Y-m-d G:i:s');
 
        $pkg= array(
            'customer_id' => $customer_id,
            'leaving_from' => $leaving_from,
            'destination' => $destination,
            'leaving_date' => $leaving_date,
            'ride_id' => $ride_id,
            'seats' => '',
            'leaving_longitude' => $leaving_longitude,
            'leaving_latitude' => $leaving_latitude,
            'destination_longitude' => $destination_longitude,
            'destination_latitude' => $destination_latitude,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        );

 
         //$data = $this->security->xss_clean($pkg);
         //$event_id = $this->db->insert('bookings',$pkg);
        $event_id = $this->db->query("INSERT INTO bookings (customer_id, leaving_from, destination, leaving_date, ride_id, leaving_longitude, leaving_latitude, destination_longitude, destination_latitude, created_at, updated_at,seats) VALUES ('$customer_id', '$leaving_from', '$destination', '$created_at', '$ride_id', '$leaving_longitude', '$leaving_latitude', '$destination_longitude', '$destination_latitude', '$created_at', '$updated_at',1)");
        //echo json_encode($event_id);die;
        $response['status']=true;
        $response['message']=" <div class='alert alert-success' style='width: 100%'> <i class='fa fa-check-circle'></i> Your ride has been booked for you. <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
        echo json_encode($response);
        exit();
    }
}