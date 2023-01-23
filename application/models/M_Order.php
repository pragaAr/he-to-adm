<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Order extends CI_Model
{
  public function getKd()
  {
    $this->db->select('RIGHT(order_masuk.no_order,3) as no_order', FALSE);
    $this->db->order_by('no_order', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('order_masuk');
    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->no_order) + 1;
    } else {
      $kode = 1;
    }
    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "0" . $batas;
    return $kodetampil;
  }

  public function getData()
  {
    return $this->db->get('order_masuk')->result();
  }

  public function countData()
  {
    return $this->db->get('order_masuk')->num_rows();
  }

  public function getNoOrder($no)
  {
    $this->db->select('*');
    $this->db->from('order_masuk');
    $this->db->where('order_masuk.no_order', $no);
    $this->db->join('sangu_order', 'sangu_order.no_order = order_masuk.no_order');
    // $this->db->join('sopir', 'sopir.id_sopir = sangu_order.sopir_id');
    $query = $this->db->get()->row();
    return $query;
  }

  public function getDataPenjualanNull()
  {
    $this->db->select('*');
    $this->db->from('order_masuk');
    $this->db->where('penjualanAdd =', null);
    $query = $this->db->get()->result();
    return $query;
  }

  public function getOrderNo($no)
  {
    $this->db->select('*');
    $this->db->from('order_masuk');
    $this->db->where('order_masuk.no_order', $no);
    $query = $this->db->get()->row();
    return $query;
  }

  public function addData()
  {
    $noorder        = $this->input->post('noorder');
    $namacust       = $this->input->post('namacust');
    $alamatasal     = $this->input->post('alamatasal');
    $alamattujuan   = $this->input->post('alamattujuan');
    $notelp         = $this->input->post('notelp');
    $muatan         = $this->input->post('muatan');
    $asal           = $this->input->post('kotaasal');
    $platno         = $this->input->post('platno');
    $supir          = $this->input->post('sopir');
    $tujuan         = $this->input->post('kotatujuan');
    $nominal        = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $user           = 1;
    $dateAdd        = date('Y-m-d H:i:s');

    $data = array(
      'no_order'      => strtolower($noorder),
      'nama_cust'     => strtolower($namacust),
      'alamat_asal'   => strtolower($alamatasal),
      'alamat_tujuan' => strtolower($alamattujuan),
      'notelp_cust'   => strtolower($notelp),
      'jenis_muatan'  => strtolower($muatan),
      'user_id'       => $user,
      'dateAdd'       => $dateAdd
    );

    $datasangu = array(
      'no_rek'        => '610101',
      'no_order'      => strtolower($noorder),
      'platno'        => strtolower($platno),
      'sopir_id'      => $supir,
      'kota_asal'     => strtolower($asal),
      'kota_tujuan'   => strtolower($tujuan),
      'nominal'       => strtolower($nominal),
      'user_id'       => $user,
      'dateAdd'       => $dateAdd
    );

    $this->db->insert('order_masuk', $data);
    $this->db->insert('sangu_order', $datasangu);
  }

  public function editData($no)
  {
    $namacust       = $this->input->post('namacust');
    $alamatasal     = $this->input->post('alamatasal');
    $alamattujuan   = $this->input->post('alamattujuan');
    $notelp         = $this->input->post('notelp');
    $muatan         = $this->input->post('muatan');
    $asal           = $this->input->post('kotaasal');
    $platno         = $this->input->post('platno');
    $supir          = $this->input->post('sopir');
    $tujuan         = $this->input->post('kotatujuan');
    $nominal        = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $user           = 1;

    $data = array(
      'nama_cust'     => strtolower($namacust),
      'alamat_asal'   => strtolower($alamatasal),
      'alamat_tujuan' => strtolower($alamattujuan),
      'notelp_cust'   => strtolower($notelp),
      'jenis_muatan'  => strtolower($muatan),
      'user_id'       => $user,
    );

    $datasangu = array(
      'platno'        => strtolower($platno),
      'sopir_id'      => $supir,
      'kota_asal'     => strtolower($asal),
      'kota_tujuan'   => strtolower($tujuan),
      'nominal'       => strtolower($nominal),
      'tambahan'      => 0,
      'user_id'       => $user,
    );

    $datapenjualan = array(
      'pengirim'        => strtolower($namacust),
      'alamat_asal'     => strtolower($alamatasal),
      'alamat_tujuan'   => strtolower($alamattujuan),
    );

    $where = array('no_order' => $no);

    $this->db->update('order_masuk', $data, $where);
    $this->db->update('sangu_order', $datasangu, $where);
    $this->db->update('penjualan', $datapenjualan, $where);
  }

  public function deleteData($no)
  {
    $this->db->delete('order_masuk', ['no_order' => $no]);
    $this->db->delete('sangu_order', ['no_order' => $no]);

    $this->db->select('no_order');
    $this->db->from('penjualan');
    $this->db->where('no_order', $no);
    $query = $this->db->get()->row();

    if ($query == !null) {
      $this->db->delete('penjualan', ['no_order' => $no]);
    }
  }
}
