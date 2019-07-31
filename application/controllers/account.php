<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Account extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $customer_id = $this->session->userdata('id');
        $data = array();
        $data['data'] = $this->db->query("SELECT * from customer where id='$customer_id'")->row();
        $data['main_content'] = $this->load->view('account', $data, true);
        $this->load->view('index', $data);
    }
    public function change_email()
    {
        $errors = false;
        $changedEmail = htmlspecialchars($_POST['changed_email']);
        $customer_id = $this->session->userdata('id');
        if (empty($changedEmail)) {
            $error = true;
            $message['changed_email'] = 'You have to an enter an email address.';
        }
        if ($error) {
            $response['status'] = false;
            $response['message'] = $message;
        } else {
            // $data = array(
            //     'id' => $customer_id,
            //     'email' => $changedEmail
            // );
            $this->db->query("UPDATE rides SET destination='$changedEmail' WHERE id IN (select max(id) FROM rides where customer_id = $customer_id)");
        }
        $response['status'] = true;
        $response['message'] = "<div class='alert alert-success' style='width: 100%'> <i class='fa fa-check-circle'></i> Your email id has been changed. <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
        echo json_encode($response);
        exit();
    }

    public function delete_account()
    {
        $errors = false;
        $customer_id = $this->session->userdata('id');
        $this->db->query("DELETE FROM rides WHERE customer_id = '$customer_id' ");
    }

    public function update_customer()
    {
        $error = false;
        $name = htmlspecialchars($_POST['name']);
        $id = htmlspecialchars($_POST['id']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);
        $gender = htmlspecialchars($_POST['gender']);
        $licence = htmlspecialchars($_POST['licence']);

        if (empty($name)) {
            $error = true;
            $message['name'] = "Name is required.";
        }

        $res = $this->db->query("SELECT * FROM customer WHERE licence='$licence' and id!='$id'")->result();
        if (count($res) == 1) {
            $error = true;
            $message['licence'] = "Licence number already exists";
        }

        if (empty($email)) {
            $error = true;
            $message['email'] = "Email id is required.";

        } else if (!strpos($email, '@illinois.edu')) {
            $error = true;
            $message['email'] = "Email id needs to be an Illinois Email Account.";
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $res = $this->db->query("SELECT * FROM customer WHERE `email`='$email' and id!='$id'")->result();
                if (count($res) == 1) {
                    $error = true;
                    $message['email'] = "Email id already exists";
                }
            } else {
                $error = true;
                $message['email'] = "Email id is invalid";
            }

        }

        if (empty($phone)) {
            $error = true;
            $message['phone'] = "Phone number is required.";
        } else {
            $res = $this->db->query("SELECT * FROM customer WHERE `phone`='$phone' and id!='$id'")->result();
            if (count($res) == 1) {
                $error = true;
                $message['phone'] = "phone already exists";
            }
        }

        if (!empty($password)) {
            if ($password != $confirm_password) {
                $error = true;
                $message['password'] = "Password didn't matched.";
            }
        }

        if (empty($gender)) {
            $error = true;
            $message['gender'] = "Gender is required.";
        }

        if ($error) {
            $response['status'] = false;
            $response['message'] = $message;
            echo json_encode($response);
            exit();
        } else {
            $updated_at = date('Y-m-d G:i:s');

            if (empty($password)) {
                $pkg = array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'gender' => $gender,
                    'licence' => $licence,
                    'updated_at' => $updated_at,
                );
            } else {
                $pkg = array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'gender' => $gender,
                    'password' => md5($password),
                    'licence' => $licence,
                    'updated_at' => $updated_at,
                );
            }
            $data = $this->security->xss_clean($pkg);
            $this->db->where('id', $id);
            $event_id = $this->db->update('customer', $data);

            $response['status'] = true;
            $response['message'] = "<div class='alert alert-success delete_msg pull' style='width: 100%'> <i class='fa fa-check-circle'></i> Your data updation successful. <button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span></button></div>";
            echo json_encode($response);
            exit();
        }
    }
}
