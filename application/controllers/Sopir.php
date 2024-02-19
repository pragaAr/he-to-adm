<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');
class Sopir extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Sopir', 'Sopir');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Sopir';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/master/sopir', $data);
    $this->load->view('layout/template/footer');
  }

  public function getSopir()
  {
    header('Content-Type: application/json');

    echo $this->Sopir->getData();
  }

  public function getId()
  {
    $id   = $this->input->post('id');
    $data = $this->Sopir->getId($id);

    echo json_encode($data);
  }

  public function add()
  {
    $nama   = trim($this->input->post('nama'));
    $alamat = trim($this->input->post('alamat'));
    $notelp = trim($this->input->post('notelp'));
    $addAt  = date('Y-m-d H:i:s');

    $data = [
      'nama'    => strtolower($nama),
      'alamat'  => strtolower($alamat),
      'notelp'  => strtolower($notelp),
      'dateAdd' => $addAt,
    ];

    $data = $this->Sopir->addData($data);

    echo json_encode($data);
  }

  public function update()
  {
    $id     = $this->input->post('id');
    $nama   = trim($this->input->post('nama'));
    $alamat = trim($this->input->post('alamat'));
    $notelp = trim($this->input->post('notelp'));

    $data = [
      'nama'    => strtolower($nama),
      'alamat'  => strtolower($alamat),
      'notelp'  => strtolower($notelp),
    ];

    $where = [
      'id' => $id
    ];

    $data = $this->Sopir->editData($data, $where);

    echo json_encode($data);
  }

  public function delete()
  {
    $id   = $this->input->post('id');
    $data = $this->Sopir->deleteData($id);

    echo json_encode($data);
  }
}
