<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileController extends CI_Controller {

	public function index()
	{
		$this->load->model('ProfileModel');
		$datas = $this->ProfileModel->get();
		$dataShow['profile'] = $datas;
		$this->load->view('profile_reader_view', $dataShow);
	}
}