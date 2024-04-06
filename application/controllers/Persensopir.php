<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Persensopir extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Persensopir', 'Persen');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title'] = 'Data Persen Sopir';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/persen/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getPersenSopir()
  {
    header('Content-Type: application/json');

    echo $this->Persen->getData();
  }

  public function add()
  {
    $data = [
      'title' => 'Tambah Data Persen Sopir',
      'kd'    => $this->Persen->getKd()
    ];

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/persen/add', $data);
    $this->load->view('layout/template/footer');
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

  public function proses()
  {
    $count        = count($this->input->post('noorder_hidden'));

    $kd           = $this->input->post('kd');
    $date         = date('Y-m-d H:i:s');
    $sopirid      = $this->input->post('sopirid');
    $namasopir    = $this->input->post('namasopir');
    $noorder      = $this->input->post('noorder_hidden');
    $platno       = $this->input->post('platno_hidden');
    $totharga     = preg_replace("/[^0-9\.]/", "", $this->input->post('totharga_hidden'));
    $persen1      = $this->input->post('persen1_hidden');
    $persen2      = $this->input->post('persen2_hidden');
    $totsangu     = preg_replace("/[^0-9\.]/", "", $this->input->post('totsangu_hidden'));
    $diterima     = preg_replace("/[^0-9\.]/", "", $this->input->post('diterima_hidden'));
    $totditerima  = preg_replace("/[^0-9\.]/", "", $this->input->post('total_hidden'));

    $data = [
      'kd'              => $kd,
      'sopir_id'        => $sopirid,
      'jml_order'       => $count,
      'total_diterima'  => $totditerima,
      'user_id'         => $this->session->userdata('id'),
      'dateAdd'         => $date,
    ];

    $detail = [];

    for ($i = 0; $i < $count; $i++) {
      array_push($detail, ['no_order'  => $noorder[$i]]);
      $detail[$i]['kd']         = $kd;
      $detail[$i]['platno']     = $platno[$i];
      $detail[$i]['persen1']    = $persen1[$i];
      $detail[$i]['persen2']    = $persen2[$i];
      $detail[$i]['tot_biaya']  = $totharga[$i];
      $detail[$i]['tot_sangu']  = $totsangu[$i];
      $detail[$i]['diterima']   = $diterima[$i];
    }

    $dataOrder = [];

    for ($j = 0; $j < $count; $j++) {
      $dataOrder[] = array(
        'no_order'          => $noorder[$j],
        'status_persen'     => 1,
      );
    }

    $this->Persen->addData($data, $detail, $dataOrder);

    $this->session->set_flashdata('storedPersen', 'Data berhasil ditambahkan!');

    redirect('persensopir');
  }

  public function delete()
  {
    $kd   = $this->input->post('kd');
    $noorder = $this->Persen->getDataDetailPersenByKd($kd);

    $updateOrder = [];

    foreach ($noorder as $res) {
      $updateOrder[] = array(
        'no_order'      => $res['no_order'],
        'status_persen' => 0,
      );
    }

    $response = $this->Persen->deleteData($kd, $updateOrder);

    echo json_encode($response);
  }
}
