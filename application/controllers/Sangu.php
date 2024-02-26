<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Sangu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Order', 'Order');
    $this->load->model('M_Sangu', 'Sangu');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Sangu';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/sangu', $data);
    $this->load->view('layout/template/footer');
  }

  public function getSangu()
  {
    header('Content-Type: application/json');

    echo $this->Sangu->getData();
  }

  public function getDataKd()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Sangu->getDataByKd($kd);

    echo json_encode($data);
  }

  public function getDetail()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Order->printOrder($kd);

    echo json_encode($data);
  }

  public function update()
  {
    $noorder  = $this->input->post('noorder');
    $tambahan = $this->input->post('tambahan');

    $data = [
      'tambahan' => $tambahan
    ];

    $where = [
      'no_order' => $noorder
    ];

    $response = $this->Sangu->editData($data, $where);

    echo json_encode($response);
  }
}
