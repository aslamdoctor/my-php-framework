<?php 
declare(strict_types=1);
namespace Admin\Controllers;

use Core\Helper;
use Core\Session;
use Rakit\Validation\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class LoginController extends \Core\Controller{
  protected $views_dir = __DIR__ ."/../views/";
  private $admin_model;

  public function __construct()
  {
    parent::__construct();

    $this->admin_model = new \App\Models\AdminModel;
  }


  /**
   * Allow only logged in users otherwise redirect to login page
   */
  public static function allow_logged_in(){
    if(!Session::get('user_id')){
      Helper::redirect("/system-admin/login");
    }
  }


  /**
   * Allow only logged out users otherwise redirect to dashboard
   */
  public static function allow_logged_out(){
    if(Session::get('user_id')){
      Helper::redirect("/system-admin/");
    }
  }


  /**
   * Login
   *
   * @return void
   */
  public function login(){
    $this->allow_logged_out();

    $data = array(
      'page_title' => 'Master Admin - Login',
      'css_files' => '',
      'js_files' => ''
    );

    $this->render($this->views_dir."login.php", $data, false, $this->views_dir."login-master.php");
  }


  /**
   * Login - Submit
   *
   * @return void
   */
  public function login_submit(){
    $this->allow_logged_out();

    $validator = new Validator; 
    // create validation
    $validation = $validator->make($_POST + $_FILES, [
        'email'  => 'required|email',
        'password'  => 'required|min:6',
    ]);

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
        $errors = $validation->errors();
        Helper::response_json($errors->firstOfAll(), 500);
    } else {
      // Get all request data
      $email = Helper::clean($_POST['email']);
      $password = Helper::clean($_POST['password']);

      // Get salt using email
      $salt_sql = $this->db->query('SELECT salt FROM admins WHERE email = ?', $email)->fetch_array();
      if(count($salt_sql) > 0){
        $salt = $salt_sql['salt'];
        $cryptpassword = md5($salt.$password);

        $validate_sql = $this->db->query('SELECT * FROM admins WHERE email = ? AND password = ?', $email, $cryptpassword)->fetch_array();
        if(count($validate_sql) > 0){
          $id = $validate_sql['ID'];

          // update last_login record
          $this->db->query("UPDATE admins SET last_login=NOW() WHERE ID=?", $id);

          // update session value
          Session::set('user_id', $id);
          Session::set('user', $validate_sql);

          Helper::response_json(array(
            'id' => $id,
            'redirect_to' => '/system-admin/',
          ));
        }
        else{
          Helper::response_text('Invalid email or password entered', 501);    
        }
      }
      else{
        Helper::response_text('Email not found', 501);  
      }
    }
  }


  /**
   * Logout
   *
   * @return void
   */
  public function logout(){
    Session::destroy();
    Helper::redirect("/system-admin/login");
  }


  /**
   * Forgot Password
   *
   * @return void
   */
  public function forgot_password(){
    $this->allow_logged_out();

    $data = array(
      'page_title' => 'Master Admin - Forgot Password',
      'css_files' => '',
      'js_files' => ''
    );

    $this->render($this->views_dir."forgot_password.php", $data, false, $this->views_dir."login-master.php");
  }


  /**
   * Forgot Password - Submit
   *
   * @return void
   */
  public function forgot_password_submit(){
    $this->allow_logged_out();

    $validator = new Validator; 
    // create validation
    $validation = $validator->make($_POST + $_FILES, [
        'email'  => 'required|email',
    ]);

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
        $errors = $validation->errors();
        Helper::response_json($errors->firstOfAll(), 500);
    } else {
      // Get all request data
      $email = Helper::clean($_POST['email']);

      // Check if email exists
      $email_exists_email = $this->db->query('SELECT * FROM admins WHERE email = ?', $email)->fetch_array();
      if(count($email_exists_email) > 0){
        $password = Helper::generate_password(6);

        // encrypt password here
        $salt = Helper::generate_password(); // Important: this function is generate_password() but here used to generate Salt
        $cryptpassword = md5($salt.$password);

        // update user record
        $this->db->query("UPDATE admins SET salt=?, password=? WHERE email=?", $salt, $cryptpassword, $email);

        // Send email
        $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

        //From email address and name
        $mail->From = $_ENV['FROM_EMAIL'];
        $mail->FromName = $_ENV['FROM_NAME'];

        //To address and name
        $mail->addAddress($email_exists_email['email'], $email_exists_email['first_name'].' '.$email_exists_email['last_name']);

        //Address to which recipient will reply
        $mail->addReplyTo($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']);


        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = "Your ".$_ENV['SITE_NAME']." password has been reset";
        $mail->Body = "Your password for ".$_ENV['SITE_NAME']." has been reset. Here are your login details: <br/><br/>"
        . "E-mail: ".$email_exists_email['email']."<br/>"
		    . "Password: ".$password." <br/>"
        . "<br/><br/><br/>This is an auto-generated e-mail. Please do not reply to it.";

        try {
          $mail->send();
        } catch (Exception $e) {
          Helper::response_text("Mailer Error: " . $mail->ErrorInfo, 501);  
        }

        Helper::response_json(array(
          'id' => $email_exists_email['ID']
        ));
      }
      else{
        Helper::response_text('Email not found', 501);  
      }
    }
  }
}