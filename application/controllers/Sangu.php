<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

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
    $this->load->view('layout/adm/sangu/index', $data);
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
    $tambahan = preg_replace("/[^0-9\.]/", "", $this->input->post('tambahan'));

    $data = [
      'tambahan' => $tambahan
    ];

    $where = [
      'no_order' => $noorder
    ];

    $response = $this->Sangu->editData($data, $where);

    echo json_encode($response);
  }

  public function print($kd)
  {
    $query    = $this->Sangu->sanguByOrder($kd);

    $plat     = $query->platno;
    $sopir    = $query->nama;
    $nominal  = $query->nominal;
    $cust     = $query->nama_cust;
    $asal     = $query->asal_order;
    $tujuan   = $query->tujuan_order;

    $data = [
      'title'     => 'Pengeluaran Kas',
      'sopir'     => $sopir,
      'keperluan' => "Sangu " . strtoupper($plat) . " " . ucwords($sopir),
      'nominal'   => $nominal,
      'desc'      => strtoupper($cust) . ' ' . strtoupper($asal) . '-' . strtoupper($tujuan) . ' (' . strtoupper($kd) . ') ',
    ];

    $content  = $this->load->view('layout/adm/sangu/print', $data, true);

    $mpdf = new Mpdf([
      'mode'          => 'utf-8',
      'format'        => 'A5',
      'orientation'   => 'L',
      'SetTitle'      => "pengeluaran kas-$kd",
      'margin_left'   => 10,
      'margin_right'  => 10,
      'margin_top'    => 5,
      'margin_bottom' => 5,
    ]);

    $mpdf->AddPage();
    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }

  public function printTambahan($kd)
  {
    $query    = $this->Sangu->tambahanByOrder($kd);

    $plat     = $query->platno;
    $sopir    = $query->nama;
    $nominal  = $query->tambahan;
    $cust     = $query->nama_cust;
    $asal     = $query->asal_order;
    $tujuan   = $query->tujuan_order;

    $data = [
      'title'     => 'Pengeluaran Kas',
      'sopir'     => $sopir,
      'keperluan' => "Tambahan Sangu " . strtoupper($plat) . " " . ucwords($sopir),
      'nominal'   => $nominal,
      'desc'      => strtoupper($cust) . ' ' . strtoupper($asal) . '-' . strtoupper($tujuan) . ' (' . strtoupper($kd) . ') ',
    ];

    $content  = $this->load->view('layout/adm/sangu/print', $data, true);

    $mpdf = new Mpdf([
      'mode' => 'utf-8',
      'format' => 'A5',
      'orientation' => 'L'
    ]);

    $mpdf->AddPage();
    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }
}
