<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Armada', 'Armada');
    $this->load->model('M_Customer', 'Cust');
    $this->load->model('M_Order', 'Order');
    $this->load->model('M_Sopir', 'Sopir');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']      = 'Data Order';
    $data['cust']       = $this->Cust->getDataNama();
    $data['order']      = $this->Order->getData();
    $data['sopir']      = $this->Sopir->getData();
    $data['sopiredit']  = $this->Sopir->getData();
    $data['truck']      = $this->Armada->getData();
    $data['truckedit']  = $this->Armada->getData();
    $data['kd']         = $this->Order->getKd();

    $this->form_validation->set_rules('namacust', 'Nama Customer', 'trim|required');
    $this->form_validation->set_rules('notelp', 'No Telp Customer', 'trim|required');
    $this->form_validation->set_rules('alamatasal', 'Alamat Asal', 'trim|required');
    $this->form_validation->set_rules('alamattujuan', 'Alamat Tujuan', 'trim|required');
    $this->form_validation->set_rules('muatan', 'Muatan', 'trim|required');
    $this->form_validation->set_rules('platno', 'Plat No Truck', 'trim|required');
    $this->form_validation->set_rules('sopir', 'Supir', 'trim|required');
    $this->form_validation->set_rules('kotaasal', 'Kota Asal', 'trim|required');
    $this->form_validation->set_rules('kotatujuan', 'Kota Tujuan', 'trim|required');
    $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/trans/order', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->Order->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('order');
    }
  }

  public function getNoOrder()
  {
    $no   = $this->input->post('no_order');
    $data = $this->Order->getNoOrder($no);

    echo json_encode($data);
  }

  public function update()
  {
    $no = $this->input->post('noorder');
    $this->Order->editData($no);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('order');
  }

  public function printOrder()
  {
    $no = $this->input->post('noorderprint');

    $this->load->library('pdf');

    $data['title']    = 'Hira Express - Print Order';
    $data['detail']   = $this->Order->getNoOrder($no);

    $this->pdf->generate('print/print-order', $data, 'Data-Order', 'A4', 'portrait');
  }

  public function delete($no)
  {
    $this->Order->deleteData($no);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('order');
  }
}
