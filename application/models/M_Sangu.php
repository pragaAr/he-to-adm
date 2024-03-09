<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Sangu extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('ss.id, ss.no_order, ss.nominal, ss.tambahan, ss.dateAdd, s.nama, ar.platno')
      ->from('sangu_sopir ss')
      ->join('sopir s', 's.id = ss.sopir_id')
      ->join('armada ar', 'ar.id = ss.truck_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
         <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="$2" data-toggle="tooltip" title="Detail">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="$2" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
        </div>',
        'id, no_order, platno, nama, nominal, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function getDataByKd($kd)
  {
    $this->db->select('ss.id, ss.no_order, ss.nominal, ss.tambahan, ar.platno, s.nama')
      ->from('sangu_sopir ss')
      ->where('ss.no_order', $kd)
      ->join('sopir s', 's.id = ss.sopir_id')
      ->join('armada ar', 'ar.id = ss.truck_id');

    $res = $this->db->get()->row();

    return $res;
  }

  public function getOrderSopir($sopir)
  {
    $this->db->select('sangu_order.no_order, sangu_order.sopir_id, order_masuk.no_order, penjualan.no_order');
    $this->db->from('sangu_order');
    $this->db->where('sangu_order.sopir_id', $sopir);
    $this->db->join('order_masuk', 'order_masuk.no_order = sangu_order.no_order');
    $this->db->join('penjualan', 'penjualan.no_order = sangu_order.no_order');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getPlatByOrder($kd)
  {
    $this->db->select('armada.platno')
      ->from('sangu_sopir')
      ->where('no_order', $kd)
      ->join('armada', 'armada.id = sangu_sopir.truck_id');

    $query = $this->db->get()->row();

    return $query;
  }

  public function getNoOrder($no)
  {
    $this->db->select('*');
    $this->db->from('sangu_order');
    $this->db->where('no_order', $no);
    $this->db->join('sopir', 'sopir.id_sopir = sangu_order.sopir_id');
    $res = $this->db->get()->row();
    return $res;
  }

  public function editData($data, $where)
  {
    return $this->db->update('sangu_sopir', $data, $where);
  }
}
