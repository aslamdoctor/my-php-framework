<?php 
declare(strict_types=1);
namespace App\Models;

use Core\Db;

class AdminModel{
  private $db;
  private $table_name = 'admins';

  public function __construct()
  {
    $this->db = new Db();
  }

  public function get_all(){
    $admins = $this->db->query("SELECT *, CONCAT(first_name, ' ', last_name) as full_name, IF(last_login='0000-00-00 00:00:00', '-', DATE_FORMAT(last_login, \"%d-%m-%Y %H:%i\")) as last_login 
                              FROM $this->table_name")->fetch_all();
    return $admins;
  }

  public function create($fields){
    $this->db->query("INSERT INTO $this->table_name (first_name, last_name, email, password, salt) VALUES (?, ?, ?, ?, ?)", 
                    $fields['first_name'], $fields['last_name'], $fields['email'], $fields['password'], $fields['salt']);
    return $this->db->last_insert_id();
  }

  public function update($fields){
    if(isset($fields['password']) && !empty($fields['password'])){
      $result = $this->db->query("UPDATE $this->table_name 
                        SET first_name=?, last_name=?, email=?, password=?, salt=? 
                        WHERE ID=?", 
                        $fields['first_name'], $fields['last_name'], $fields['email'], $fields['password'], $fields['salt'], $fields['id']);
    }
    else{
      $result = $this->db->query("UPDATE $this->table_name 
                        SET first_name=?, last_name=?, email=? 
                        WHERE ID=?", 
                        $fields['first_name'], $fields['last_name'], $fields['email'], $fields['id']);
    }
    return $result->affected_rows();
  }

  public function delete($id){
    $result = $this->db->query("DELETE FROM $this->table_name WHERE ID = ? AND type='admin'", $id);
    return $result;
  }
}