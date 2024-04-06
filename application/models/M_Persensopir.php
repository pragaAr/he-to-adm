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
          <a href="http://localhost/hira-to-adm/order/print/$2" target="_blank" class="btn btn-sm btn-info text-white border border-light btn-print" data-kd="$2" data-toggle="tooltip" title="Cetak">
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

  public function getId($kd)
  {
    $this->db->select('persensopir.kd_persen, persensopir.sopir_id, persensopir.nominal, persensopir.dateAdd, sopir.id_sopir, sopir.nama_sopir');
    $this->db->from('persensopir');
    $this->db->where('persensopir.kd_persen', $kd);
    $this->db->join('sopir', 'sopir.id_sopir = persensopir.sopir_id');
    $res = $this->db->get()->result();
    return $res;
  }

  public function addData($data, $detail, $dataOrder)
  {
    $this->db->insert('persen_sopir', $data);
    $this->db->insert_batch('detail_ps', $detail);
    $this->db->update_batch('order_masuk', $dataOrder, 'no_order');
  }

  public function deleteData($kd, $updateOrder)
  {
    $this->db->delete('persen_sopir', ['kd' => $kd]);
    $this->db->delete('detail_ps', ['kd' => $kd]);

    $this->db->update_batch('order_masuk', $updateOrder, 'no_order');
  }
}
