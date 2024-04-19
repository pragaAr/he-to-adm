<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class M_Traveldoc extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('a.id, a.nomor_surat, b.nama, a.jml_reccu, a.jml_sj, a.dateAdd')
      ->from('surat_jalan a')
      ->join('customer b', 'b.id = a.cust_id')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-primary text-white border border-light btn-print" data-nomor="$2" data-toggle="tooltip" title="Cetak">
            <i class="fas fa-print fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-success text-white border border-light btn-detail" data-nomor="$2" data-toggle="tooltip" title="Detail">
            <i class="fas fa-eye fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-nomor="$2" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, nomor_surat, nama, jml_reccu, jml_sj, dateAdd'
      );

    return $this->datatables->generate();
  }

  public function generateNomorSuratJalan($cust, $tipe)
  {
    $this->db->where('customer', $cust)
      ->where('jenis', $tipe)
      ->order_by('id', 'DESC');

    $query = $this->db->get('nomor_surat', 1);

    if ($query->num_rows() > 0) {
      $row = $query->row();
      return $row->nomor_angka + 1;
    } else {
      return 1;
    }
  }

  public function getTandaTerimaData($str)
  {
    $getreccu = $this->db->select('reccu')
      ->from('detail_sj')
      ->where('nomor_surat', $str)
      ->get()->result();

    $reccu_values = [];
    foreach ($getreccu as $item) {
      $reccu_values[] = $item->reccu;
    }

    $this->db->select('order_masuk.dateAdd as dateOrder, armada.platno, penjualan.reccu, penjualan.kota_asal, penjualan.kota_tujuan, penjualan.berat, penjualan.hrg_kg, penjualan.total_hrg')
      ->from('penjualan')
      ->join('order_masuk', 'order_masuk.id = penjualan.order_id')
      ->join('sangu_sopir', 'sangu_sopir.no_order = order_masuk.no_order')
      ->join('armada', 'armada.id = sangu_sopir.truck_id')
      ->where_in('penjualan.reccu', $reccu_values);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getDetailData($reccu)
  {
    $this->db->select('reccu, ket, surat_jalan, berat, retur')
      ->from('detail_sj')
      ->where_in('reccu', $reccu);

    $query = $this->db->get()->result();

    return $query;
  }

  public function getNomorSuratJalan($nomor)
  {
    $this->db->select('nomor_surat')
      ->from('surat_jalan')
      ->where('nomor_surat', $nomor);

    $query = $this->db->get()->row();

    return $query;
  }

  public function getDataByNomor($str)
  {
    $this->db->select('a.nomor_surat, b.nama, a.jml_sj')
      ->from('surat_jalan a')
      ->where('a.nomor_surat', $str)
      ->join('customer b', 'b.id = a.cust_id');

    $query = $this->db->get()->row();

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

  public function addData($datasj, $datadt, $datasurat)
  {
    $query = $this->db->insert('surat_jalan', $datasj);
    $query = $this->db->insert_batch('detail_sj', $datadt);
    $query = $this->db->insert('nomor_surat', $datasurat);

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function editData($data, $dataorder, $where, $wherepenjualanid)
  {
    $this->db->update('penjualan', $data, $wherepenjualanid);
    $this->db->update('order_masuk', $dataorder, $where);
  }

  public function deleteData($nomor)
  {
    $this->db->delete('surat_jalan', ['nomor_surat' => $nomor]);
    $this->db->delete('detail_sj', ['nomor_surat' => $nomor]);
    $this->db->delete('nomor_surat', ['nomor' => $nomor]);
  }
}
