<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Register extends Pupmart_Controller
{

  /**
   * Class Register
   * 
   * @author 
   * @package 
   */

  public function __construct()
  {
    parent::__construct();

    /**
     * Apakah User sudah login ? 
     * jika sudah login makan akan kembalikan kehalaman home
     * 
     */

    $is_login = $this->session->userdata('is_login');

    if ($is_login) {
      redirect(base_url());
      return;
    }
  }


  public function index()
  {
    if (!$_POST) {
      $input = (object) $this->register->getDefaultValues();
    } else {
      $input = (object) $this->input->post(null, true);
    }

    if (!$this->register->validate()) {
      $data = [
        'title' => 'Halaman Register',
        'input' => $input,
        'page' => 'auth/register'
      ];
      $this->view($data);
      return;
    };


    if ($this->register->run($input)) {
      $this->session->set_flashdata('success', ' Berhasil melakukan register');
      redirect(base_url());
    } else {
      $this->session->set_flashdata('error', ' Ooooww! Anda gagal registrasi silahkan dicoba lagi ya');
      redirect(base_url('/register'));
    }
  }
}
/* End of file Register.php */
