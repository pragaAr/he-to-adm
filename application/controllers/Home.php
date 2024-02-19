<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Customer', 'Cust');
		$this->load->model('M_Order', 'Order');
		$this->load->model('M_Penjualan', 'Sales');

		if (empty($this->session->userdata('id'))) {
			$this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Home';
		$data['cust']		= $this->Cust->countData();
		$data['order']	= $this->Order->countData();
		$data['sales']	= $this->Sales->countData();

		$this->load->view('layout/template/header', $data);
		$this->load->view('layout/template/navbar');
		$this->load->view('layout/template/sidebar');
		$this->load->view('layout/home', $data);
		$this->load->view('layout/template/footer');
	}
}
