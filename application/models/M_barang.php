<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_barang extends CI_Model
{
  public function get_all_data()
  {
    $this->db->select('*');
    $this->db->from('barang');
    $this->db->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left');
    $this->db->order_by('barang.id_barang', 'desc');
    return $this->db->get()->result();
  }

  public function get_data($id_barang)
  {
    $this->db->select('*');
    $this->db->from('barang');
    $this->db->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left');
    $this->db->where('id_barang', $id_barang);
    return $this->db->get()->row();
  }

  public function add($data)
  {
    $this->db->insert('barang', $data);
  }

  public function edit($data)
  {
    $this->db->where('id_barang', $data['id_barang']);
    $this->db->update('barang', $data);
  }

  public function delete($data)
  {
    $this->db->where('id_barang', $data['id_barang']);
    $this->db->delete('barang', $data);
  }
}

/* End of file M_barang.php */
