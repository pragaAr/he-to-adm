<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Persensopir extends CI_Model
{
  public function getKd()
  {
    $this->db->select('RIGHT(persensopir.kd_persen,3) as kd_persen', FALSE);
    $this->db->order_by('kd_persen', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('persensopir');
    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kd_persen) + 1;
    } else {
      $kode = 1;
    }
    $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $kodetampil = "ps-" . $batas;
    return $kodetampil;
  }

  public function getData()
  {
    $this->db->select('persensopir.kd_persen, persensopir.sopir_id, persensopir.nominal, persensopir.dateAdd, sopir.id_sopir, sopir.nama_sopir');
    $this->db->from('persensopir');
    $this->db->join('sopir', 'sopir.id_sopir = persensopir.sopir_id');
    $res = $this->db->get()->result();
    return $res;
  }

  public function getId($kd)
  {
    $this->db->select('persensopir.kd_persen, persensopir.sopir_id, persensopir.nominal, persensopir.dateAdd, sopir.id_sopir, sopir.nama_sopir');
    $this->db->from('persensopir');
    $this->db->where('persensopir.kd_persen', $kd);
    $this->db->join('sopir', 'sopir.id_sopir = persensopir.sopir_id');
    $res = $this->db->get()->result();
    return $res;
  }

  public function addData($data, $detail)
  {
    $this->db->insert('persensopir', $data);
    $this->db->insert_batch('detail_persen', $detail);
  }

  public function editData($id)
  {
    $sopirid  = $this->input->post('sopirid');
    $nominal  = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));

    $data = array(
      'sopir_id'  => $sopirid,
      'nominal'   => $nominal,
    );

    $where = array('id_persen' => $id);

    $this->db->update('persensopir', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('persensopir', ['id_persen' => $id]);
  }
}
