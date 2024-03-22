<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_Penjualan extends CI_Model
{
  public function generateReccu()
  {
    $last_code = $this->db->select('reccu')->order_by('reccu', 'DESC')->limit(1)->get('penjualan')->row('reccu');

    if (!$last_code) {
      return 'rc000075';
    }

    $last_number = (int)substr($last_code, 2);

    $next_number = str_pad($last_number + 1, 6, '0', STR_PAD_LEFT);

    $kode = 'rc' . $next_number;

    return $kode;
  }

  public function getData()
  {
    $this->datatables->select('p.id, p.reccu, p.order_id, om.no_order, om.dateAdd as tgl_order, p.jenis, p.muatan, p.berat, p.hrg_borong, p.hrg_kg, p.pengirim, p.kota_asal, p.alamat_asal, p.penerima, p.kota_tujuan, p.alamat_tujuan, p.total_hrg, p.pembayaran, p.status')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          
        </div>',
        'id, reccu, no_order, jenis, muatan, berat, hrg_borong, hrg_kg, pengirim, kota_asal, alamat_asal, penerima, kota_tujuan, alamat_tujuan, total_hrg, pembayaran, status, dateAdd'
      );

    $results = $this->datatables->generate();

    $data = json_decode($results, true);

    foreach ($data['data'] as &$row) {
      if ($row['status'] == 'diproses') {
        $row['view'] = '<div class="btn-group" role="group">
                            <a href="javascript:void(0);" class="btn btn-sm btn-secondary border border-light btn-detail" data-toggle="tooltip" title="Update Status" data-kd="' . $row['order_id'] . '">
                              <i class="fas fa-check fa-sm"></i>
                            </a>
                            <a href="http://localhost/hira-to-adm/penjualan/print/' . $row['no_order'] . '" target="_blank" class="btn btn-sm btn-info text-white border border-light btn-print" data-toggle="tooltip" title="Cetak">
                              <i class="fas fa-print fa-sm"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-toggle="tooltip" title="Detail" data-kd="' . $row['no_order'] . '">
                              <i class="fas fa-eye fa-sm"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="' . $row['no_order'] . '" data-toggle="tooltip" title="Edit">
                              <i class="fas fa-pencil-alt fa-sm"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="' . $row['no_order'] . '" data-toggle="tooltip" title="Hapus">
                              <i class="fas fa-trash fa-sm"></i>
                            </a>
                          </div>';
      } else {
        $row['view'] = '<div class="btn-group" role="group">
                            <a href="http://localhost/hira-to-adm/penjualan/print/' . $row['no_order'] . '" target="_blank" class="btn btn-sm btn-info text-white border border-light btn-print" data-toggle="tooltip" title="Cetak">
                              <i class="fas fa-print fa-sm"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-toggle="tooltip" title="Detail" data-kd="' . $row['no_order'] . '">
                              <i class="fas fa-eye fa-sm"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-kd="' . $row['no_order'] . '" data-toggle="tooltip" title="Edit">
                              <i class="fas fa-pencil-alt fa-sm"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-kd="' . $row['no_order'] . '" data-toggle="tooltip" title="Hapus">
                              <i class="fas fa-trash fa-sm"></i>
                            </a>
                          </div>';
      }
    }

    $results = json_encode($data);

    echo $results;
  }

  public function getDataByKd($kd)
  {
    $this->db->select('p.id, p.reccu, om.id as id_order, om.no_order, om.dateAdd as dateorder, p.jenis, p.muatan, p.berat, p.hrg_borong, p.hrg_kg, p.pengirim, p.kota_asal, p.alamat_asal, p.penerima, p.kota_tujuan, p.alamat_tujuan, p.total_hrg, p.pembayaran, p.dateAdd')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->where('om.no_order', $kd);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getReccu()
  {
    $this->db->select('p.reccu, p.pengirim, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.no_order')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getSearchReccu($keyword)
  {
    $this->db->select('p.reccu, p.pengirim, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.no_order')
      ->from('penjualan')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->like('p.reccu', $keyword);;

    $query = $this->db->get()->result();

    return $query;
  }

  public function getReccuForTravelDoc()
  {
    $this->db->select('p.reccu, p.pengirim, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.no_order')
      ->from('penjualan p')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->where('p.reccu NOT IN (SELECT reccu FROM detail_sj)');

    $query = $this->db->get()->result();

    return $query;
  }

  public function getSearchReccuForTravelDoc($keyword)
  {
    $this->db->select('p.reccu, p.pengirim, p.penerima, p.jenis, p.berat, p.hrg_kg, p.hrg_borong, p.total_hrg, om.no_order')
      ->from('penjualan')
      ->join('order_masuk om', 'om.id = p.order_id')
      ->where('p.reccu NOT IN (SELECT reccu FROM detail_sj)')
      ->like('p.reccu', $keyword);

    $query = $this->db->get()->result();

    return $query;
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
    $this->db->where('penjualan.invAdd =', null);
    $this->db->where('pengirim', $post);
    $this->db->where('pembayaran=', "tempo");

    $query = $this->db->get()->result();
    return $query;
  }

  public function getOrderSopir($noorder)
  {
    $this->db->select('penjualan.no_order, penjualan.jenis_penjualan, penjualan.muatan, penjualan.pengirim, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.total_harga, order_masuk.no_order, sangu_order.no_order, sangu_order.sopir_id, sangu_order.nominal, sangu_order.tambahan');
    $this->db->from('penjualan');
    $this->db->where('penjualan.no_order', $noorder);
    $this->db->join('order_masuk', 'order_masuk.no_order = penjualan.no_order');
    $this->db->join('sangu_order', 'sangu_order.no_order = penjualan.no_order');

    $query = $this->db->get()->row();
    return $query;
  }

  public function getDataOrderCust($no)
  {
    $this->db->select('penjualan.no_order, penjualan.surat_jalan, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.berat, penjualan.harga_kg, penjualan.total_harga, penjualan.dateAdd, penjualan.invAdd, sangu_order.no_order, sangu_order.platno');
    $this->db->from('penjualan');
    $this->db->where('penjualan.no_order', $no);
    $this->db->join('sangu_order', 'sangu_order.no_order = penjualan.no_order');
    $query = $this->db->get()->row();
    return $query;
  }

  public function addData($data, $dataorder, $where)
  {
    $this->db->insert('penjualan', $data);
    $this->db->update('order_masuk', $dataorder, $where);
  }

  public function editData($data, $dataorder, $where, $wherepenjualanid)
  {
    $this->db->update('penjualan', $data, $wherepenjualanid);
    $this->db->update('order_masuk', $dataorder, $where);
  }

  public function deleteData($id, $no)
  {
    $dataorder = [
      'status_order'  => 'disiapkan',
    ];

    $wherenoorder = [
      'no_order' => $no
    ];

    $whereidorder = [
      'order_id' => $id
    ];

    $this->db->delete('penjualan', $whereidorder);
    $this->db->update('order_masuk', $dataorder, $wherenoorder);
  }
}
