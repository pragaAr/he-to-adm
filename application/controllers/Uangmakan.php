<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uangmakan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Uangmakan', 'Uangmakan');
    $this->load->model('M_Karyawan', 'Karyawan');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']      = 'Data Uang Makan';
    $data['uangmakan']  = $this->Uangmakan->getData();

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/uangmakan', $data);
    $this->load->view('layout/template/footer');
  }

  public function addUangMakan()
  {
    $data['title']      = 'Tambah Data Uang Makan';
    $data['karyawan']   = $this->Karyawan->getData();
    $data['kdum']       = $this->Uangmakan->getKd();

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/add-uangmakan', $data);
  }

  public function getId()
  {
    $id   = $this->input->post('id_um');
    $data = $this->Uangmakan->getId($id);

    echo json_encode($data);
  }

  public function cart()
  {
    $this->load->view('layout/administrasi/cart-uangmakan');
  }

  public function prosesAdd()
  {
    $userid   = $this->session->userdata('id_user');
    $jmlum    = count($this->input->post('idkaryawan_hidden'));
    $nominal  = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal_hidden'));
    $total    = preg_replace("/[^0-9\.]/", "", $this->input->post('total_hidden'));

    $data  = [
      'kd_um'         => $this->input->post('kdum'),
      'jml_orang'     => $jmlum,
      'jml_nominal'   => $total,
      'user_id'       => $userid,
      'dateAdd'       => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $jmlum; $i++) {
      array_push($detail, ['karyawan_id'  => $this->input->post('idkaryawan_hidden')[$i]]);
      $detail[$i]['kd_um']        = $this->input->post('kdum');
      $detail[$i]['nominal_um']   = $nominal[$i];
    }

    $this->Uangmakan->addData($data, $detail);
    $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
    redirect('uangmakan');
  }

  public function getDetailkd()
  {
    $kd   = $this->input->post('kd_um');
    $data = $this->Uangmakan->getDetailKd($kd);

    echo json_encode($data);
  }

  public function cartupdate()
  {
    $this->load->view('layout/administrasi/cart-update-uangmakan');
  }

  public function update($kd)
  {
    $data['title']      = 'Update Data Uang Makan';
    $data['karyawan']   = $this->Karyawan->getData();
    $data['kd']         = $this->Uangmakan->getDataKd($kd);
    $data['detail']     = $this->Uangmakan->getDetailKd($kd);

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/administrasi/update-uangmakan', $data);
  }

  public function prosesupdate()
  {
    $userid     = $this->session->userdata('id_user');
    $kd         = $this->input->post('kdum');
    $jmlum      = count($this->input->post('karyawanid_hidden'));
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal_hidden'));

    $total = 0;
    $allum = $nominal;
    foreach ($allum as $all) {
      $total += $all;
    }

    $data  = [
      'kd_um'         => $kd,
      'jml_orang'     => $jmlum,
      'jml_nominal'   => $total,
      'user_id'       => $userid,
      'dateAdd'       => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $jmlum; $i++) {
      array_push($detail, ['karyawan_id'  => $this->input->post('karyawanid_hidden')[$i]]);
      $detail[$i]['kd_um']                = $kd;
      $detail[$i]['nominal_um']           = $nominal[$i];
    }

    $this->Uangmakan->updateData($kd, $data, $detail);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('uangmakan');
  }

  public function print()
  {
    $kd = $this->input->post('kd_um');

    $this->load->library('pdf');

    $data['title']    = 'Hira Express - Print Uang Makan';
    $data['dataum']   = $this->Uangmakan->getDataKdUm($kd);
    $data['detailum'] = $this->Uangmakan->getDetailKdUm($kd);

    $this->pdf->generate('print/print-uangmakan', $data, 'Data-Uang-Makan', 'A4', 'portrait');
  }

  public function delete($kd)
  {
    $this->Uangmakan->deleteData($kd);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('uangmakan');
  }
}
