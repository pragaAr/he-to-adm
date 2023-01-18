<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Sopir extends CI_Model
{
  public function getData()
  {
    return $this->db->get('sopir')->result();
  }

  public function getId($id)
  {
    return $this->db->get_where('sopir', ['id_sopir' => $id])->row();
  }

  public function addData()
  {
    $nama       = $this->input->post('namasopir');
    $alamat     = $this->input->post('alamatsopir');
    $notelp     = $this->input->post('notelpsopir');
    $dateAdd    = date('Y-m-d H:i:s');

    $data = array(
      'nama_sopir'    => strtolower($nama),
      'alamat_sopir'  => strtolower($alamat),
      'notelp_sopir'  => strtolower($notelp),
      'dateAdd'       => $dateAdd
    );

    $this->db->insert('sopir', $data);
  }

  public function editData($id)
  {
    $nama       = $this->input->post('namasopir');
    $alamat     = $this->input->post('alamatsopir');
    $notelp     = $this->input->post('notelpsopir');

    $data = array(
      'nama_sopir'    => strtolower($nama),
      'alamat_sopir'  => strtolower($alamat),
      'notelp_sopir'  => strtolower($notelp),
    );

    $where = array('id_sopir' => $id);

    $this->db->update('sopir', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('sopir', ['id_sopir' => $id]);
  }
}
