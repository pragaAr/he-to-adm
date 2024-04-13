<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Persensopir extends CI_Model
{
  public function getKd()
  {
    $this->db->select('RIGHT(persen_sopir.kd,3) as kd', FALSE);
    $this->db->order_by('kd', 'DESC');
    $this->db->limit(1);

    $query = $this->db->get('persen_sopir');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kd) + 1;
    } else {
      $kode = 1;
    }

    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "ps-" . $batas;

    return $kodetampil;
  }

  public function getData()
  {
    $this->datatables->select('ps.id, ps.kd, s.nama, ps.jml_order, ps.total_diterima, ps.dateAdd')
      ->from('persen_sopir ps')
      ->join('sopir s', 's.id = ps.sopir_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="http://localhost/hira-to-adm/persensopir/printDataPersen/$2" target="_blank" class="btn btn-sm btn-info text-white border border-light btn-print" data-kd="$2" data-toggle="tooltip" title="Cetak">
            <i class="fas fa-print fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="$2" data-toggle="tooltip" title="Detail">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="$2" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, kd, nama, jml_order, total_diterima, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function getDataDetailPersenByKd($kd)
  {
    $this->db->select('no_order')
      ->from('detail_ps')
      ->where('kd', $kd);

    $query = $this->db->get()->result_array();

    return $query;
  }

  public function dataPersenByKd($kd)
  {
    $this->db->select('a.kd, a.no_order, a.platno, a.persen1, a.persen2, a.tot_biaya, a.tot_sangu, a.diterima')
      ->from('detail_ps a')
      ->where('a.kd', $kd);

    $res = $this->db->get()->result();

    return $res;
  }

  public function getDataOrderPersenByKdPersen($kd)
  {
    $this->db->select('a.persen1, a.persen2, a.tot_biaya, b.dateAdd as tglOrder, c.nama')
      ->from('detail_ps a')
      ->where('a.kd', $kd)
      ->join('order_masuk b', 'b.no_order = a.no_order')
      ->join('customer c', 'c.id = b.customer_id');

    $res = $this->db->get()->result();

    return $res;
  }

  public function getDataSanguOrderByKdPersen($kd)
  {
    $this->db->select('b.nominal as nominal_sangu, b.tambahan, b.dateAdd as tglSangu, b.dateTambahanAdd as tglTambahan, d.nama')
      ->from('detail_ps a')
      ->where('a.kd', $kd)
      ->join('sangu_sopir b', 'b.no_order = a.no_order')
      ->join('order_masuk c', 'c.no_order = b.no_order')
      ->join('customer d', 'd.id = c.customer_id');

    $res = $this->db->get()->result();

    return $res;
  }

  public function getSopirByKdPersen($kd)
  {
    $this->db->select('b.nama')
      ->from('persen_sopir a')
      ->where('a.kd', $kd)
      ->join('sopir b', 'b.id = a.sopir_id');

    $res = $this->db->get()->row();

    return $res;
  }

  public function addData($data, $detail, $dataOrder)
  {
    $query = $this->db->insert('persen_sopir', $data);
    $query = $this->db->insert_batch('detail_ps', $detail);
    $query = $this->db->update_batch('order_masuk', $dataOrder, 'no_order');

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function deleteData($kd, $updateOrder)
  {
    $this->db->delete('persen_sopir', ['kd' => $kd]);
    $this->db->delete('detail_ps', ['kd' => $kd]);

    $this->db->update_batch('order_masuk', $updateOrder, 'no_order');
  }
}
