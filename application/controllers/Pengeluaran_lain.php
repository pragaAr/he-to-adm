<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran_lain extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Pengeluaran_lain', 'Etc');
    $this->load->model('M_Karyawan', 'Karyawan');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']      = 'Data Pembelian Lain-lain';
    $data['karyawan']   = $this->Karyawan->getData();
    $data['karyawanedit']   = $this->Karyawan->getData();
    $data['etc']        = $this->Etc->getData();

    $this->form_validation->set_rules('karyawan', 'Karyawan', 'trim|required');
    $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/administrasi/lain-lain', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Etc->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('pengeluaran_lain');
    }
  }

  public function getId()
  {
    $id   = $this->input->post('id_lain');
    $data = $this->Etc->getId($id);

    echo json_encode($data);
  }

  public function update()
  {
    $id = $this->input->post('idlain');
    $this->Etc->editData($id);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('pengeluaran_lain');
  }

  public function delete($id)
  {
    $this->Etc->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('pengeluaran_lain');
  }
}
