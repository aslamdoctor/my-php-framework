<?php 
declare(strict_types=1);
namespace App\Controllers;

class PagesController extends \Core\Controller{
  protected $views_dir = __DIR__ ."/../views/";
  
  public function index(){
    $data = array(
      'page_title' => 'Home Page',
      'meta_tags' => 'meta tags ...',
      'css_files' => 'css files ...',
      'js_files' => 'js files ...',
      'name' => 'Aslam',
    );

    
    $this->render($this->views_dir."/index.php", $data, false, $this->views_dir."/master.php");
  }
  
  public function about(){
    echo 'About Page';
  }
  
  public function users(){
    $user_model = new \App\Models\UserModel;
    var_dump($user_model->get_all());
  }
  
  public function user($id){
    echo 'ID is '.$id;
  }


  public function page_404(){
    header('HTTP/1.1 404 Not Found');
    echo 404;
  }

}