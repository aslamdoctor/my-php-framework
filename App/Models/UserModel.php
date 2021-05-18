<?php 
declare(strict_types=1);
namespace App\Models;

class UserModel{
  public function get_all(){
    return array(
      '1' => array(
        'name' => 'Aslam',
        'email' => 'aslam.doctor@gmail.com'
      ),
      '2' => array(
        'name' => 'John',
        'email' => 'johndoe@example.com'
      ),
    );
  }
}