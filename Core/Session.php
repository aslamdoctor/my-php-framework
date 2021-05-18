<?php 
declare(strict_types=1);
namespace Core;

class Session{
  // Start session automatically on creating object
  public function __construct(){
    session_start();
  }

  // Set session value
  public function set($key, $value){
    return $_SESSION[$key] = $value;
  }

  // Get session value
  public function get($key){
    if(isset($_SESSION[$key])){
      return $_SESSION[$key];
    }
    else{
      return false;
    }
  }

  // Delete session value
  public function delete($key){
    unset($_SESSION[$key]);
  }

  // Destroy all sessions 
  public function destroy(){
    session_destroy();
  }
}


/******* USAGE *******

$session = new \Core\Session;

$session->set('user_id', $id);

echo $session->get('user_id');

$session->delete('user_id');

$session->destroy();

*/
?>