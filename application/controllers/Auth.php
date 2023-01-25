<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Auth', 'Auth');
  }

  public function index()
  {
    $data['title'] = "Login";

    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('pass', 'Password', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/auth/header', $data);
      $this->load->view('layout/auth/login');
      $this->load->view('layout/auth/footer');
    } else {
      $uname        = $this->input->post('username');
      $inputpass    = $this->input->post('pass');

      $cekpass      = $this->Auth->cekLogin($uname);
      $truepass     = password_verify($inputpass, $cekpass->pass);

      if ($cekpass) {

        if ($truepass) {
          // var_dump($truepass);
          // die;
          $this->session->set_userdata('id_users', $cekpass->id_user);
          $this->session->set_userdata('namauser', $cekpass->namauser);
          $this->session->set_userdata('username', $cekpass->username);
          $this->session->set_userdata('role', $cekpass->role);

          $this->session->set_flashdata('userlogin', 'Selamat Datang ' . ucwords($this->session->userdata('username')));
          redirect('home');
        } else {
          $this->session->set_flashdata('wrongdata', 'Password salah!');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('wrongdata', 'Username dan Password salah!');
        redirect('auth');
      }
    }
  }

  public function register()
  {
    $data['title'] = "Registrasi";

    $this->form_validation->set_rules('namauser', 'Username', 'required|trim|strtolower');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('pass', 'Password', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/auth/header', $data);
      $this->load->view('layout/auth/register', $data);
      $this->load->view('layout/auth/footer');
    } else {
      $this->Auth->Register();
      $this->session->set_flashdata('registered', 'Berhasil Registrasi');
      redirect('auth');
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('id_user');
    $this->session->unset_userdata('namauser');
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('role');
    $this->session->set_flashdata('userlogout', 'Sampai jumpa kembali!');
    redirect('auth');
  }
}
