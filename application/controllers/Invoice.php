<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Invoice', 'Invoice');
    $this->load->model('M_Penjualan', 'Sales');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']      = 'Data Invoice';
    $data['invoice']    = $this->Invoice->getData();

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/invoice', $data);
    $this->load->view('layout/template/footer');
  }

  public function addInvoice()
  {
    $data['title']    = 'Tambah Data Invoice';
    $data['cust']     = $this->Sales->getDataCust();
    $data['kd']       = $this->Invoice->getKd();

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/add-invoice', $data);
  }

  public function getOrderCust()
  {
    $post   = $this->input->post('pengirim');
    $data   = $this->Sales->getOrderCust($post);

    echo json_encode($data);
  }

  public function getDataOrderCust()
  {
    $no   = $this->input->post('no_order');
    $data   = $this->Sales->getDataOrderCust($no);

    echo json_encode($data);
  }

  public function cart()
  {
    $this->load->view('layout/trans/cart-invoice');
  }

  public function cartUpdate()
  {
    $this->load->view('layout/trans/cart-update-invoice');
  }

  public function prosesAdd()
  {
    $userid     = $this->session->userdata('id_user');
    $kd         = $this->input->post('kd');
    $namacust   = $this->input->post('namacust');
    $nosj       = $this->input->post('nosj_hidden');
    $jmlresi    = count($this->input->post('noorder_hidden'));
    $total      = preg_replace("/[^0-9\.]/", "", $this->input->post('total_hidden'));

    $data  = [
      'kd_inv'        => $kd,
      'nama_cust'     => $namacust,
      'jml_resi'      => $jmlresi,
      'jml_nominal'   => $total,
      'user_id'       => $userid,
      'dateAdd'       => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $jmlresi; $i++) {
      array_push($detail, ['no_order'  => $this->input->post('noorder_hidden')[$i]]);
      $detail[$i]['kd_inv']        = $kd;
      $detail[$i]['surat_jalan']   = $nosj[$i];
    }

    $dateInv = [];

    for ($j = 0; $j < $jmlresi; $j++) {
      array_push($dateInv, ['no_order'  => $this->input->post('noorder_hidden')[$j]]);
      $dateInv[$j]['invAdd']        = date('Y-m-d H:i:s');
    }

    $this->Invoice->addData($data, $detail, $dateInv);
    $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
    redirect('invoice');
  }

  public function getDetailkd()
  {
    $kd   = $this->input->post('kd_inv');
    $data = $this->Invoice->getDetailKd($kd);

    echo json_encode($data);
  }

  public function getDetailDataInvoice()
  {
    $kd   = $this->input->post('kd_inv');
    $data = $this->Invoice->getDetailInv($kd);

    echo json_encode($data);
  }

  public function getDetailDataCust()
  {
    $data = $this->Sales->getDataCust();

    echo json_encode($data);
  }

  public function prosesupdate()
  {
    $userid     = $this->session->userdata('id_user');
    $kd         = $this->input->post('editkd');
    $cust       = $this->input->post('editcust_hidden');
    $sj         = $this->input->post('sj_hidden');
    $jmlresi    = count($this->input->post('noorder_hidden'));
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('edittotal_hidden'));

    $data  = [
      'kd_inv'        => $kd,
      'nama_cust'     => $cust,
      'jml_resi'      => $jmlresi,
      'jml_nominal'   => $nominal,
      'user_id'       => $userid,
      'dateAdd'       => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $jmlresi; $i++) {
      array_push($detail, ['no_order'  => $this->input->post('noorder_hidden')[$i]]);
      $detail[$i]['kd_inv']            = $kd;
      $detail[$i]['surat_jalan']       = $sj[$i];
    }

    $this->Invoice->updateData($kd, $data, $detail);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('invoice');
  }

  public function print()
  {
    $this->load->library('pdf');

    $kd   = $this->input->post('kdinv');

    $data['title']      = 'Hira Express - Print Invoice';
    $data['datacust']   = $this->Invoice->getCustKd($kd);
    $data['detail']     = $this->Invoice->getDetailInv($kd);

    $this->pdf->generate('print/print-invoice', $data, 'Invoice-Penjualan', 'A4', 'portrait');
  }

  public function delete($kd)
  {
    $this->Invoice->deleteData($kd);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('invoice');
  }
}
