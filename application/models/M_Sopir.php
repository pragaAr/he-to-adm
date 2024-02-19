<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Sopir extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, nama, alamat, notelp')
      ->from('sopir')
      ->add_column(
        'view',
        '<div class="btn-group" role="group">
          <a href="javascript:void(0);" class="btn btn-sm btn-warning text-white border border-light btn-edit" data-id="$1" data-toggle="tooltip" title="Edit">
            <i class="fas fa-pencil-alt fa-sm"></i>
          </a>
          <a href="javascript:void(0);" class="btn btn-sm btn-danger text-white border border-light btn-delete" data-id="$1" data-toggle="tooltip" title="Hapus">
            <i class="fas fa-trash fa-sm"></i>
          </a>
        </div>',
        'id, nama, alamat, notelp'
      );

    return $this->datatables->generate();
  }

  public function getId($id)
  {
    return $this->db->get_where('sopir', ['id' => $id])->row();
  }

  public function addData($data)
  {
    return $this->db->insert('sopir', $data);
  }

  public function editData($data, $where)
  {
    return $this->db->update('sopir', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('sopir', ['id' => $id]);
  }
}
