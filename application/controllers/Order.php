<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

use Mpdf\Mpdf;

class Order extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('datatables');

    $this->load->model('M_Order', 'Order');

    if (empty($this->session->userdata('id'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title'] = 'Data Order';

    $this->load->view('layout/template/header', $data);
    $this->load->view('layout/template/navbar');
    $this->load->view('layout/template/sidebar');
    $this->load->view('layout/trans/order/index', $data);
    $this->load->view('layout/template/footer');
  }

  public function getKdOrder()
  {
    $data = $this->Order->getKd();

    echo json_encode($data);
  }

  public function getOrder()
  {
    header('Content-Type: application/json');

    echo $this->Order->getData();
  }

  public function getDataKd()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Order->getDataByKd($kd);

    echo json_encode($data);
  }

  public function getListOrder()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Order->getOrderDisiapkan() : $this->Order->getSearchOrderDisiapkan($keyword);

    $response = [];
    foreach ($data as $order) {
      $response[] = [
        'id'      => $order->id,
        'text'    => strtoupper($order->no_order),
        'cust'    => strtoupper($order->nama),
        'asal'    => strtoupper($order->asal_order),
        'tujuan'  => strtoupper($order->tujuan_order),
        'muatan'  => strtoupper($order->jenis_muatan),
        'ket'     => strtoupper($order->keterangan),
        'tgl'     => date('d-m-Y', strtotime(($order->dateAdd))),
      ];
    }

    echo json_encode($response);
  }

  public function getListOrderPenjualan()
  {
    $keyword = $this->input->get('q');

    $data = !$keyword ? $this->Order->getOrderPenjualan() : $this->Order->getSearchOrderPenjualan($keyword);

    $response = [];
    foreach ($data as $order) {
      $response[] = [
        'id'      => $order->id,
        'text'    => strtoupper($order->no_order),
        'cust'    => strtoupper($order->nama),
        'asal'    => strtoupper($order->asal_order),
        'tujuan'  => strtoupper($order->tujuan_order),
        'muatan'  => strtoupper($order->jenis_muatan),
        'ket'     => strtoupper($order->keterangan),
        'tgl'     => date('d-m-Y', strtotime(($order->dateAdd))),
      ];
    }

    echo json_encode($response);
  }

  public function getId()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Order->getOrderId($kd);

    echo json_encode($data);
  }

  public function getDetail()
  {
    $kd   = $this->input->post('kd');

    $data = $this->Order->printOrder($kd);

    echo json_encode($data);
  }

  public function add()
  {
    $noorder      = strtolower($this->input->post('ordernumber'));
    $custid       = $this->input->post('custid');
    // $namecust     = strtolower($this->input->post('namecust'));
    $notelp       = $this->input->post('notelp');
    $asal         = strtolower($this->input->post('asal'));
    $tujuan       = strtolower($this->input->post('tujuan'));
    $muatan       = strtolower($this->input->post('muatan'));
    $keterangan   = strtolower($this->input->post('keterangan'));

    $plat         = $this->input->post('plat');
    // $platno       = strtolower($this->input->post('platno'));
    $sopir        = $this->input->post('sopir');
    // $namasopir    = strtolower($this->input->post('namasopir'));
    $nominal      = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));

    $user         = $this->session->userdata('id');
    $addAt        = date('Y-m-d H:i:s');

    $dataorder = [
      'no_order'      => $noorder,
      'customer_id'   => $custid,
      'asal_order'    => $asal,
      'tujuan_order'  => $tujuan,
      'kontak_order'  => $notelp,
      'jenis_muatan'  => $muatan,
      'keterangan'    => $keterangan,
      'status_order'  => 'disiapkan',
      'user_id'       => $user,
      'dateAdd'       => $addAt,
    ];

    $datasangu = [
      'no_order'  => strtolower($noorder),
      'truck_id'  => $plat,
      'sopir_id'  => $sopir,
      'nominal'   => strtolower($nominal),
      'tambahan'  => '0',
      'user_id'   => $user,
      'dateAdd'   => $addAt
    ];

    $this->Order->addData($dataorder, $datasangu);

    $dataOrder = strtolower($noorder);

    echo json_encode($dataOrder);
  }

  public function update()
  {
    $noorder      = strtolower($this->input->post('ordernumber'));
    $custid       = $this->input->post('custid');
    // $namecust     = strtolower($this->input->post('namecust'));
    $notelp       = $this->input->post('notelp');
    $asal         = strtolower($this->input->post('asal'));
    $tujuan       = strtolower($this->input->post('tujuan'));
    $muatan       = strtolower($this->input->post('muatan'));
    $keterangan   = strtolower($this->input->post('keterangan'));

    $plat         = $this->input->post('plat');
    // $platno       = strtolower($this->input->post('platno'));
    $sopir        = $this->input->post('sopir');
    // $namasopir    = strtolower($this->input->post('namasopir'));
    $nominal      = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));

    $dataorder = [
      'customer_id'   => $custid,
      'asal_order'    => $asal,
      'tujuan_order'  => $tujuan,
      'kontak_order'  => $notelp,
      'jenis_muatan'  => $muatan,
      'keterangan'    => $keterangan,
    ];

    $datasangu = [
      'truck_id'  => $plat,
      'sopir_id'  => $sopir,
      'nominal'   => strtolower($nominal),
    ];

    $where = [
      'no_order' => $noorder
    ];

    $response = $this->Order->updateData($dataorder, $datasangu, $where);

    echo json_encode($response);
  }

  public function delete()
  {
    $kd = $this->input->post('kd');

    $response = $this->Order->deleteData($kd);

    echo json_encode($response);
  }

  public function print($kd)
  {
    $data = [
      'title'   => 'Hira TO - Print Order',
      'detail'  => $this->Order->printOrder($kd)
    ];

    $content  = $this->load->view('layout/trans/order/print', $data, true);

    $mpdf = new Mpdf([
      'mode'          => 'utf-8',
      'format'        => 'A4',
      'orientation'   => 'P',
      'SetTitle'      => "order-$kd",
      'margin_left'   => 10,
      'margin_right'  => 10,
      'margin_top'    => 10,
      'margin_bottom' => 10,
    ]);

    $mpdf->AddPage();
    $mpdf->WriteHTML($content);

    $mpdf->Output();
  }
}
