<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_auth');
  }

  public function login_admin()
  {
    $this->form_validation->set_rules('username', 'Username', 'required', array(
      'required' => 'Username Harus Diisi!'
    ));
    $this->form_validation->set_rules('password', 'Password', 'required', array(
      'required' => 'Password Harus Diisi!'
    ));


    if ($this->form_validation->run() == TRUE) {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $this->user_login->login($username, $password);
    }
    $data = array(
      'title' => 'Login Admin',
    );
    $this->load->view('v_login_admin', $data, FALSE);
  }

  public function logout_admin()
  {
    $this->user_login->logout();
  }

  public function register()
  {
    $this->form_validation->set_rules(
      'nama_user',
      'Nama User',
      'required',
      array('required' => '%s Harus Diisi!')
    );
    $this->form_validation->set_rules(
      'username',
      'Username',
      'required',
      array('required' => '%s Harus Diisi!')
    );
    $this->form_validation->set_rules(
      'password',
      'Password',
      'required',
      array('required' => '%s Harus Diisi!')
    );
    $this->form_validation->set_rules(
      'ulangi_password',
      'Ulangi Password',
      'required|matches[password]',
      array('required' => '%s Harus Diisi!', 'matches' => '%s Password Tidak Sama...!!')
    );

    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Register Admin',
      );
      $this->load->view('v_register_admin', $data, FALSE);
    } else {
      $data = array(
        'nama_user' => $this->input->post('nama_user'),
        'username' => $this->input->post('username'),
        'password' => $this->input->post('password'),

      );
      $this->m_auth->register($data);
      $this->session->set_flashdata('pesan', 'Selamat, Register Berhasil Silahkan Login Kembali!');
      redirect('auth/register');
    }
  }
}

/* End of file Auth.php */
