<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangePasswordController extends CI_Controller {

	public function index()
	{
		
		$this->load->view('change_password_view');
	}

	public function change_password(){
		$old_password = $this->input->post('oldPassword');		
		$this->load->model('ChangePasswordModel');	
		$datas = $this->ChangePasswordModel->check_password($old_password);
		if($datas != null){
			$session_data = $this->session->userdata('loged_in');
			$id = $session_data['userid'];

			$new_password = $this->input->post('password');
			$this->ChangePasswordModel->update_password($id, $new_password);
			$this->session->set_flashdata('type', 'password');
			$this->session->unset_userdata('loged_in', null);
			redirect('ShowSuccessController');
		}
		else{
			$this->session->set_flashdata('error', 'คุณกรอกรหัสผ่านเดิมไม่ถูกต้อง!');
			$this->load->view('change_password_view');
		}	
	}
}