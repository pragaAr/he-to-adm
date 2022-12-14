<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Armada extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Armada', 'Armada');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']    = 'Data Armada';
    $data['armada']   = $this->Armada->getData();

    $this->form_validation->set_rules('platno', 'Plat Nomor', 'trim|required');
    $this->form_validation->set_rules('merk', 'Merk', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/master/armada', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Armada->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('armada');
    }
  }

  public function getId()
  {
    $id   = $this->input->post('id_armada');
    $data = $this->Armada->getId($id);

    echo json_encode($data);
  }

  public function update()
  {
    $id = $this->input->post('idarmada');
    $this->Armada->editData($id);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('armada');
  }

  public function delete($id)
  {
    $this->Armada->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('armada');
  }
}
