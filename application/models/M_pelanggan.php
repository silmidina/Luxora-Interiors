<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_pelanggan extends CI_Model
{
  public function register($data)
  {
    $this->db->insert('pelanggan', $data);
  }

  public function edit($data)
  {
    $this->db->where('id_pelanggan', $data['id_pelanggan']);
    $this->db->update('pelanggan', $data);
  }
}

/* End of file M_pelanggan.php */
