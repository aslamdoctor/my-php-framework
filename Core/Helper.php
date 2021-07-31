<?php 
declare(strict_types=1);
namespace Core;

class Helper{
  // Redirect to page/url
  public static function redirect($url){
    header("Location: $url"); 
    exit;
  }

  // Encrypt password
  public static function encrypt_password($password){
    return password_hash($password, PASSWORD_DEFAULT);

    /* Verify password using below code */
    /* password_verify('your_password', $hash) */
  }

  // Generate random password
  public static function generate_password($length = 8){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
  }
  
  // Create slug from string
  public static function create_slug($string){
    $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return $slug;
  }

  // Clean string for security purposes
  public static function clean($str) {
    $str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
    
    // Trim extra spaces
    $str = trim($str);

    // Return the value out of the function.
    return $str;
  }

  // Get file extension
  public static function get_extension($file) {
    $extension = end(explode(".", $file));
    return $extension ? $extension : false;
  }

  // Return JSON response
  public static function response_json($json_data, $response_code = 200){
    http_response_code($response_code);
    header('Content-Type: application/json');
    echo json_encode($json_data);
    exit;
  }

  // Return Text response
  public static function response_text($text_data, $response_code = 200){
    http_response_code($response_code);
    header("Content-Type: text/plain");
    echo $text_data;
    exit;
  }
}