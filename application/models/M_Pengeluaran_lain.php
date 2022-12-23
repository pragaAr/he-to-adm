<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Pengeluaran_lain extends CI_Model
{
  public function getData()
  {
    $this->db->select('lain_lain.id_lain, lain_lain.karyawan_id, lain_lain.nominal, lain_lain.keperluan, lain_lain.dateAdd, karyawan.id_karyawan, karyawan.nama');
    $this->db->from('lain_lain');
    $this->db->join('karyawan', 'karyawan.id_karyawan = lain_lain.karyawan_id');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getId($id)
  {
    $this->db->select('lain_lain.id_lain, lain_lain.karyawan_id, lain_lain.nominal, lain_lain.keperluan, karyawan.id_karyawan, karyawan.nama');
    $this->db->from('lain_lain');
    $this->db->join('karyawan', 'karyawan.id_karyawan = lain_lain.karyawan_id');
    $this->db->where('lain_lain.id_lain', $id);
    $query = $this->db->get()->row();
    return $query;
  }

  public function addData()
  {
    $karyawan   = $this->input->post('karyawan');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $keperluan  = $this->input->post('keperluan');
    $user       = $this->session->userdata('id_user');
    $dateAdd    = date('Y-m-d H:i:s');

    $data = array(
      'karyawan_id'   => strtolower($karyawan),
      'nominal'       => strtolower($nominal),
      'keperluan'     => strtolower($keperluan),
      'user_id'       => strtolower($user),
      'dateAdd'       => $dateAdd
    );

    $this->db->insert('lain_lain', $data);
  }

  public function editData($id)
  {
    $karyawan   = $this->input->post('karyawanedit');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominaledit'));
    $keperluan  = $this->input->post('keperluanedit');
    $user       = $this->session->userdata('id_user');

    $data = array(
      'karyawan_id'   => strtolower($karyawan),
      'nominal'       => strtolower($nominal),
      'keperluan'     => strtolower($keperluan),
      'user_id'       => strtolower($user),
    );

    $where = array('id_lain' => $id);

    $this->db->update('lain_lain', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('lain_lain', ['id_lain' => $id]);
  }
}
