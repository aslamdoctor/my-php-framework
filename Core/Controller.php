<?php 
declare(strict_types=1);
namespace Core;
use App\Config;

class Controller {
  public function render($view_file, $data = array(), $store = false, $master = '') {
    // inject some default data here
    $data['base_url'] = $this->base_url();

    extract($data);

    ob_start();

    if(!empty($master) && file_exists(__DIR__.'/../App/views/'.$master)){
      // check if master template provider
      $content = file_get_contents(__DIR__.'/../App/views/'.$master);

      $content = str_replace('{{ meta_tags }}', @$data['meta_tags'], $content);

      $content = str_replace('{{ page_title }}', @$data['page_title'], $content);

      $css_files = !empty($data['css_files']) ? $data['css_files'] : '';
      $content = str_replace('{{ css_files }}', $css_files, $content);

      ob_start();
      if(is_array($view_file)){
        foreach($view_file as $the_view_file){
          include(__DIR__ ."/../App/views/".$the_view_file);
        }
      }
      else{
        include(__DIR__ ."/../App/views/".$view_file);
      }
      $view_content = ob_get_clean();

      $content = str_replace('{{ view_file }}', $view_content, $content);

      $js_files = !empty($data['js_files']) ? $data['js_files'] : '';
      $content = str_replace('{{ js_files }}', $js_files, $content);
      
      echo $content;
    }
    else{
      // without master template
      if(is_array($view_file)){
        foreach($view_file as $the_view_file){
          include(__DIR__ ."/../App/views/".$the_view_file);
        }
      }
      else{
        include(__DIR__ ."/../App/views/".$view_file);
      }
    }

    // check if print or return string
    if($store)  
      return ob_get_clean();
    else
      ob_end_flush();
  }

  public function base_url(){
    return Config::BASE_URL;
  }
}


/**** USAGE **** 
 
 // Render View file
 $data = array(
    'page_title' => 'Home Page',
    'meta_tags' => 'meta tags ...', // optional
    'css_files' => 'css files ...', // optional
    'js_files' => 'js files ...', // optional
    'name' => 'Aslam', // test data
  );
  
  $this->render("index.php", $data, false, 'master.php');
  
  or

  $this->render([
    "template-parts/header.php", 
    "index.php",
    "template-parts/footer.php"
  ], $data, false, 'master.php');

*/