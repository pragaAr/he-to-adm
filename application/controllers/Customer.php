<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Customer', 'Customer');

		if (empty($this->session->userdata('id_user'))) {
			$this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Data Customer';
		$data['cust']		= $this->Customer->getData();

		$this->load->view('layout/template/header', $data);
		$this->load->view('layout/template/navbar');
		$this->load->view('layout/template/sidebar');
		$this->load->view('layout/master/customer', $data);
		$this->load->view('layout/template/footer');
	}

	public function getId()
	{
		$id   = $this->input->post('id_customer');
		$data = $this->Customer->getId($id);

		echo json_encode($data);
	}

	public function getDataCustomer()
	{
		$nama	= $this->input->post('nama');
		$data = $this->Customer->getDataByName($nama);

		echo json_encode($data);
	}

	public function update()
	{
		$id = $this->input->post('idcustomer');
		$this->Customer->editData($id);
		$this->session->set_flashdata('updated', 'Data berhasil diubah!');
		redirect('customer');
	}

	public function delete($id)
	{
		$this->Customer->deleteData($id);
		$this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
		redirect('customer');
	}
}
