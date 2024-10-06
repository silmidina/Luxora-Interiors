<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_gambarbarang extends CI_Model
{
  public function get_all_data()
  {
    $this->db->select('barang.*,COUNT(gambar.id_barang) as total_gambar');
    $this->db->from('barang');
    $this->db->join('gambar', 'gambar.id_barang = barang.id_barang', 'left');
    $this->db->group_by('barang.id_barang');
    $this->db->order_by('barang.id_barang', 'desc');
    return $this->db->get()->result();
  }

  public function get_data($id_gambar)
  {
    $this->db->select('*');
    $this->db->from('gambar');
    $this->db->where('id_gambar', $id_gambar);
    return $this->db->get()->row();
  }

  public function get_gambar($id_barang)
  {
    $this->db->select('*');
    $this->db->from('gambar');
    $this->db->where('id_barang', $id_barang);
    return $this->db->get()->result();
  }

  public function add($data)
  {
    $this->db->insert('gambar', $data);
  }

  public function delete($data)
  {
    $this->db->where('id_gambar', $data['id_gambar']);
    $this->db->delete('gambar', $data);
  }
}
