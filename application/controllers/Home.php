<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('M_Alamat', 'Alamat');
		// $this->load->model('M_Kota', 'Kota');

		if (empty($this->session->userdata('id_user'))) {
			$this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] = 'Home';

		$this->load->view('layout/template/header', $data);
		$this->load->view('layout/template/navbar');
		$this->load->view('layout/template/sidebar');
		$this->load->view('layout/home', $data);
		$this->load->view('layout/template/footer');
	}
}
