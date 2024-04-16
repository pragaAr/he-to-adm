<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

use function PHPUnit\Framework\isNull;

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
    $userid   = $this->session->userdata('id');
    $countRow = count($this->input->post('sj'));
    $rc       = $this->input->post('rc');
    $sj       = $this->input->post('sj');
    $custid   = $this->input->post('pengirim');
    $cust     = strtolower($this->input->post('selectedCust'));
    $ket      = $this->input->post('ket');
    $berat    = $this->input->post('valberat');
    $retur    = $this->input->post('valretur');
    $dateAdd  = date('Y-m-d H:i:s');
    $tipe     = 'surat_jalan';
    $month    = date('m');
    $querynomor = $this->SJ->generateNomorSuratJalan($cust, $tipe);

    $inisial  = $this->getInitials($cust);
    $romawi   = $this->bulanRomawi($month);

    $nomor = $inisial . '/' . $querynomor . '/han/' . $romawi . '/' . date('y');

    $datasj = [
      'nomor_sj'  => '',
      'cust_id'   => $custid,
      'jml_reccu' => $countRow,
      'jml_sj'    => $countRow,
      'ket'       => strtolower($ket),
      'dateAdd'   => $dateAdd,
      'user_id'   => $userid,
    ];

    $datadt = [];

    for ($i = 0; $i < $countRow; $i++) {
      array_push($datadt, ['nomor_sj' => '']);
      $datadt[$i]['reccu']        = $rc[$i];
      $datadt[$i]['surat_jalan']  = $sj[$i];
      $datadt[$i]['berat']        = $berat[$i];
      $datadt[$i]['retur']        = $retur[$i];
    }

    // $proses = $this->SJ->addData($datasj, $datadt);

    // if ($proses) {
    //   $response = [
    //     'status'  => 'success',
    //     'title'   => 'Success',
    //     'text'    => 'Data Berhasil Ditambahkan'
    //   ];
    // } else {
    //   $response = [
    //     'status'  => 'error',
    //     'title'   => 'Error',
    //     'text'    => 'Data Gagal Ditambahkan'
    //   ];
    // }

    // echo json_encode($response);
    echo json_encode($nomor);
  }

  function getInitials($nama)
  {
    $words = explode(" ", $nama);
    $initials = '';

    foreach ($words as $word) {
      if (strpos($word, "pt.") !== false || strpos($word, "pt") !== false || strpos($word, "cv.") !== false || strpos($word, "cv") !== false || strpos($word, "ud.") !== false || strpos($word, "ud") !== false) {
        continue;
      }
      $initials .= substr($word, 0, 1);
    }

    return $initials;
  }

  function bulanRomawi($month)
  {
    switch ($month) {
      case 1:
        return 'i';
      case 2:
        return 'ii';
      case 3:
        return 'iii';
      case 4:
        return 'iv';
      case 5:
        return 'v';
      case 6:
        return 'vi';
      case 7:
        return 'vii';
      case 8:
        return 'viii';
      case 9:
        return 'ix';
      case 10:
        return 'x';
      case 11:
        return 'xi';
      case 12:
        return 'xii';
      default:
        return '';
    }
  }

  public function print()
  {
    $cust             = $this->input->post('ttcustname');
    $reccu            = $this->input->post('ttreccu[]');
    $jenis            = $this->input->post('jenis');
    $dpp              = $this->input->post('dpp');
    $valJenis         = preg_replace('/-/', ' ', $jenis);
    $nomor = "36/HAN/XII/23";

    $data['title']    = $valJenis . ' ' . $cust;
    $data['nomor']    = $nomor;
    $data['rc']       = $this->SJ->getTandaTerimaData($reccu);
    $data['dt']       = $this->SJ->getDetailData($reccu);
    $data['dpp']      = $dpp;

    $mpdf = new Mpdf([
      'mode'          => 'utf-8',
      'format'        => 'A4',
      'orientation'   => 'P',
      'SetTitle'      => $jenis,
      'margin_left'   => 5,
      'margin_right'  => 5,
      'margin_top'    => 5,
      'margin_bottom' => 5,
    ]);

    if ($jenis === 'tanda-terima-surat-jalan') {

      $content  = $this->load->view('layout/trans/surat-jalan/print', $data, true);

      $mpdf->SetHTMLFooter("<p class='page-number-footer'>Tanda Terima Surat Jalan ( $nomor ) | Halaman {PAGENO} Dari {nb}</p>");
      $mpdf->AddPage();
      $mpdf->WriteHTML($content);

      $mpdf->Output();
    } else if ($jenis === 'invoice') {

      $content  = $this->load->view('layout/trans/surat-jalan/print-invoice', $data, true);

      $mpdf->SetHTMLFooter("<p class='page-number-footer'>Invoice ( $nomor ) | Halaman {PAGENO} Dari {nb}</p>");
      $mpdf->AddPage();
      $mpdf->WriteHTML($content);

      $mpdf->Output();
    } else {
      echo 'data tidak valid, silahkan pilih jenis dokumen';
    }
  }

  public function delete()
  {
    $reccu = $this->input->post('reccu');

    $data = $this->SJ->deleteData($reccu);

    echo json_encode($data);
  }
}
