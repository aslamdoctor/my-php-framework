<?php 
declare(strict_types=1);
namespace App\Models;

use Core\Db;

class LocationModel{
  private $db;
  private $table_name = 'locations';

  public function __construct()
  {
    $this->db = new Db();
  }

  public function get_all(){
    $locations = $this->db->query("SELECT * FROM $this->table_name")->fetch_all();
    return $locations;
  }

  public function create($fields){
    $this->db->query("INSERT INTO $this->table_name (name) VALUES (?)", $fields['name']);
    return $this->db->last_insert_id();
  }

  public function update($fields){
    $result = $this->db->query("UPDATE $this->table_name 
                      SET name=? 
                      WHERE ID=?", 
                      $fields['name'], $fields['id']);
    return $result->affected_rows();
  }

  public function delete($id){
    $result = $this->db->query("DELETE FROM $this->table_name WHERE ID = ?", $id);
    return $result;
  }
}