<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Penjualan extends CI_Model
{
  public function getData()
  {
    return $this->db->get('penjualan')->result();
  }

  public function countData()
  {
    return $this->db->get('penjualan')->num_rows();
  }

  public function getNoOrder($no)
  {
    return $this->db->get_where('penjualan', ['no_order' => $no])->row();
  }

  public function getNoOrderPenjualan($no)
  {
    return $this->db->get_where('penjualan', ['no_order' => $no])->row();
  }

  public function getPlatPenjualan($no)
  {
    $this->db->select('platno');
    $this->db->from('sangu_order');
    $this->db->where('no_order', $no);
    $query = $this->db->get()->row();
    return $query;
  }

  public function getDataCust()
  {
    $this->db->select('DiSTINCT(pengirim)');
    $this->db->from('penjualan');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getOrderCust($post)
  {
    $this->db->select('no_order');
    $this->db->from('penjualan');
    $this->db->where('pengirim', $post);
    $this->db->where('pembayaran=', "tempo");

    $query = $this->db->get()->result();
    return $query;
  }

  public function getDataOrderCust($no)
  {
    $this->db->select('penjualan.no_order, penjualan.surat_jalan, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.berat, penjualan.harga_kg, penjualan.total_harga, penjualan.dateAdd, sangu_order.no_order, sangu_order.platno');
    $this->db->from('penjualan');
    $this->db->where('penjualan.no_order', $no);
    $this->db->join('sangu_order', 'sangu_order.no_order = penjualan.no_order');
    $query = $this->db->get()->row();
    return $query;
  }


  public function addData()
  {
    $userid           = $this->session->userdata('id_user');

    $noorder          = $this->input->post('noorderpenjualan');
    $nosj             = trim($this->input->post('nosj'));
    $jenisnota        = $this->input->post('jenispenjualan');
    $jenisbarng       = $this->input->post('muatan');
    $beratbrg         = $this->input->post('berat');
    $hrgborong        = preg_replace("/[^0-9\.]/", "", $this->input->post('borongan'));
    $hrgton           = preg_replace("/[^0-9\.]/", "", $this->input->post('tonase'));
    $pengirim         = $this->input->post('pengirim');
    $kotaasal         = trim($this->input->post('kotaasal'));
    $alamatpengirim   = trim($this->input->post('alamatpengirim'));
    $penerima         = trim($this->input->post('penerima'));
    $kotatujuan       = trim($this->input->post('kotatujuan'));
    $alamatpenerima   = trim($this->input->post('alamatpenerima'));
    $totalbiaya       = preg_replace("/[^0-9\.]/", "", $this->input->post('totalbiaya'));
    $pembayaran       = $this->input->post('pembayaran');
    $dateAdd          = date('Y-m-d H:i:s');

    $data = array(
      'no_order'            => strtolower($noorder),
      'surat_jalan'         => strtolower($nosj),
      'jenis_penjualan'     => strtolower($jenisnota),
      'muatan'              => strtolower($jenisbarng),
      'berat'               => strtolower($beratbrg),
      'harga_borong'        => $hrgborong,
      'harga_kg'            => $hrgton,
      'pengirim'            => strtolower($pengirim),
      'kota_asal'           => strtolower($kotaasal),
      'alamat_asal'         => strtolower($alamatpengirim),
      'penerima'            => strtolower($penerima),
      'kota_tujuan'         => strtolower($kotatujuan),
      'alamat_tujuan'       => strtolower($alamatpenerima),
      'total_harga'         => $totalbiaya,
      'pembayaran'          => strtolower($pembayaran),
      'user_id'             => $userid,
      'dateAdd'             => $dateAdd,
    );

    $dataorder = array(
      'penjualanAdd'    => $dateAdd,
    );

    $where = array(
      'no_order'    => $noorder
    );

    $this->db->update('order_masuk', $dataorder, $where);
    $this->db->insert('penjualan', $data);
  }

  public function editData($no)
  {
    $userid           = $this->session->userdata('id_user');
    $nosj             = trim($this->input->post('editnosj'));
    $jenisnota        = $this->input->post('editjenispenjualan');
    $jenisbarng       = $this->input->post('editmuatan');
    $beratbrg         = $this->input->post('editberat');
    $hrgborong        = preg_replace("/[^0-9\.]/", "", $this->input->post('editborongan'));
    $hrgton           = preg_replace("/[^0-9\.]/", "", $this->input->post('edittonase'));
    $kotaasal         = trim($this->input->post('editkotaasal'));
    $penerima         = trim($this->input->post('editpenerima'));
    $kotatujuan       = trim($this->input->post('editkotatujuan'));
    $totalbiaya       = preg_replace("/[^0-9\.]/", "", $this->input->post('edittotalbiaya'));
    $pembayaran       = $this->input->post('editpembayaran');

    $data = array(
      'surat_jalan'         => strtolower($nosj),
      'jenis_penjualan'     => strtolower($jenisnota),
      'muatan'              => strtolower($jenisbarng),
      'berat'               => strtolower($beratbrg),
      'harga_borong'        => $hrgborong,
      'harga_kg'            => $hrgton,
      'kota_asal'           => strtolower($kotaasal),
      'penerima'            => strtolower($penerima),
      'kota_tujuan'         => strtolower($kotatujuan),
      'total_harga'         => $totalbiaya,
      'pembayaran'          => strtolower($pembayaran),
      'user_id'             => $userid,
    );

    $where = array(
      'no_order'    => $no
    );

    $this->db->update('penjualan', $data, $where);
  }

  public function deleteData($no)
  {
    $dataorder = array(
      'penjualanAdd'    => null,
    );

    $where = array(
      'no_order'    => $no
    );

    $this->db->delete('penjualan', ['no_order' => $no]);
    $this->db->update('order_masuk', $dataorder, $where);
  }
}
