<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Traveldoc extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Traveldoc', 'SJ');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Surat Jalan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/surat-jalan/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getTraveldoc()
  {
    header('Content-Type: application/json');

    echo $this->SJ->getData();
  }

  public function getDetailData()
  {
    $reccu = $this->input->post('reccu');

    $response = [
      'data'    => $this->SJ->getDataByReccu($reccu),
      'detail'  => $this->SJ->getDetailByReccu($reccu)
    ];

    echo json_encode($response);
  }

  public function add()
  {
    $data['title']  = 'Tambah Data Surat Jalan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/surat-jalan/add', $data);
    $this->load->view('layout/template/footer');
  }

  public function proses()
  {
    $userid   = $this->session->userdata('id');
    $jmlSj    = count($this->input->post('sj_hidden'));
    $sj       = $this->input->post('sj_hidden');
    $reccu    = strtolower($this->input->post('selectedReccu'));
    $berat    = $this->input->post('valueBerat_hidden');
    $dateAdd  = date('Y-m-d H:i:s');

    $datasj = [
      'reccu'   => strtolower($reccu),
      'jml_sj'  => $jmlSj,
      'user_id' => $userid,
      'dateAdd' => $dateAdd,
    ];

    $datadt = [];

    for ($i = 0; $i < $jmlSj; $i++) {
      array_push($datadt, ['reccu' => $reccu]);
      $datadt[$i]['surat_jalan']  = $sj[$i];
      $datadt[$i]['berat']        = $berat[$i];
    }

    $this->SJ->addData($datasj, $datadt);

    $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');

    redirect('traveldoc');
  }

  public function print($kd)
  {
    $this->load->library('pdf');

    $data['title']  = 'Hira Express - Print Reccu';
    $data['plat']   = $this->Sangu->getPlatByOrder($kd);
    $data['sales']  = $this->Sales->getDataByKd($kd);

    $this->pdf->generate('print/print-penjualan-a5', $data, "reccu-$kd", 'A6', 'portrait');
  }

  public function delete()
  {
    $id = $this->input->post('id');
    $no = $this->input->post('no');

    $data = $this->Sales->deleteData($id, $no);

    echo json_encode($data);
  }
}
