<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Order extends CI_Model
{
  public function getKd()
  {
    $this->db->select('RIGHT(order_masuk.no_order,3) as no_order', FALSE)
      ->order_by('no_order', 'DESC')
      ->limit(1);

    $query = $this->db->get('order_masuk');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->no_order) + 1;
    } else {
      $kode = 1;
    }

    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "orm-" . $batas;

    return $kodetampil;
  }

  public function getData()
  {
    $this->datatables->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->join('customer cust', 'cust.id = om.customer_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="http://localhost/hira-to-adm/order/print/$2" target="_blank" class="btn btn-sm btn-info text-white border border-light btn-print" data-kd="$2" data-toggle="tooltip" title="Cetak">
            <i class="fas fa-print fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-kd="$2" data-toggle="tooltip" title="Detail">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="$2" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="$2" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, no_order, asal_order, tujuan_order, jenis_muatan, status_order, dateAdd, nama'
      );

    return $this->datatables->generate();
  }

  public function countData()
  {
    return $this->db->get('order_masuk')->num_rows();
  }

  public function getOrderId($kd)
  {
    $this->db->select('id as order_id, no_order')
      ->from('order_masuk ')
      ->where('no_order', $kd);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDataByKd($kd)
  {
    $this->db->select('om.id as order_id, om.no_order, om.customer_id, om.asal_order, om.tujuan_order, om.kontak_order, om.jenis_muatan, om.keterangan, ss.truck_id, ss.sopir_id, ss.nominal')
      ->from('order_masuk om')
      ->where('om.no_order', $kd)
      ->join('sangu_sopir ss', 'ss.no_order = om.no_order');

    $query = $this->db->get()->row();

    return $query;
  }

  public function getOrderDisiapkan()
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->where('om.status_order =', 'disiapkan')
      ->join('customer cust', 'cust.id = om.customer_id');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getSearchOrderDisiapkan($keyword)
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->where('om.status_order =', 'disiapkan')
      ->join('customer cust', 'cust.id = om.customer_id')
      ->like('om.no_order', $keyword);;

    $query = $this->db->get()->result();

    return $query;
  }

  public function getOrderPenjualan()
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->join('customer cust', 'cust.id = om.customer_id');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getSearchOrderPenjualan($keyword)
  {
    $this->db->select('om.id, om.no_order, om.asal_order, om.tujuan_order, om.jenis_muatan, om.status_order, om.keterangan, om.dateAdd, cust.nama')
      ->from('order_masuk om')
      ->join('customer cust', 'cust.id = om.customer_id')
      ->like('om.no_order', $keyword);;

    $query = $this->db->get()->result();

    return $query;
  }

  public function printOrder($kd)
  {
    $this->db->select('om.id as order_id, om.no_order, om.asal_order, om.tujuan_order, om.kontak_order, om.jenis_muatan, om.keterangan, om.dateAdd, cust.nama as nama_customer, ss.nominal, ss.tambahan, ar.platno, so.nama as nama_sopir')
      ->from('order_masuk om')
      ->where('om.no_order', $kd)
      ->join('customer cust', 'cust.id = om.customer_id')
      ->join('sangu_sopir ss', 'ss.no_order = om.no_order')
      ->join('armada ar', 'ar.id = ss.truck_id')
      ->join('sopir so', 'so.id = ss.sopir_id');

    $query = $this->db->get()->row();

    return $query;
  }

  public function addData($dataorder, $datasangu)
  {
    $this->db->insert('order_masuk', $dataorder);
    $this->db->insert('sangu_sopir', $datasangu);
  }

  public function updateData($dataorder, $datasangu, $where)
  {
    $this->db->update('order_masuk', $dataorder, $where);
    $this->db->update('sangu_sopir', $datasangu, $where);
  }

  public function deleteData($kd)
  {
    $this->db->delete('order_masuk', ['no_order' => $kd]);
    $this->db->delete('sangu_sopir', ['no_order' => $kd]);

    $this->db->select('no_order')
      ->from('penjualan')
      ->where('no_order', $kd);

    $query = $this->db->get()->row();

    if ($query == !null) {
      $this->db->delete('penjualan', ['no_order' => $kd]);
    }
  }
}
