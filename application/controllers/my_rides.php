<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class My_rides extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
    }
   
    public function index(){
        $data = array();
        $customer_id=$this->session->userdata('id');
	    $data['data'] = $this->db->query("SELECT * FROM rides where customer_id='$customer_id' order by id desc")->result();
        $data['main_content'] = $this->load->view('my_rides',$data,true);
        $this->load->view('index',$data);
    }
 
    function displayrecords(){
        $event_id = NULL;
        $table = '<div class="row">';
            if(count($event_id)){
                $cou = 1;
                foreach($event_id as $myride){
                    $table .= "<div class='col-md-12' style='margin-top:20px;'>
                            <div class='card'>
                                <h5 class='card-header'>Ride $cou </h5>
                                <div class='card-body'>
                                    <p style='margin-bottom:2px;'><span class='text-warning'>Source:</span> '.$myride->leaving_from.'</p>
                                    <p style='margin-bottom:2px;'><span class='text-warning'>Destination:</span> '.$myride->destination.'</p>
                                    <p style='margin-bottom:2px;'><span class='text-warning'>Date:</span> '.$myride->leaving_date.'
                                    <span class='text-warning'>Time:</span> '.$myride->leaving_time.'</p>
                                   
                                </div>
                            </div>
                        </div>";
                    $cou++;
                }
            }else{
                $table .= '<div class="col-md-12">
                        <div class="card">
                            <h5 class="card-header">Ride </h5>
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