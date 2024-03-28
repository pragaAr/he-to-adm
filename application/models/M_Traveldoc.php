<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class M_Traveldoc extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, reccu, jml_sj, dateAdd')
      ->from('surat_jalan')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-reccu="$2" data-toggle="tooltip" title="Detail">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-reccu="$2" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, reccu, jml_sj, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function getTandaTerimaData($reccu)
  {
    $this->db->select('sj.reccu, sj.order_no, sj.jml_sj, sj.keterangan, p.kota_asal, p.kota_tujuan, p.berat, p.hrg_kg, p.total_hrg, p.dateAdd, a.platno')
      ->from('surat_jalan sj')
      ->join('penjualan p', 'p.reccu = sj.reccu')
      ->join('order_masuk om', 'om.no_order = sj.order_no')
      ->join('sangu_sopir ss', 'ss.no_order = om.no_order')
      ->join('armada a', 'a.id = ss.truck_id')
      ->where_in('sj.reccu', $reccu);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDetailData($reccu)
  {
    $this->db->select('reccu, surat_jalan, berat, retur')
      ->from('detail_sj')
      ->where_in('reccu', $reccu);

    $query = $this->db->get()->result();

    return $query;
  }

  // ==============================================================================================
  // for print tanda terima surat jalan opsi lain
  // public function tandaTerima($reccu)
  // {
  //   $this->db->select('sj.reccu, sj.order_no, p.kota_asal, p.kota_tujuan, p.berat, p.hrg_kg, p.total_hrg, p.dateAdd, a.platno')
  //     ->from('surat_jalan sj')
  //     ->join('penjualan p', 'p.reccu = sj.reccu')
  //     ->join('order_masuk om', 'om.no_order = sj.order_no')
  //     ->join('sangu_sopir ss', 'ss.no_order = om.no_order')
  //     ->join('armada a', 'a.id = ss.truck_id')
  //     ->where_in('sj.reccu', $reccu);

  //   $queryPenjualan = $this->db->get()->result();

  //   $this->db->select('*')
  //     ->from('detail_sj')
  //     ->where_in('reccu', $reccu);

  //   $queryDetail = $this->db->get()->result();

  //   $merge = array();

  //   $no = 1;

  //   foreach ($queryPenjualan as $penjualan) {
  //     $merge[] = array(
  //       'no'        => $no++ . '.',
  //       'reccu'     => $penjualan->reccu,
  //       'dateAdd'   => date('d/m/Y', strtotime($penjualan->dateAdd)),
  //       'nosj'      => null,
  //       'platno'    => $penjualan->platno,
  //       'kota'      => $penjualan->kota_asal . '-' . $penjualan->kota_tujuan,
  //       'berat'     => $penjualan->berat,
  //       'hrg_kg'    => $penjualan->hrg_kg,
  //       'total_hrg' => $penjualan->total_hrg,
  //     );

  //     foreach ($queryDetail as $detail) {
  //       if ($detail->reccu == $penjualan->reccu) {
  //         $merge[] = array(
  //           'no'        => null,
  //           'reccu'     => null,
  //           'dateAdd'   => null,
  //           'nosj'      => $detail->surat_jalan,
  //           'platno'    => null,
  //           'kota'      => null,
  //           'berat'     => $detail->retur != 0 ? $detail->retur . ' batang' : null,
  //           'hrg_kg'    => null,
  //           'total_hrg' => null,
  //         );
  //       }
  //     }

  //   }

  //   return $merge;
  // }
  // for print tanda terima surat jalan opsi lain
  // ==============================================================================================

  public function getDataReccuByCust($cust)
  {
    $this->db->select('reccu')
      ->from('surat_jalan')
      ->where('cust_id', $cust);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDataByReccu($reccu)
  {
    $this->db->select('reccu, jml_sj, dateAdd')
      ->from('surat_jalan')
      ->where('reccu', $reccu);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDetailByReccu($reccu)
  {
    $this->db->select('reccu, surat_jalan, berat, retur')
      ->from('detail_sj')
      ->where('reccu', $reccu);

    $query = $this->db->get()->result();

    return $query;
  }

  public function addData($datasj, $datadt)
  {
    $this->db->insert('surat_jalan', $datasj);
    $this->db->insert_batch('detail_sj', $datadt);
  }

  public function editData($data, $dataorder, $where, $wherepenjualanid)
  {
    $this->db->update('penjualan', $data, $wherepenjualanid);
    $this->db->update('order_masuk', $dataorder, $where);
  }

  public function deleteData($reccu)
  {
    $this->db->delete('surat_jalan', ['reccu' => $reccu]);
    $this->db->delete('detail_sj', ['reccu' => $reccu]);
  }
}
