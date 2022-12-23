<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Pengeluaran_lain extends CI_Model
{
  public function getData()
  {
    $this->db->select('pengeluaran_lain.id_lain, pengeluaran_lain.karyawan_id, pengeluaran_lain.nominal, pengeluaran_lain.keterangan, pengeluaran_lain.dateAdd, karyawan.id_karyawan, karyawan.nama');
    $this->db->from('pengeluaran_lain');
    $this->db->join('karyawan', 'karyawan.id_karyawan = pengeluaran_lain.karyawan_id');
    $query = $this->db->get()->result();
    return $query;
  }

  public function getId($id)
  {
    $this->db->select('pengeluaran_lain.id_lain, pengeluaran_lain.karyawan_id, pengeluaran_lain.nominal, pengeluaran_lain.keterangan, karyawan.id_karyawan, karyawan.nama');
    $this->db->from('pengeluaran_lain');
    $this->db->join('karyawan', 'karyawan.id_karyawan = pengeluaran_lain.karyawan_id');
    $this->db->where('pengeluaran_lain.id_lain', $id);
    $query = $this->db->get()->row();
    return $query;
  }

  public function addData()
  {
    $karyawan   = $this->input->post('karyawan');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $keterangan = $this->input->post('keterangan');
    $user       = $this->session->userdata('id_user');
    $dateAdd    = date('Y-m-d H:i:s');

    $data = array(
      'karyawan_id'   => strtolower($karyawan),
      'nominal'       => strtolower($nominal),
      'keterangan'    => strtolower($keterangan),
      'user_id'       => strtolower($user),
      'dateAdd'       => $dateAdd
    );

    $this->db->insert('pengeluaran_lain', $data);
  }

  public function editData($id)
  {
    $karyawan   = $this->input->post('karyawanedit');
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominaledit'));
    $keterangan = $this->input->post('keteranganedit');
    $user       = $this->session->userdata('id_user');

    $data = array(
      'karyawan_id'   => strtolower($karyawan),
      'nominal'       => strtolower($nominal),
      'keterangan'    => strtolower($keterangan),
      'user_id'       => strtolower($user),
    );

    $where = array('id_lain' => $id);

    $this->db->update('pengeluaran_lain', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('pengeluaran_lain', ['id_lain' => $id]);
  }
}
