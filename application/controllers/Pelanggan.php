<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_pelanggan');
    $this->load->model('m_auth');
  }


  public function register()
  {
    $this->form_validation->set_rules(
      'nama_pelanggan',
      'Nama Pelanggan',
      'required',
      array('required' => '%s Harus Diisi!')
    );
    $this->form_validation->set_rules(
      'email',
      'Email',
      'required|is_unique[pelanggan.email]',
      array('required' => '%s Harus Diisi!', 'is_unique' => '%s Email Sudah Terdaftar...!!')
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
        'title' => 'Register Pelanggan',
        'isi' => 'pelanggan/v_register'
      );
      $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
    } else {
      $data = array(
        'nama_pelanggan' => $this->input->post('nama_pelanggan'),
        'email' => $this->input->post('email'),
        'password' => $this->input->post('password'),

      );
      $this->m_pelanggan->register($data);
      $this->session->set_flashdata('pesan', 'Selamat, Register Berhasil Silahkan Login Kembali!');
      redirect('pelanggan/register');
    }
  }

  public function setting()
  {
    $this->form_validation->set_rules(
      'nama_toko',
      'Nama Toko',
      'required',
      array('required' => '%s Harus Diisi!')
    );
    $this->form_validation->set_rules(
      'kota',
      'Kota',
      'required',
      array('required' => '%s Harus Diisi!')
    );
    $this->form_validation->set_rules(
      'alamat_toko',
      'Alamat Toko',
      'required',
      array('required' => '%s Harus Diisi!')
    );
    $this->form_validation->set_rules(
      'no_telpon',
      'No Telpon',
      'required',
      array('required' => '%s Harus Diisi!')
    );

    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Setting',
        'setting' => $this->m_admin->data_setting(),
        'isi' => 'v_setting'
      );
      $this->load->view('layout/v_wrapper_backend', $data, FALSE);
    } else {
      $data = array(
        'id' => 1,
        'lokasi' => $this->input->post('kota'),
        'nama_toko' => $this->input->post('nama_toko'),
        'alamat_toko' => $this->input->post('alamat_toko'),
        'no_telpon' => $this->input->post('no_telpon'),

      );
      $this->m_admin->edit($data);
      $this->session->set_flashdata('pesan', 'Settingan Berhasil Diedit!');
      redirect('admin/setting');
    }
  }

  public function login()
  {
    $this->form_validation->set_rules('email', 'Email', 'required', array(
      'required' => 'Email Harus Diisi!'
    ));
    $this->form_validation->set_rules('password', 'Password', 'required', array(
      'required' => 'Password Harus Diisi!'
    ));

    if ($this->form_validation->run() == TRUE) {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $this->pelanggan_login->login($email, $password);
    }

    $data = array(
      'title' => 'Login Pelanggan',
      'isi' => 'pelanggan/v_login_pelanggan'
    );
    $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
  }

  public function logout()
  {
    $this->pelanggan_login->logout();
  }

  public function akun()
  {
    //proteksi halaman
    $this->pelanggan_login->proteksi_halaman();

    $data = array(
      'title' => 'Profil Saya',
      'isi' => 'pelanggan/v_akun_saya',
    );
    $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
  }

  public function edit($id_pelanggan = NULL)
  {
    $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required', array(
      'required' => '%s Harus diisi!!'
    ));
    $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required', array(
      'required' => '%s Harus diisi!!'
    ));
    $this->form_validation->set_rules('email', 'Email', 'required', array(
      'required' => '%s Harus diisi!!'
    ));


    if ($this->form_validation->run() == TRUE) {
      $config['upload_path'] = './assets/foto/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
      $config['max_size'] = '2000';
      $this->upload->initialize($config);
      $field_name = "foto";
      if (!$this->upload->do_upload($field_name)) {
        $data = array(
          'title' => 'Edit Menu',
          'error_upload' => $this->upload->display_errors(),
          'isi' => 'pelanggan/v_akun_saya',
        );
        $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
      } else {
        //hapus gambar
        $pelanggan = $this->m_pelanggan->get_data($id_pelanggan);
        if ($pelanggan->foto != "") {
          unlink('./assets/foto/' . $pelanggan->foto);
        }
        //end hapus gambar

        $upload_data = array('uploads' => $this->upload->data());
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/foto/' . $upload_data['uploads']['file_name'];
        $this->load->library('image_lib', $config);
        $data = array(
          'id_pelanggan' => $id_pelanggan,
          'nama_pelanggan' => $this->input->post('nama_pelanggan'),

          'email' => $this->input->post('email'),

          'foto' => $upload_data['uploads']['file_name'],
        );
        $this->m_pelanggan->edit($data);
        $this->session->set_flashdata('pesan', 'Data berhasil diganti!!');
        redirect('pelanggan/akun');
      }
      //jika tanpa ganti gambar
      $data = array(
        'id_pelanggan' => $id_pelanggan,
        'nama_pelanggan' => $this->input->post('nama_pelanggan'),
        'email' => $this->input->post('email'),

      );
      $this->m_pelanggan->edit($data);
      $this->session->set_flashdata('pesan', 'Data berhasil diganti!!');
      redirect('pelanggan/akun');
    }

    $data = array(
      'title' => 'Edit Menu',
      'isi' => 'pelanggan/v_akun_saya',
    );
    $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
  }
}

/* End of file Admin.php */
