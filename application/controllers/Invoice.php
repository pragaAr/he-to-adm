<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Invoice', 'Invoice');
    $this->load->model('M_Penjualan', 'Sales');

    if (empty($this->session->userdata('id_user'))) {
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

    $this->Invoice->addData($data, $detail);
    $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
    redirect('invoice');
  }

  public function getDetailkd()
  {
    $kd   = $this->input->post('kd_um');
    $data = $this->Uangmakan->getDetailKd($kd);

    echo json_encode($data);
  }

  public function cartupdate()
  {
    $this->load->view('layout/administrasi/cart-update-uangmakan');
  }

  public function update($kd)
  {
    $data['title']      = 'Update Data Uang Makan';
    $data['karyawan']   = $this->Karyawan->getData();
    $data['kd']         = $this->Uangmakan->getDataKd($kd);
    $data['detail']     = $this->Uangmakan->getDetailKd($kd);

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/update-uangmakan', $data);
  }

  public function prosesupdate()
  {
    $userid     = $this->session->userdata('id_user');
    $kd         = $this->input->post('kdum');
    $jmlum      = count($this->input->post('karyawanid_hidden'));
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal_hidden'));

    $total = 0;
    $allum = $nominal;
    foreach ($allum as $all) {
      $total += $all;
    }

    $data  = [
      'kd_um'         => $kd,
      'jml_orang'     => $jmlum,
      'jml_nominal'   => $total,
      'user_id'       => $userid,
      'dateAdd'       => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $jmlum; $i++) {
      array_push($detail, ['karyawan_id'  => $this->input->post('karyawanid_hidden')[$i]]);
      $detail[$i]['kd_um']                = $kd;
      $detail[$i]['nominal_um']           = $nominal[$i];
    }

    $this->Uangmakan->updateData($kd, $data, $detail);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('uangmakan');
  }

  public function delete($kd)
  {
    $this->Uangmakan->deleteData($kd);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('uangmakan');
  }
}
