<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Uangmakan extends CI_Model
{
  public function getKd()
  {
    $this->db->select('RIGHT(uang_makan.kd_um,3) as kd_um', FALSE);
    $this->db->order_by('kd_um', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('uang_makan');
    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kd_um) + 1;
    } else {
      $kode = 1;
    }
    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "um." . $batas;
    return $kodetampil;
  }

  public function getDataKd($kd)
  {
    $this->db->select('uang_makan.kd_um, uang_makan.jml_nominal, uang_makan.dateAdd');
    $this->db->from('uang_makan');
    $this->db->where('kd_um', $kd);
    $query = $this->db->get()->row();
    return $query;
  }

  public function getData()
  {
    return $this->db->get('uang_makan')->result();
  }

  public function getId($id)
  {
    return $this->db->get_where('uang_makan', ['id_um' => $id])->row();
  }

  public function getDetailKd($kd)
  {
    $this->db->select('uang_makan.kd_um, uang_makan.dateAdd, detail_um.kd_um, detail_um.karyawan_id, detail_um.nominal_um, karyawan.id_karyawan, karyawan.nama');
    $this->db->from('detail_um');
    $this->db->where('detail_um.kd_um', $kd);
    $this->db->join('uang_makan', 'uang_makan.kd_um = detail_um.kd_um');
    $this->db->join('karyawan', 'karyawan.id_karyawan = detail_um.karyawan_id');
    $query = $this->db->get()->result();
    return $query;
  }

  public function addData($data, $detail)
  {
    $this->db->insert('uang_makan', $data);
    $this->db->insert_batch('detail_um', $detail);
  }

  public function updateData($kd, $data, $detail)
  {
    $where = array(
      'kd_um'   => $kd
    );

    $this->db->update('uang_makan', $data, $where);
    $this->db->delete('detail_um', $where);
    $this->db->insert_batch('detail_um', $detail);
  }

  public function deleteData($kd)
  {
    $this->db->delete('uang_makan', ['kd_um' => $kd]);
    $this->db->delete('detail_um', ['kd_um' => $kd]);
  }
}
