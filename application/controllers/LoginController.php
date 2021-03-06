<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	public function index()
	{
		
		$this->load->view('login_view');
	}

	public function check_login(){

		$this->load->model('LoginModel');
		$data = $this->LoginModel->get_data();

		if(count($data) > 0){
			$sess_array = array(
				'userid' => $data[0]['user_ID'],
				'fName' => $data[0]['ReaderFname'],
				'lName' => $data[0]['ReaderLname'],
				'cash' => $data[0]['ReaderCash'],
			);
			$this->session->set_userdata('loged_in',$sess_array);
			redirect('HomeController');
		
		}
		else {
		$this->session->set_flashdata('error','invalid login attempt.');
		$this->load->view('login_view');
		}
	}
}