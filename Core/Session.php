<?php 
declare(strict_types=1);
namespace Core;

class Session{
  // Set session value
  public static function set($key, $value){
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    return $_SESSION[$key] = $value;
  }

  // Get session value
  public static function get($key){
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if(isset($_SESSION[$key])){
      return $_SESSION[$key];
    }
    else{
      return false;
    }
  }

  // Delete session value
  public static function delete($key){
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    unset($_SESSION[$key]);
  }

  // Destroy all sessions 
  public static function destroy(){
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    
    session_destroy();
  }
}


/******* USAGE *******

$session = new \Core\Session;

$session::set('user_id', $id);

echo $session::get('user_id');

$session::delete('user_id');

$session::destroy();

*/
?>