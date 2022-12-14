<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_User', 'User');

    if (empty($this->session->userdata('id_user'))) {
      $this->session->set_flashdata('flashrole', 'Silahkan Login terlebih dahulu!');
      redirect('auth');
    }
  }

  public function index()
  {
    $data['title']      = 'Data User';
    $data['user']       = $this->User->getData();

    $this->form_validation->set_rules('namauser', 'Cabang Asal', 'required');
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('pass', 'Password', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/template/header', $data);
      $this->load->view('layout/template/navbar');
      $this->load->view('layout/template/sidebar');
      $this->load->view('layout/master/user', $data);
      $this->load->view('layout/template/footer');
    } else {
      $this->User->addData();
      $this->session->set_flashdata('inserted', 'Data berhasil ditambahkan!');
      redirect('user');
    }
  }

  public function getId()
  {
    $id   = $this->input->post('id_user');
    $data = $this->User->getId($id);

    echo json_encode($data);
  }

  public function update()
  {
    $id = $this->input->post('iduser');
    $this->User->editData($id);
    $this->session->set_flashdata('updated', 'Data berhasil diubah!');
    redirect('user');
  }

  public function delete($id)
  {
    $this->User->deleteData($id);
    $this->session->set_flashdata('deleted', 'Data berhasil dihapus!');
    redirect('user');
  }
}
