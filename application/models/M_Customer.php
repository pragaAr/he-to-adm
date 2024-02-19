<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Customer extends CI_Model
{
  public function getData()
  {
    $this->datatables->select('id, nama, notelp, alamat')
      ->from('customer')
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
        'id, nama, notelp, alamat'
      );

    return $this->datatables->generate();
  }

  public function getDataNama()
  {
    $this->db->select('nama');
    $this->db->from('customer');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getDataByName($nama)
  {
    $this->db->select('*');
    $this->db->from('customer');
    $this->db->where('nama', $nama);
    $query = $this->db->get()->row();
    return $query;
  }

  public function countData()
  {
    return $this->db->get('customer')->num_rows();
  }

  public function getId($id)
  {
    return $this->db->get_where('customer', ['id' => $id])->row();
  }

  public function addData($data)
  {
    return $this->db->insert('customer', $data);
  }

  public function editData($data, $where)
  {
    return $this->db->update('customer', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('customer', ['id' => $id]);
  }
}
