<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persensopir extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Persensopir', 'Persensopir');
    $this->load->model('M_Order', 'Order');
    $this->load->model('M_Sopir', 'Sopir');
    $this->load->model('M_Sangu', 'Sangu');
    $this->load->model('M_Penjualan', 'Sales');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']        = 'Data Persen Sopir';
    $data['persensopir']  = $this->Persensopir->getData();

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/persensopir', $data);
    $this->load->view('layout/template/footer');
  }

  public function addPersensopir()
  {
    $data['title']    = 'Tambah Data Persen Sopir';
    $data['order']    = $this->Order->getData();
    $data['sopir']    = $this->Sopir->getData();
    $data['kdpersen'] = $this->Persensopir->getKd();

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/add-persensopir', $data);
  }

  public function getOrderSopir()
  {
    $sopir  = $this->input->post('sopir_id');
    $data   = $this->Sangu->getOrderSopir($sopir);

    echo json_encode($data);
  }

  public function getDataOrderSopir()
  {
    $noorder  = $this->input->post('no_order');
    $data     = $this->Sales->getOrderSopir($noorder);

    echo json_encode($data);
  }

  public function getId()
  {
    $id   = $this->input->post('id_persen');
    $data = $this->Persensopir->getId($id);

    echo json_encode($data);
  }

  public function cart()
  {
    $this->load->view('layout/administrasi/cart-persensopir');
  }

  public function prosesAdd()
  {
    $order    = count($this->input->post('noorder_hidden'));
    $sopir    = $this->input->post('sopirid');
    $nominal  = preg_replace("/[^0-9\.]/", "", $this->input->post('nominalterima_hidden'));
    $total    = preg_replace("/[^0-9\.]/", "", $this->input->post('total_hidden'));

    $data  = [
      'kd_persen'   => $this->input->post('kdpersen'),
      'sopir_id'    => $sopir,
      'nominal'     => $total,
      'dateAdd'     => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $order; $i++) {
      array_push($detail, ['no_order'  => $this->input->post('noorder_hidden')[$i]]);
      $detail[$i]['kd_persen']        = $this->input->post('kdpersen');
      $detail[$i]['jumlah']           = $nominal[$i];
    }

    $this->Persensopir->addData($data, $detail);
    $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
    redirect('persensopir');
  }

  public function update()
  {
    $id = $this->input->post('idpersen');
    $this->Persensopir->editData($id);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('persensopir');
  }

  public function delete($id)
  {
    $this->Persensopir->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('persensopir');
  }
}
