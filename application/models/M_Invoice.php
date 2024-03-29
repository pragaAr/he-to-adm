<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Invoice extends CI_Model
{
  public function getKd()
  {
    $this->db->select('LEFT(invoice.kd_inv,3) as kd_inv', FALSE);
    $this->db->order_by('kd_inv', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('invoice');
    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kd_inv) + 1;
    } else {
      $kode = 1;
    }
    $batas = str_pad($kode, 3, "0", STR_PAD_LEFT);
    $kodetampil = $batas . "-han-" . date('d') . "-" . date('y');
    return $kodetampil;
  }

  public function getDataKd($no)
  {
    $this->db->select('invoice.kd_inv, invoice.nama_cust, invoice.jml_nominal, invoice.dateAdd');
    $this->db->from('invoice');
    $this->db->where('invoice.kd_inv', $no);
    $query = $this->db->get()->row();
    return $query;
  }

  public function getData()
  {
    return $this->db->get('invoice')->result();
  }

  public function getCustKd($kd)
  {
    $this->db->select('kd_inv, nama_cust, jml_nominal');
    $this->db->from('invoice');
    $this->db->where('kd_inv', $kd);
    $query = $this->db->get()->row();
    return $query;
  }

  public function getDetailInv($kd)
  {
    $this->db->select('detail_inv.kd_inv, detail_inv.no_order, detail_inv.surat_jalan, invoice.kd_inv, invoice.dateAdd, penjualan.no_order, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.berat, penjualan.harga_kg, penjualan.total_harga, sangu_order.no_order, sangu_order.platno');
    $this->db->from('detail_inv');
    $this->db->where('detail_inv.kd_inv', $kd);
    $this->db->join('invoice', 'invoice.kd_inv = detail_inv.kd_inv');
    $this->db->join('penjualan', 'penjualan.no_order = detail_inv.no_order');
    $this->db->join('sangu_order', 'sangu_order.no_order = detail_inv.no_order');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getDetailKd($no)
  {
    $this->db->select('detail_inv.kd_inv, detail_inv.no_order, detail_inv.surat_jalan, invoice.kd_inv, invoice.dateAdd, penjualan.no_order, penjualan.total_harga, sangu_order.no_order, sangu_order.platno');
    $this->db->from('detail_inv');
    $this->db->where('detail_inv.kd_inv', $no);
    $this->db->join('invoice', 'invoice.kd_inv = detail_inv.kd_inv');
    $this->db->join('penjualan', 'penjualan.no_order = detail_inv.no_order');
    $this->db->join('sangu_order', 'sangu_order.no_order = detail_inv.no_order');
    $query = $this->db->get()->result();
    return $query;
  }

  public function addData($data, $detail, $dateInv)
  {
    $this->db->insert('invoice', $data);
    $this->db->insert_batch('detail_inv', $detail);
    $this->db->update_batch('penjualan', $dateInv, 'no_order');
  }

  public function updateData($kd, $data, $detail)
  {
    $where = array(
      'kd_inv'   => $kd
    );

    $this->db->update('invoice', $data, $where);
    $this->db->delete('detail_inv', $where);
    $this->db->insert_batch('detail_inv', $detail);
  }

  public function deleteData($kd)
  {
    $this->db->select('no_order');
    $this->db->from('detail_inv');
    $this->db->where('kd_inv', $kd);
    $query = $this->db->get()->result();

    foreach ($query as $val) {
      $data[] = $val->no_order;
    }

    $sumdata = count($data);

    $dateInv = [];

    for ($i = 0; $i < $sumdata; $i++) {
      array_push($dateInv, ['no_order'   => $data[$i]]);
      $dateInv[$i]['invAdd']      = null;
    }

    $this->db->select('no_order');
    $this->db->from('penjualan');
    $this->db->where_in('no_order', $data);
    $this->db->update_batch('penjualan', $dateInv, 'no_order');

    $this->db->delete('invoice', ['kd_inv' => $kd]);
    $this->db->delete('detail_inv', ['kd_inv' => $kd]);
  }
}
