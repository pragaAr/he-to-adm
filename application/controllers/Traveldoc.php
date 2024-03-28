<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Traveldoc extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Traveldoc', 'SJ');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Surat Jalan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/surat-jalan/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getTraveldoc()
  {
    header('Content-Type: application/json');

    echo $this->SJ->getData();
  }

  public function getDetailData()
  {
    $reccu = $this->input->post('reccu');

    $response = [
      'data'    => $this->SJ->getDataByReccu($reccu),
      'detail'  => $this->SJ->getDetailByReccu($reccu)
    ];

    echo json_encode($response);
  }

  public function getReccuByCust()
  {
    $cust = $this->input->post('cust');

    $response = $this->SJ->getDataReccuByCust($cust);

    echo json_encode($response);
  }

  public function add()
  {
    $data['title']  = 'Tambah Data Surat Jalan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/surat-jalan/add', $data);
    $this->load->view('layout/template/footer');
  }

  public function proses()
  {
    $userid   = $this->session->userdata('id');
    $jmlSj    = count($this->input->post('sj_hidden'));
    $sj       = $this->input->post('sj_hidden');
    $reccu    = strtolower($this->input->post('selectedReccu'));
    $order    = strtolower($this->input->post('selectedOrder'));
    $cust     = $this->input->post('selectedCust');
    $ket      = $this->input->post('ket');
    $berat    = $this->input->post('valueBerat_hidden');
    $retur    = $this->input->post('valueRetur_hidden');
    $dateAdd  = date('Y-m-d H:i:s');

    $datasj = [
      'reccu'       => strtolower($reccu),
      'order_no'    => strtolower($order),
      'cust_id'     => $cust,
      'jml_sj'      => $jmlSj,
      'keterangan'  => strtolower($ket),
      'user_id'     => $userid,
      'dateAdd'     => $dateAdd,
    ];

    $datadt = [];

    for ($i = 0; $i < $jmlSj; $i++) {
      array_push($datadt, ['reccu' => $reccu]);
      $datadt[$i]['surat_jalan']  = $sj[$i];
      $datadt[$i]['berat']        = $berat[$i];
      $datadt[$i]['retur']        = $retur[$i];
    }

    $this->SJ->addData($datasj, $datadt);

    $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');

    redirect('traveldoc');
  }

  public function print()
  {
    $cust   = $this->input->post('ttcustname');
    $reccu  = $this->input->post('ttreccu[]');

    $data['title']  = "tanda terima surat jalan $cust";
    $data['nomor']  = "36/HAN/XII/23";
    $data['rc']     = $this->SJ->getTandaTerimaData($reccu);
    $data['dt']     = $this->SJ->getDetailData($reccu);

    $content  = $this->load->view('layout/trans/surat-jalan/print', $data, true);

    $mpdf = new Mpdf([
      'mode'          => 'utf-8',
      'format'        => 'A4',
      'orientation'   => 'P',
      'SetTitle'      => "tanda-terima-surat-jalan ",
      'margin_left'   => 5,
      'margin_right'  => 5,
      'margin_top'    => 5,
      'margin_bottom' => 5,
    ]);

    $mpdf->AddPage();
    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }

  public function delete()
  {
    $reccu = $this->input->post('reccu');

    $data = $this->SJ->deleteData($reccu);

    echo json_encode($data);
  }
}
