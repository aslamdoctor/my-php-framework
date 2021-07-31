<?php 
declare(strict_types=1);
namespace App\Models;

use Core\Db;

class UserModel{
  public function get_all(){
    /* $db = new Db();
    $posts = $db->query('SELECT * FROM posts')->fetch_all();
    return $posts; */

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