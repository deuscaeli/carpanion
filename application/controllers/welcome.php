<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent::__construct();
	}
	
	public function index(){
		$data = array();
		$drivers = $this->db->query("SELECT distinct(customer_id) FROM rides")->result();
		$customers = $this->db->query("SELECT * FROM customer")->result();
		$total_rides = $this->db->query("SELECT * FROM rides")->result();
		$total_bookings = $this->db->query("SELECT * FROM bookings")->result();
		$data['graph'] = $this->db->query("SELECT customer.name as book_cust,customer.name as ride_cust, concat('From: ',rides.leaving_from,' To: ',rides.destination) as dest FROM `rides` join bookings on rides.id=bookings.ride_id join customer on customer.id=bookings.customer_id join  customer as cust_rid on cust_rid.id=rides.customer_id")->result();
		
	    $data['total_drivers'] = count($drivers);
	    $data['total_customers'] = count($customers);
	    $data['total_rides'] = count($total_rides);
		$data['total_bookings'] = count($total_bookings);
		
		// $customer_id = $this->session->userdata('id');
		$sql = "SELECT (SELECT `name` from customer where customer.id=rides.customer_id) as driver, (SELECT `name` from customer where customer.id=bookings.customer_id) as rider, bookings.id, rides.leaving_from, rides.destination, rides.leaving_date, rides.leaving_time,bookings.seats, bookings.created_at FROM bookings left join rides on bookings.ride_id=rides.id";
		$data['data'] = $this->db->query($sql)->result();
		$data['users'] = $customers;
		$data['locations'] = $this->db->query("SELECT DISTINCT destination FROM rides")->result();
        $data['main_content'] = $this->load->view('home',$data,true);
        $this->load->view('index',$data);
	}
}
