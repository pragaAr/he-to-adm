<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Order', 'Order');
    $this->load->model('M_Penjualan', 'Sales');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']        = 'Data Penjualan';
    $data['order']        = $this->Order->getDataPenjualanNull();
    $data['sales']        = $this->Sales->getData();

    $this->form_validation->set_rules('jenispenjualan', 'Jenis Penjualan', 'trim|required');
    $this->form_validation->set_rules('penerima', 'Penerima', 'trim|required');
    $this->form_validation->set_rules('pembayaran', 'Pembayaran', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/trans/penjualan', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Sales->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('penjualan');
    }
  }

  public function getOrderNo()
  {
    $no   = $this->input->post('no_order');
    $data = $this->Order->getOrderNo($no);

    echo json_encode($data);
  }

  public function getNoOrderPenjualan()
  {
    $no   = $this->input->post('no_order');
    $data = $this->Sales->getNoOrderPenjualan($no);

    echo json_encode($data);
  }

  public function update()
  {
    $no = $this->input->post('editnoorder');
    $this->Sales->editData($no);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('penjualan');
  }

  public function printPenjualan($no)
  {
    $this->load->library('pdf');

    $data['title']      = 'Hira Express - Print Reccu';
    $data['platno']     = $this->Sales->getPlatPenjualan($no);
    $data['penjualan']  = $this->Sales->getNoOrderPenjualan($no);

    $this->pdf->generate('print/print-penjualan', $data, 'Reccu-Penjualan', 'A4', 'landscape');
  }

  public function delete($no)
  {
    $this->Sales->deleteData($no);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('penjualan');
  }
}
