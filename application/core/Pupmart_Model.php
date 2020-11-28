<?php

/**
 * Class Pupmart_Model
 * Membuat Query Builder supaya synatx dalam Models tidak terlalu panjang 
 * Dan Tinggal dipanggil saja dari Folder core ini
 * @author Almarup21 <https://github.com/almarup21>
 * @package ${NAMESPACE}
 */

use function PHPSTORM_META\type;

defined('BASEPATH') or exit('No direct script access allowed');

class Pupmart_Model extends CI_Model
{
  protected $table = '';

  public function __construct()
  {
    parent::__construct();
    if (!$this->table) {
      // Jika tabel kosong 
      $this->table = strtolower(
        // Secra otomotis akan mencari suata nama Kelas model yang kita gunakan
        str_replace('_model', '', get_class($this))
      );
    }
  }


  public function validate()
  {
    /**
     * Fungsi Validasi Input
     * Peraturan Dideklarasikan dalam masing-masing model
     * @author Almarup21 <https://github.com/almarup21>
     * @package ${NAMESPACE}
     */

    $this->load->library('form_validation');

    $this->form_validation->set_error_delimeters(
      '<small class="form-text text-danger">',
      '</small>'
    );

    $validationRules = $this->getValidationRules();
    $this->form_validation->set_rules($validationRules);
    return $this->form_validation->run();
  }

  public function select($column)
  {
    $this->db->select($column);
    return $this;
  }

  public function where($column, $condition)
  {
    $this->db->where($column, $condition);
    return $this;
  }

  public function like($column, $condition)
  {
    $this->db->like($column, $condition);
    return $this;
  }

  public function orLike($column, $condition)
  {
    $this->db->or_like($column, $condition);
    return $this;
  }

  public function join($table, $type = 'left')
  {
    $this->db->join($table, "$this->table.id_$table = $table.id", $type);
    return $this;
  }

  public function orderBy($column, $order = 'asc')
  {
    $this->db->order_by($column, $order);
    return $this;
  }

  public function first()
  {
    return $this->db->get($this->table)->row();
  }

  public function getAll()
  {
    return $this->db->get($this->table)->result();
  }

  public function count()
  {
    return $this->db->count_all_results($this->table);
  }

  public function create($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update($data)
  {
    return $this->db->update($this->table, $data);
  }

  public function delete()
  {
    $this->db->delete($this->table);
    return $this->db->affected_rows();
  }
}

/* End of file Pupmart_Model.php */
