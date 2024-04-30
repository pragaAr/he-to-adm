<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Pengeluaran_lain extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Pengeluaran_lain', 'Etc');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Pengeluaran Lain-lain';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/etc/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getPengeluaranLain()
  {
    header('Content-Type: application/json');

    echo $this->Etc->getData();
  }

  public function getKode()
  {
    $data = $this->Etc->getKd();

    echo json_encode($data);
  }

  public function add()
  {
    $data['title']  = 'Tambah Pengeluaran Lain-lain';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/etc/add', $data);
    $this->load->view('layout/template/footer');
  }

  public function proses()
  {
  }

  public function print()
  {
  }

  public function delete($id)
  {
    $this->Etc->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('pengeluaran_lain');
  }
}
