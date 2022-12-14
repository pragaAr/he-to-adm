<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_Sangu extends CI_Model
{
  public function getData()
  {
    return $this->db->get('sangu_order')->result();
  }

  public function getNoOrder($no)
  {
    return $this->db->get_where('sangu_order', ['no_order' => $no])->row();
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
