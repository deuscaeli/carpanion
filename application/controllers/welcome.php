<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}
	
	public function index(){
		$data = array();
		$rides = $this->db->query("SELECT distinct(customer_id) FROM rides")->result();
		$customer = $this->db->query("SELECT * FROM customer")->result();
		$total_rides = $this->db->query("SELECT * FROM rides")->result();
		$total_bookings = $this->db->query("SELECT * FROM bookings")->result();
		$data['graph'] = $this->db->query("SELECT customer.name as book_cust,customer.name as ride_cust, concat('From: ',rides.leaving_from,' To: ',rides.destination) as dest FROM `rides` join bookings on rides.id=bookings.ride_id join customer on customer.id=bookings.customer_id join  customer as cust_rid on cust_rid.id=rides.customer_id")->result();

	    $data['riders'] = count($rides);
	    $data['customer'] = count($customer);
	    $data['total_rides'] = count($total_rides);
	    $data['total_bookings'] = count($total_bookings);
        $data['main_content'] = $this->load->view('home',$data,true);
        $this->load->view('index',$data);
	}
}
