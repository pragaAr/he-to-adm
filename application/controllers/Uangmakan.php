<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Uangmakan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Uangmakan', 'Um');
    $this->load->model('M_Karyawan', 'Kry');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']  = 'Data Uang Makan';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/adm/uang-makan/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getUangMakan()
  {
    header('Content-Type: application/json');

    echo $this->Um->getData();
  }

  public function getId()
  {
    $id   = $this->input->post('id');
    $data = $this->Um->getId($id);

    echo json_encode($data);
  }

  public function getGenerateKd()
  {
    $data = $this->Um->getKd();

    echo json_encode($data);
  }

  public function add()
  {
    $userid   = $this->session->userdata('id');
    $kryid    = $this->input->post('id');
    $countid  = count($this->input->post('id'));
    $kd       = $this->input->post('kd');
    $nominal  = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $total    = preg_replace("/[^0-9\.]/", "", $this->input->post('total'));

    $data  = [
      'kd_um'         => $kd,
      'jml_penerima'  => $countid,
      'jml_nominal'   => $total,
      'user_id'       => $userid,
      'dateAdd'       => date('Y-m-d H:i:s'),
    ];

    $detail = [];

    for ($i = 0; $i < $countid; $i++) {
      array_push($detail, ['karyawan_id'  => $kryid[$i]]);
      $detail[$i]['kd_um']        = $kd;
      $detail[$i]['nominal']      = $nominal[$i];
    }

    $proses = $this->Um->addData($data, $detail);

    if ($proses) {
      $response = [
        'kd_um'   => $kd,
        'status'  => 'success',
        'text'    => 'Data Berhasil Ditambahkan'
      ];
    } else {
      $response = [
        'kd_um'   => null,
        'status'  => 'error',
        'text'    => 'Data Gagal Ditambahkan'
      ];
    }

    echo json_encode($response);
  }

  public function getDetailkd()
  {
    $kd   = $this->input->post('kd');
    $data = $this->Um->getDetailKd($kd);

    echo json_encode($data);
  }

  public function getDetailData()
  {
    $kd = $this->input->post('kd');

    $response = [
      'data'    => $this->Um->getDataByKd($kd),
      'detail'  => $this->Um->getDetailByKd($kd)
    ];

    echo json_encode($response);
  }

  public function print($kd)
  {
    $date = date('d/F/Y');

    $data = [
      'title'     => 'List Uang Makan',
      'dataum'    => $this->Um->getDataByKd($kd),
      'detailum'  => $this->Um->getDetailByKd($kd)
    ];

    $content  = $this->load->view('layout/adm/uang-makan/print', $data, true);

    $mpdf = new Mpdf([
      'mode'          => 'utf-8',
      'format'        => 'A4',
      'orientation'   => 'P',
      'SetTitle'      => "list-uang-makan-$date",
      'margin_left'   => 10,
      'margin_right'  => 10,
      'margin_top'    => 10,
      'margin_bottom' => 10,
    ]);

    $mpdf->SetHTMLFooter("<p class='page-number-footer'>list uangmakan $date | halaman {PAGENO} dari {nb}</p>");
    $mpdf->AddPage();
    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }

  public function delete()
  {
    $kd   = $this->input->post('kd');
    $data = $this->Um->deleteData($kd);

    echo json_encode($data);
  }
}
