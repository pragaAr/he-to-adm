<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Order extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Armada', 'Armada');
    $this->load->model('M_Customer', 'Cust');
    $this->load->model('M_Order', 'Order');
    $this->load->model('M_Sopir', 'Sopir');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title'] = 'Data Order';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/order', $data);
    $this->load->view('layout/template/footer');
  }

  public function getKdOrder()
  {
    $data = $this->Order->getKd();

    echo json_encode($data);
  }

  public function getOrder()
  {
    header('Content-Type: application/json');

    echo $this->Order->getData();
  }

  public function getDataKd()
  {
    $kd   = $this->input->post('kd');
    $data = $this->Order->getDataByKd($kd);

    echo json_encode($data);
  }

  public function add()
  {
    $noorder      = strtolower($this->input->post('ordernumber'));
    $custid       = $this->input->post('custid');
    // $namecust     = strtolower($this->input->post('namecust'));
    $notelp       = $this->input->post('notelp');
    $asal         = strtolower($this->input->post('asal'));
    $tujuan       = strtolower($this->input->post('tujuan'));
    $muatan       = strtolower($this->input->post('muatan'));
    $keterangan   = strtolower($this->input->post('keterangan'));

    $plat         = $this->input->post('plat');
    // $platno       = strtolower($this->input->post('platno'));
    $sopir        = $this->input->post('sopir');
    // $namasopir    = strtolower($this->input->post('namasopir'));
    $nominal      = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));

    $user         = $this->session->userdata('id');
    $addAt        = date('Y-m-d H:i:s');

    $dataorder = [
      'no_order'      => $noorder,
      'customer_id'   => $custid,
      'asal_order'    => $asal,
      'tujuan_order'  => $tujuan,
      'kontak_order'  => $notelp,
      'jenis_muatan'  => $muatan,
      'keterangan'    => $keterangan,
      'status_order'  => 'disiapkan',
      'user_id'       => $user,
      'dateAdd'       => $addAt,
    ];

    $datasangu = [
      'no_order'      => strtolower($noorder),
      'truck_id'      => $plat,
      'sopir_id'      => $sopir,
      'nominal'       => strtolower($nominal),
      'user_id'       => $user,
      'dateAdd'       => $addAt
    ];

    $response = $this->Order->addData($dataorder, $datasangu);

    echo json_encode($response);
  }

  public function update()
  {
    $noorder      = strtolower($this->input->post('ordernumber'));
    $custid       = $this->input->post('custid');
    // $namecust     = strtolower($this->input->post('namecust'));
    $notelp       = $this->input->post('notelp');
    $asal         = strtolower($this->input->post('asal'));
    $tujuan       = strtolower($this->input->post('tujuan'));
    $muatan       = strtolower($this->input->post('muatan'));
    $keterangan   = strtolower($this->input->post('keterangan'));

    $plat         = $this->input->post('plat');
    // $platno       = strtolower($this->input->post('platno'));
    $sopir        = $this->input->post('sopir');
    // $namasopir    = strtolower($this->input->post('namasopir'));
    $nominal      = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));

    $dataorder = [
      'customer_id'   => $custid,
      'asal_order'    => $asal,
      'tujuan_order'  => $tujuan,
      'kontak_order'  => $notelp,
      'jenis_muatan'  => $muatan,
      'keterangan'    => $keterangan,
    ];

    $datasangu = [
      'truck_id'      => $plat,
      'sopir_id'      => $sopir,
      'nominal'       => strtolower($nominal),
    ];

    $where = [
      'no_order' => $noorder
    ];

    $response = $this->Order->updateData($dataorder, $datasangu, $where);

    echo json_encode($response);
  }

  public function delete()
  {
    $kd = $this->input->post('kd');

    $response = $this->Order->deleteData($kd);

    echo json_encode($response);
  }

  public function print($kd)
  {
    $this->load->library('pdf');

    $data = [
      'title'   => 'Hira TO - Print Order',
      'detail'  => $this->Order->printOrder($kd)
    ];

    // var_dump($this->Order->printOrder($kd));
    // die;
    $this->pdf->generate('print/print-order', $data, 'Data-Order', 'A4', 'portrait');
  }
}
