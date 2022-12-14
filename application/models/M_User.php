<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class M_User extends CI_Model
{
  public function getData()
  {
    return $this->db->get('user')->result();
  }

  public function getId($id)
  {
    return $this->db->get_where('user', ['id_user' => $id])->row();
  }

  public function addData()
  {
    $nama       = $this->input->post('namauser');
    $username   = $this->input->post('username');
    $pass       = $this->input->post('pass');
    $role       = 'admin';
    $dateAdd    = date('Y-m-d H:i:s');

    $data = array(
      'namauser'    => strtolower($nama),
      'username'    => strtolower($username),
      'pass'        => md5($pass),
      'role'        => $role,
      'dateAdd'     => $dateAdd
    );

    $this->db->insert('user', $data);
  }

  public function editData($id)
  {
    $nama       = $this->input->post('namauser');
    $username   = $this->input->post('username');
    $pass       = $this->input->post('pass');
    $role       = 'admin';

    $data = array(
      'namauser'    => strtolower($nama),
      'username'    => strtolower($username),
      'pass'        => md5($pass),
      'role'        => $role
    );

    $where = array('id_user' => $id);

    $this->db->update('user', $data, $where);
  }

  public function deleteData($id)
  {
    return $this->db->delete('user', ['id_user' => $id]);
  }
}
