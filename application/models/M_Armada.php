<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Armada extends CI_Model
{
  public function getData()
  {
    return $this->db->get('armada')->result();
  }

  public function getId($id)
  {
    return $this->db->get_where('armada', ['id_armada' => $id])->row();
  }

  public function addData()
  {
    $platno   = $this->input->post('platno');
    $merk     = $this->input->post('merk');
    $keur     = date('Y-m-d', strtotime($this->input->post('keur')));
    $dateAdd  = date('Y-m-d H:i:s');

    $data = array(
      'platno'    => strtolower($platno),
      'merk'      => strtolower($merk),
      'dateKeur'  => $keur,
      'dateAdd'   => $dateAdd
    );

    $this->db->insert('armada', $data);
  }

  public function editData($id)
  {
    $platno   = trim($this->input->post('platno'));
    $merk     = trim($this->input->post('merk'));
    $keur     = date('Y-m-d', strtotime($this->input->post('keur')));

    $data = array(
      'platno'    => strtolower($platno),
      'merk'      => strtolower($merk),
      'dateKeur'  => $keur,
    );

    $where = array('id_armada' => $id);

    $this->db->update('armada', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('armada', ['id_armada' => $id]);
  }
}
