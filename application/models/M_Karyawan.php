<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Karyawan extends CI_Model
{
  public function getData()
  {
    return $this->db->get('Karyawan')->result();
  }

  public function getId($id)
  {
    return $this->db->get_where('Karyawan', ['id_Karyawan' => $id])->row();
  }

  public function addData()
  {
    $nama     = $this->input->post('nama');
    $usia     = $this->input->post('usia');
    $alamat   = $this->input->post('alamat');
    $notelp   = $this->input->post('notelp');
    $status   = $this->input->post('status');
    $dateAdd  = date('Y-m-d H:i:s');

    $data = array(
      'nama'      => strtolower($nama),
      'usia'      => strtolower($usia),
      'alamat'    => strtolower($alamat),
      'notelp'    => strtolower($notelp),
      'status'    => strtolower($status),
      'dateAdd'   => $dateAdd
    );

    $this->db->insert('karyawan', $data);
  }

  public function editData($id)
  {
    $nama     = trim($this->input->post('nama'));
    $usia     = trim($this->input->post('usia'));
    $alamat   = trim($this->input->post('alamat'));
    $notelp   = trim($this->input->post('notelp'));
    $status   = trim($this->input->post('status'));

    $data = array(
      'nama'      => strtolower($nama),
      'usia'      => strtolower($usia),
      'alamat'    => strtolower($alamat),
      'notelp'    => strtolower($notelp),
      'status'    => strtolower($status),
    );

    $where = array('id_karyawan' => $id);

    $this->db->update('karyawan', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('karyawan', ['id_karyawan' => $id]);
  }
}
