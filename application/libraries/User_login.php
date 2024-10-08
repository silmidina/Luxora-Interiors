<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_login
{
  protected $ci;

  public function __construct()
  {
    $this->ci = &get_instance();
    $this->ci->load->model('M_auth');
  }

  public function login($username, $password)
  {
    $cek = $this->ci->M_auth->login_admin($username, $password);
    if ($cek) {
      $nama_user = $cek->nama_user;
      $username = $cek->username;
      $level_user = $cek->level_user;
      $foto = $cek->foto;
      //buat session
      $this->ci->session->set_userdata('username', $username);
      $this->ci->session->set_userdata('nama_user', $nama_user);
      $this->ci->session->set_userdata('level_user', $level_user);
      $this->ci->session->set_userdata('foto', $foto);
      redirect('admin');
    } else {
      //jika salah
      $this->ci->session->set_flashdata('error', 'Username Atau Password Salah');
      redirect('auth/login_admin');
    }
  }

  public function proteksi_halaman()
  {
    if ($this->ci->session->userdata('username') == '') {
      $this->ci->session->set_flashdata('error', 'Anda Belum Login!');
      redirect('auth/login_admin');
    }
  }

  public function logout()
  {
    $this->ci->session->unset_userdata('username');
    $this->ci->session->unset_userdata('nama_user');
    $this->ci->session->unset_userdata('level_user');
    $this->ci->session->set_flashdata('pesan', 'Anda Berhasil Logout!');
    redirect('auth/login_admin');
  }
}

/* End of file User_login.php */
