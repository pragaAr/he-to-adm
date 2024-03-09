<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Traveldoc extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, reccu, jml_sj, dateAdd')
      ->from('surat_jalan')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="http://localhost/hira-to-adm/traveldoc/print/$1" target="_blank" class="btn btn-sm btn-primary text-white border border-light" data-toggle="tooltip" title="PDF">
            <i class="fas fa-print fa-sm"></i>
          </a>
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
    $this->db->select('reccu, surat_jalan, berat')
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
