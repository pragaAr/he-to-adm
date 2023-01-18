<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Sangu extends CI_Model
{
  public function getData()
  {
    $this->db->select('*');
    $this->db->from('sangu_order');
    $this->db->join('sopir', 'sopir.id_sopir = sangu_order.sopir_id');
    $res = $this->db->get()->result();
    return $res;
  }

  public function getNoOrder($no)
  {
    $this->db->select('*');
    $this->db->from('sangu_order');
    $this->db->where('no_order', $no);
    $this->db->join('sopir', 'sopir.id_sopir = sangu_order.sopir_id');
    $res = $this->db->get()->row();
    return $res;
  }

  public function editData($no)
  {
    $platno     = trim($this->input->post('platno'));
    $supir      = trim($this->input->post('supir'));
    $asal       = trim($this->input->post('asal'));
    $tujuan     = trim($this->input->post('tujuan'));
    $nominal    = preg_replace("/[^0-9\.]/", "", $this->input->post('nominal'));
    $user       = $this->session->userdata('id_user');

    $data = array(
      'platno'        => strtolower($platno),
      'supir'         => strtolower($supir),
      'kota_asal'     => strtolower($asal),
      'kota_tujuan'   => strtolower($tujuan),
      'nominal'       => $nominal,
      'user_id'       => $user,
    );

    $where = array('no_order' => $no);

    $this->db->update('sangu_order', $data, $where);
  }
}
