<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sangu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Sangu', 'Sangu');
    $this->load->model('M_Sopir', 'Sopir');
    $this->load->model('M_Armada', 'Armada');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Sangu';
    $data['sangu']  = $this->Sangu->getData();
    $data['sopir']  = $this->Sopir->getData();
    $data['truck']  = $this->Armada->getData();

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/sangu', $data);
    $this->load->view('layout/template/footer');
  }

  public function getNoOrder()
  {
    $no   = $this->input->post('no_order');
    $data = $this->Sangu->getNoOrder($no);

    echo json_encode($data);
  }

  public function update()
  {
    $no = $this->input->post('noorder');
    $this->Sangu->editData($no);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('sangu');
  }

  public function delete($id)
  {
    $this->Sangu->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('sangu');
  }
}
