<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sopir extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Sopir', 'Sopir');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']    = 'Data Sopir';
    $data['sopir']    = $this->Sopir->getData();

    $this->form_validation->set_rules('namasopir', 'Nama Sopir', 'trim|required');
    $this->form_validation->set_rules('alamatsopir', 'Alamat Sopir', 'trim|required');
    $this->form_validation->set_rules('notelpsopir', 'Notelp Sopir', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/master/sopir', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Sopir->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('sopir');
    }
  }

  public function getId()
  {
    $id   = $this->input->post('id_sopir');
    $data = $this->Sopir->getId($id);

    echo json_encode($data);
  }

  public function update()
  {
    $id = $this->input->post('idsopir');
    $this->Sopir->editData($id);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('sopir');
  }

  public function delete($id)
  {
    $this->Sopir->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('sopir');
  }
}
