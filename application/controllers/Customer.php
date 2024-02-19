<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');

		$this->load->model('M_Customer', 'Customer');

		if (empty($this->session->userdata('id'))) {
			$this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] 	= 'Data Customer';

		$this->load->view('layout/template/header', $data);
		$this->load->view('layout/template/navbar');
		$this->load->view('layout/template/sidebar');
		$this->load->view('layout/master/customer', $data);
		$this->load->view('layout/template/footer');
	}

	public function getCustomer()
	{
		header('Content-Type: application/json');

		echo $this->Customer->getData();
	}

	public function getId()
	{
		$id   = $this->input->post('id');
		$data = $this->Customer->getId($id);

		echo json_encode($data);
	}

	public function getDataCustomer()
	{
		$nama	= $this->input->post('nama');
		$data = $this->Customer->getDataByName($nama);

		echo json_encode($data);
	}

	public function add()
	{
		$nama 	= trim($this->input->post('nama'));
		$notelp = trim($this->input->post('notelp'));
		$alamat	= trim($this->input->post('alamat'));
		$addAt  = date('Y-m-d H:i:s');

		$data = [
			'nama'    => strtolower($nama),
			'notelp'  => strtolower($notelp),
			'alamat'  => strtolower($alamat),
			'dateAdd'	=> $addAt,
		];

		$data = $this->Customer->addData($data);

		echo json_encode($data);
	}

	public function update()
	{
		$id     = $this->input->post('id');
		$nama 	= trim($this->input->post('nama'));
		$notelp = trim($this->input->post('notelp'));
		$alamat	= trim($this->input->post('alamat'));

		$data = [
			'nama'    => strtolower($nama),
			'notelp'	=> strtolower($notelp),
			'alamat'  => strtolower($alamat),
		];

		$where = [
			'id' => $id
		];

		$data = $this->Customer->editData($data, $where);

		echo json_encode($data);
	}

	public function delete()
	{
		$id   = $this->input->post('id');
		$data = $this->Customer->deleteData($id);

		echo json_encode($data);
	}
}
