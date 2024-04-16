<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Penjualan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Sangu', 'Sangu');
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
    $this->load->view('layout/trans/penjualan/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getReccu()
  {
    $data = $this->Sales->generateReccu();

    echo json_encode($data);
  }

  public function getPenjualan()
  {
    header('Content-Type: application/json');

    echo $this->Sales->getData();
  }

  public function getDataKd()
  {
    $kd   = $this->input->post('kd');
    $data = $this->Sales->getDataByKd($kd);

    echo json_encode($data);
  }

  public function getOrderId()
  {
    $id   = $this->input->post('id');
    $data = $this->Sales->getDataOrderById($id);

    echo json_encode($data);
  }

  public function getListReccu()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Sales->getReccu() : $this->Sales->getSearchReccu($keyword);

    $response = [];

    foreach ($data as $reccu) {
      $response[] = [
        'id'        => $reccu->no_order,
        'text'      => strtoupper($reccu->reccu),
        'jenis'     => $reccu->jenis,
        'berat'     => $reccu->berat,
        'hrgkg'     => $reccu->hrg_kg,
        'hrgbrg'    => $reccu->hrg_borong,
        'totalhrg'  => $reccu->total_hrg,
        'pengirim'  => strtoupper($reccu->pengirim),
        'penerima'  => strtoupper($reccu->penerima),
      ];
    }

    echo json_encode($response);
  }

  public function getListReccuForTravelDoc()
  {
    $reccu = $this->input->post('reccu');

    $data = $this->Sales->getReccuForTravelDoc($reccu);

    echo json_encode($data);
  }

  public function getListCustomerReccu()
  {
    $cust = $this->input->post('cust');

    $data = $this->Sales->getDataCustomerReccu($cust);

    echo json_encode($data);
  }

  public function add()
  {
    $userid       = $this->session->userdata('id');
    $reccu        = trim($this->input->post('reccu'));
    $noorder      = trim($this->input->post('noorder'));
    $textnoorder  = trim($this->input->post('textnoorder'));
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
      'reccu'         => strtolower($reccu),
      'order_id'      => strtolower($noorder),
      'jenis'         => strtolower($jenis),
      'muatan'        => strtolower($muatan),
      'berat'         => strtolower($jenis) === 'borong' ? '0' : $berat,
      'hrg_borong'    => strtolower($jenis) === 'borong' ? $hrgborong : '0',
      'hrg_kg'        => strtolower($jenis) === 'borong' ? '0' : $hrgtonase,
      'pengirim'      => strtolower($pengirim),
      'kota_asal'     => strtolower($kotaasal),
      'alamat_asal'   => strtolower($alamatasal),
      'penerima'      => strtolower($penerima),
      'kota_tujuan'   => strtolower($kotatujuan),
      'alamat_tujuan' => strtolower($alamattujuan),
      'total_hrg'     => $biaya,
      'pembayaran'    => strtolower($pembayaran),
      'status'        => 'diproses',
      'user_id'       => $userid,
      'dateAdd'       => $dateAdd,
    );

    $dataorder = array(
      'status_order'  => 'diproses',
    );

    $where = array(
      'id'  => $noorder
    );

    $this->Sales->addData($data, $dataorder, $where);

    $dataReccu = strtolower($textnoorder);

    echo json_encode($dataReccu);
  }

  public function update()
  {
    $penjualanid  = $this->input->post('penjualanid');
    $noorder      = trim($this->input->post('noorder'));

    $jenis        = trim($this->input->post('jenis'));
    $berat        = trim($this->input->post('berat'));
    $hrgborong    = preg_replace("/[^0-9\.]/", "", $this->input->post('borong'));
    $hrgtonase    = preg_replace("/[^0-9\.]/", "", $this->input->post('tonase'));
    $penerima     = trim($this->input->post('penerima'));
    $alamatasal   = trim($this->input->post('alamatasal'));
    $alamattujuan = trim($this->input->post('alamattujuan'));
    $biaya        = preg_replace("/[^0-9\.]/", "", $this->input->post('biaya'));
    $pembayaran   = trim($this->input->post('pembayaran'));

    $data = array(
      'jenis'         => strtolower($jenis),
      'berat'         => strtolower($jenis) === 'borong' ? '0' : $berat,
      'hrg_borong'    => strtolower($jenis) === 'borong' ? $hrgborong : '0',
      'hrg_kg'        => strtolower($jenis) === 'borong' ? '0' : $hrgtonase,
      'alamat_asal'   => strtolower($alamatasal),
      'penerima'      => strtolower($penerima),
      'alamat_tujuan' => strtolower($alamattujuan),
      'total_hrg'     => $biaya,
      'pembayaran'    => strtolower($pembayaran),
    );

    $dataorder = array(
      'status_order'  => 'diproses',
    );

    $wherepenjualanid = array(
      'id'  => $penjualanid
    );

    $where = array(
      'no_order'  => $noorder
    );

    $data = $this->Sales->editData($data, $dataorder, $where, $wherepenjualanid);

    echo json_encode($data);
  }

  public function printAfterAddCopy($kd)
  {
    $data = [
      'title' => 'Hira Express - Print Reccu',
      'plat'  => $this->Sangu->getPlatByOrder($kd),
      'sales' => $this->Sales->getDataByKd($kd)
    ];

    $a = $data['sales']->pembayaran;
    $b = strtoupper($a);

    $content  = $this->load->view('layout/trans/penjualan/print', $data, true);

    $mpdf = new Mpdf([
      'mode'          => 'utf-8',
      'format'        => 'A6',
      'orientation'   => 'P',
      'SetTitle'      => "reccu-$kd",
      'margin_left'   => 4,
      'margin_right'  => 4,
      'margin_top'    => 4,
      'margin_bottom' => 3,
    ]);

    $mpdf->SetWatermarkText($b, 0.2);
    $mpdf->showWatermarkText = true;

    $mpdf->watermarkAngle = 0;

    $mpdf->AddPage();
    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }

  public function print($kd)
  {
    $this->load->library('pdf');

    $data = [
      'title' => 'Hira Express - Print Reccu',
      'plat'  => $this->Sangu->getPlatByOrder($kd),
      'sales' => $this->Sales->getDataByKd($kd)
    ];

    $this->pdf->generate('layout/trans/penjualan/print', $data, "Reccu-$kd", 'A6', 'portrait');
  }

  public function updateStatus()
  {
    $id = $this->input->post('id');
    $kd = $this->input->post('no');

    $query = $this->Sangu->getDataTrucSopirkByKdOrder($kd);

    $truckid = $query->truck_id;
    $sopirid = $query->sopir_id;

    $data = $this->Sales->updateStatusOrderPenjualan($id, $truckid, $sopirid);

    echo json_encode($data);
  }

  public function delete()
  {
    $id = $this->input->post('id');
    $no = $this->input->post('no');

    $data = $this->Sales->deleteData($id, $no);

    echo json_encode($data);
  }
}
