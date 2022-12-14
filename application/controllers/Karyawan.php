<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Karyawan', 'Karyawan');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']      = 'Data Karyawan';
    $data['karyawan']   = $this->Karyawan->getData();

    $this->form_validation->set_rules('nama', 'Nama Karyawan', 'trim|required');
    $this->form_validation->set_rules('usia', 'Usia', 'trim|required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    $this->form_validation->set_rules('notelp', 'No Telepon', 'trim|required');
    $this->form_validation->set_rules('status', 'Status', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/master/karyawan', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Karyawan->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('karyawan');
    }
  }

  public function getId()
  {
    $id   = $this->input->post('id_karyawan');
    $data = $this->Karyawan->getId($id);

    echo json_encode($data);
  }

  public function update()
  {
    $id = $this->input->post('idkaryawan');
    $this->Karyawan->editData($id);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('karyawan');
  }

  public function delete($id)
  {
    $this->Karyawan->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('karyawan');
  }
}
