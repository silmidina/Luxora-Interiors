<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Belanja extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    //Load Dependencies

  }

  // List all your items
  public function index()
  {
    if (empty($this->cart->contents())) {
      redirect('home');
    }
    $data = array(
      'title' => 'Keranjang Belanja',
      'isi' => 'v_belanja',
    );
    $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
  }

  // Add a new item
  public function add()
  {
    $redirect_page = $this->input->post('redirect_page');
    $data = array(
      'id' => $this->input->post('id'),
      'qty' => $this->input->post('qty'),
      'price' => $this->input->post('price'),
      'name' => $this->input->post('name'),
    );
    $this->cart->insert($data);
    redirect($redirect_page, 'refresh');
  }

  //Update one item
  public function update()
  {
    $i = 1;
    foreach ($this->cart->contents() as $items) {
      $data = array(
        'rowid' => $items['rowid'],
        'qty' => $this->input->post($i . '[qty]'),

      );
      $this->cart->update($data);
      $i++;
    }
    $this->session->set_flashdata('pesan', 'Keranjang berhasil di update!!');
    redirect('belanja');
  }

  //Delete one item
  public function delete($rowid)
  {
    $this->cart->remove($rowid);
    redirect('belanja');
  }

  public function clear()
  {
    $this->cart->destroy();
    redirect('belanja');
  }
}

/* End of file Belanja.php */
