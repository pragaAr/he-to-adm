<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Customer extends CI_Model
{
  public function getData()
  {
    $this->db->select('customer.id_customer, customer.customercab_id, customer.nama_customer, customer.notelp, customer.alamat, cabang.id_cab, cabang.nama_cab');
    $this->db->from('customer');
    $this->db->join('cabang', 'cabang.id_cab = customer.customercab_id');
    $query = $this->db->get()->result();
    return $query;
  }

  public function countData()
  {
    return $this->db->get('customer')->num_rows();
  }

  public function getId($id)
  {
    return $this->db->get_where('customer', ['id_customer' => $id])->row();
  }

  public function addData()
  {
    $nama     = $this->input->post('nama');
    $notelp   = $this->input->post('notelp');
    $alamat   = $this->input->post('alamat');
    $dateAdd  = date('d-m-Y H:i:s');

    $data = array(
      'nama'    => strtolower($nama),
      'notelp'  => strtolower($notelp),
      'alamat'  => strtolower($alamat),
      'dateAdd' => $dateAdd
    );

    $this->db->insert('customer', $data);
  }

  public function editData($id)
  {
    $nama     = trim($this->input->post('nama'));
    $notelp   = trim($this->input->post('notelp'));
    $alamat   = trim($this->input->post('alamat'));

    $data = array(
      'nama'    => strtolower($nama),
      'notelp'  => strtolower($notelp),
      'alamat'  => strtolower($alamat),
    );

    $where = array('id_customer' => $id);

    $this->db->update('customer', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('customer', ['id_customer' => $id]);
  }
}
