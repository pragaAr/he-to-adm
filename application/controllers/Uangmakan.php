<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');
class Uangmakan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Uangmakan', 'Um');
    $this->load->model('M_Karyawan', 'Kry');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Uang Makan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/uangmakan', $data);
    $this->load->view('layout/template/footer');
  }

  public function getUangMakan()
  {
    header('Content-Type: application/json');

    echo $this->Um->getData();
  }

  public function getId()
  {
    $id   = $this->input->post('id');
    $data = $this->Um->getId($id);

    echo json_encode($data);
  }

  public function addUangMakan()
  {
    $data = [
      'title' => 'Tambah Data Uang Makan',
      'kd'    => $this->Um->getKd()
    ];

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/add-uangmakan', $data);
    $this->load->view('layout/template/footer');
  }

  public function prosesAdd()
  {
    $userid   = $this->session->userdata('id');
    $jmlorang = count($this->input->post('id_hidden'));
    $nominal  = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal_hidden'));
    $total    = preg_replace("/[^0-9\.]/", "", $this->input->post('total_hidden'));

    $data  = [
      'kd_um'         => $this->input->post('kd'),
      'jml_penerima'  => $jmlorang,
      'jml_nominal'   => $total,
      'user_id'       => $userid,
      'dateAdd'       => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $jmlorang; $i++) {
      array_push($detail, ['karyawan_id'  => $this->input->post('id_hidden')[$i]]);
      $detail[$i]['kd_um']        = $this->input->post('kd');
      $detail[$i]['nominal']      = $nominal[$i];
    }

    $this->Um->addData($data, $detail);
    $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');

    redirect('uangmakan');
  }

  public function getDetailkd()
  {
    $kd   = $this->input->post('kd');
    $data = $this->Um->getDetailKd($kd);

    echo json_encode($data);
  }

  public function getDetailData()
  {
    $kd = $this->input->post('kd');

    $response = [
      'data'    => $this->Um->getDataByKd($kd),
      'detail'  => $this->Um->getDetailByKd($kd)
    ];

    echo json_encode($response);
  }

  public function print()
  {
    $kd = $this->input->post('kdum');

    $this->load->library('pdf');

    $data['title']    = 'Hira Express - Print Uang Makan';
    $data['dataum']   = $this->Um->getDataByKd($kd);
    $data['detailum'] = $this->Um->getDetailByKd($kd);

    $this->pdf->generate('print/print-uangmakan', $data, 'Data-Uang-Makan', 'A4', 'portrait');
  }

  public function delete()
  {
    $kd   = $this->input->post('kd');
    $data = $this->Um->deleteData($kd);

    echo json_encode($data);
  }
}
