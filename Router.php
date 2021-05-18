<?php 
declare(strict_types=1);
namespace Core;

Class Router{
  public function get($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'GET' ){ $this->route($route, $path_to_include); }  
  }

  public function post($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ){ $this->route($route, $path_to_include); }    
  }

  public function put($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'PUT' ){ $this->route($route, $path_to_include); }    
  }

  public function patch($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'PATCH' ){ $this->route($route, $path_to_include); }    
  }

  public function delete($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'DELETE' ){ $this->route($route, $path_to_include); }    
  }

  public function any($route, $path_to_include){ $this->route($route, $path_to_include); }

  public function route($route, $path_to_include){
    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    if($route == "/404"){
      include_once("$ROOT/$path_to_include");
      exit();
    }  
    $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
    $request_url = rtrim($request_url, '/');
    $request_url = strtok($request_url, '?');
    $route_parts = explode('/', $route);
    if(is_bool($request_url)){
      $request_url_parts = [];
    }
    else{
      $request_url_parts = explode('/', $request_url);
    }
    array_shift($route_parts);
    array_shift($request_url_parts);
    if( $route_parts[0] == '' && count($request_url_parts) == 0 ){
      include_once("$ROOT/$path_to_include");
      exit();
    }
    if( count($route_parts) != count($request_url_parts) ){ return; }  
    $parameters = [];
    for( $i = 0; $i < count($route_parts); $i++ ){
      $route_part = $route_parts[$i];
      if( preg_match("/^[$]/", $route_part) ){
        $route_part = ltrim($route_part, '$');
        array_push($parameters, $request_url_parts[$i]);
        $$route_part=$request_url_parts[$i];
      }
      else if( $route_parts[$i] != $request_url_parts[$i] ){
        return;
      } 
    }
    include_once("$ROOT/$path_to_include");
    exit();
  }

  public function out($text){echo htmlspecialchars($text);}

  public function set_csrf(){
    $csrf_token = bin2hex(random_bytes(25));
    $_SESSION['csrf'] = $csrf_token;
    echo '<input type="hidden" name="csrf" value="'.$csrf_token.'">';
  }

  public function is_csrf_valid(){
    if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
    if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
    return true;
  }
}

// Ref: https://github.com/phprouter/main

/******* USAGE *******

$router = new \Core\Router;

$router->get('/', 'views/index.php');
$router->get('/about', 'views/about.php');


// The $id will be available in user.php
$router->get('/user/$id', 'views/user.php');

// always define this route last
$router->any('/404','views/404.php');
*/
?>