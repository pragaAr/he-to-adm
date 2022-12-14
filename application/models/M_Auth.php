<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_MODEL
{
  public function cekLogin()
  {
    $uname  = set_value('username');
    $pass   = set_value('pass');

    $result = $this->db
      ->where('username', $uname)
      ->where('pass', md5($pass))
      ->limit(1)
      ->get('user');

    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return false;
    }
  }
}
