<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Penjualan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Penjualan', 'Sales');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Penjualan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/penjualan', $data);
    $this->load->view('layout/template/footer');
  }

  public function getPenjualan()
  {
    header('Content-Type: application/json');

    echo $this->Sales->getData();
  }

  public function getOrderNo()
  {
    $no   = $this->input->post('no_order');
    $data = $this->Order->getOrderNo($no);

    echo json_encode($data);
  }

  public function getNoOrderPenjualan()
  {
    $no   = $this->input->post('no_order');
    $data = $this->Sales->getNoOrderPenjualan($no);

    echo json_encode($data);
  }

  public function add()
  {
    $userid       = $this->session->userdata('id');
    $noorder      = trim($this->input->post('noorder'));
    $nosj         = trim($this->input->post('nosj'));
    $jenis        = trim($this->input->post('jenis'));
    $muatan       = trim($this->input->post('muatan'));
    $berat        = trim($this->input->post('berat'));
    $hrgborong    = preg_replace("/[^0-9\.]/", "", $this->input->post('borong'));
    $hrgtonase    = preg_replace("/[^0-9\.]/", "", $this->input->post('tonase'));
    $pengirim     = trim($this->input->post('pengirim'));
    $kotaasal     = trim($this->input->post('asal'));
    $alamatasal   = trim($this->input->post('alamatasal'));
    $penerima     = trim($this->input->post('penerima'));
    $kotatujuan   = trim($this->input->post('tujuan'));
    $alamattujuan = trim($this->input->post('alamattujuan'));
    $biaya        = preg_replace("/[^0-9\.]/", "", $this->input->post('biaya'));
    $pembayaran   = trim($this->input->post('pembayaran'));
    $dateAdd      = date('Y-m-d H:i:s');

    $data = array(
      'no_order'      => strtolower($noorder),
      'no_sj'         => strtolower($nosj),
      'jenis'         => strtolower($jenis),
      'muatan'        => strtolower($muatan),
      'berat'         => $berat,
      'hrg_borong'    => $hrgborong,
      'hrg_kg'        => $hrgtonase,
      'pengirim'      => strtolower($pengirim),
      'kota_asal'     => strtolower($kotaasal),
      'alamat_asal'   => strtolower($alamatasal),
      'penerima'      => strtolower($penerima),
      'kota_tujuan'   => strtolower($kotatujuan),
      'alamat_tujuan' => strtolower($alamattujuan),
      'total_hrg'     => $biaya,
      'pembayaran'    => strtolower($pembayaran),
      'user_id'       => $userid,
      'dateAdd'       => $dateAdd,
    );

    $dataorder = array(
      'status_order'  => 'diproses',
    );

    $where = array(
      'no_order'  => $noorder
    );

    $data = $this->Sales->addData($data, $dataorder, $where);

    echo json_encode($data);
  }

  public function update()
  {
    $no = $this->input->post('editnoorder');
    $this->Sales->editData($no);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('penjualan');
  }

  public function printPenjualan($no)
  {
    $this->load->library('pdf');

    $data['title']      = 'Hira Express - Print Reccu';
    $data['platno']     = $this->Sales->getPlatPenjualan($no);
    $data['penjualan']  = $this->Sales->getNoOrderPenjualan($no);

    $this->pdf->generate('print/print-penjualan', $data, 'Reccu-Penjualan', 'A4', 'landscape');
  }

  public function delete($no)
  {
    $this->Sales->deleteData($no);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('penjualan');
  }
}
