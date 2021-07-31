<?php 
declare(strict_types=1);
namespace Admin\Controllers;

use Core\Helper;
use Rakit\Validation\Validator;

class AdminsController extends \Core\Controller{
  protected $views_dir = __DIR__ ."/../views/";
  private $admin_model;

  public function __construct()
  {
    parent::__construct();

    // Check user logged in before accessing this page
    \Admin\Controllers\LoginController::allow_logged_in();

    $this->admin_model = new \App\Models\AdminModel;
  }


  /**
   * Dashboard
   *
   * @return void
   */
  public function index(){
    $data = array(
      'page_title' => 'Master Admin - Dashboard',
    );
    $this->render($this->views_dir."/index.php", $data, false, $this->views_dir."/master.php");
  }


  /**
   * List Records
   *
   * @return void
   */
  public function list(){
    $data = array(
      'page_title' => 'Master Admin - Admins',
      'css_files' => '<!-- DataTables -->
                      <link rel="stylesheet" href="/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
                      <link rel="stylesheet" href="/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">',
      'js_files' => '<!-- DataTables  & Plugins -->
                    <script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
                    <script src="/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
                    <script src="/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
                    <script src="/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>'
    );
    $data['active_nav'] = 'admins';
    $data['all_admins'] = $this->admin_model->get_all();

    $this->render($this->views_dir."admins/list.php", $data, false, $this->views_dir."master.php");
  }


  /**
   * Get All records for ajax request
   *
   * @return void
   */
  public function ajax_get_all(){
    // initialize query
    $sql = "SELECT ID, first_name, last_name, email, locked, type, CONCAT(first_name, ' ', last_name) as full_name, 
            IF(last_login='0000-00-00 00:00:00', '-', DATE_FORMAT(last_login, \"%d-%m-%Y %H:%i\")) as last_login 
            FROM admins WHERE 1=1";
    $sql_filtered = $sql;
    
    // apply search filter
    if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
      $search_string = " AND ( first_name LIKE '%".$_GET['search']['value']."%' OR last_name LIKE '%".$_GET['search']['value']."%' OR email LIKE '%".$_GET['search']['value']."%')";
      $sql_filtered .= $search_string;
      $sql .= $search_string;
    }
    
    // order by parameters
    $order_column = $_GET['order'][0]['column'];
    $order_by = $_GET['columns'][$order_column]['data'];
    $order = $_GET['order'][0]['dir'];
    $sql .= " ORDER BY $order_by $order";

    // pagination parameters
    $start = $_GET['start'];
    $length = $_GET['length'];
    $sql .= " LIMIT $start, $length";
    
    $all_admins = $this->db->query($sql)->fetch_all();
    $all_admins_filtered = $this->db->query($sql_filtered)->fetch_all();

    $data = array(
      "recordsTotal" => count($all_admins),
      "recordsFiltered" => count($all_admins_filtered),
      "data" => $all_admins,
    );
    Helper::response_json($data);
  }


  /**
   * Create record form
   *
   * @return void
   */
  public function create(){
    $data = array(
      'page_title' => 'Master Admin - Admins - Create',
      'css_files' => '',
      'js_files' => ''
    );
    $data['active_nav'] = 'admins';
    $this->render($this->views_dir."admins/create.php", $data, false, $this->views_dir."master.php");
  }


  /**
   * Save from create record form
   *
   * @return void
   */
  public function create_save(){
    $validator = new Validator; 
    // create validation
    $validation = $validator->make($_POST + $_FILES, [
        'first_name'  => 'required|min:3',
        'last_name'  => 'required|min:3',
        'email'  => 'required|email',
        'password'  => 'required|min:6',
        'confirm_password' => 'required|same:password',
    ]);
    /* $validation->setMessages([
      'name:required' => 'Please enter :attribute',
    ]); */

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
        $errors = $validation->errors();
        Helper::response_json($errors->firstOfAll(), 500);
    } else {
        // Get all request data
        $first_name = Helper::clean($_POST['first_name']);
        $last_name = Helper::clean($_POST['last_name']);
        $email = Helper::clean($_POST['email']);
        $password = Helper::clean($_POST['password']);

        // encrypt password here
        $salt = Helper::generate_password(); // Important: this function is generate_password() but here used to generate Salt
        $cryptpassword = md5($salt.$password);

        // Check if email already exists
        $admins = $this->db->query('SELECT * FROM admins WHERE email = ?', $email)->fetch_array();
        if(count($admins) > 0){
          Helper::response_text('Email already exists', 501);  
        }

        // Save record
        $inser_id = $this->admin_model->create(array(
          'first_name' => $first_name,
          'last_name' => $last_name,
          'email' => $email,
          'password' => $cryptpassword,
          'salt' => $salt,
        ));

        Helper::response_json(array('id' => $inser_id));
    }
  }

  

  /**
   * Update record form
   *
   * @return void
   */
  public function update($id){
    $data = array(
      'page_title' => 'Master Admin - Admins - Update',
      'css_files' => '',
      'js_files' => ''
    );
    $data['active_nav'] = 'admins';
    
    // Check if name already exists
    $admin = $this->db->query('SELECT * FROM admins WHERE ID = ?', $id)->fetch_array();
    if(!$admin){
      Helper::response_text('Record not found', 404);  
    }

    $data['admin'] = $admin;

    $this->render($this->views_dir."admins/update.php", $data, false, $this->views_dir."master.php");
  }
  
  

  /**
   * Save from update record form
   *
   * @return void
   */
  public function update_save(){
    $change_password_switch = '';
    if(isset($_POST['change_password_switch']) && !empty($_POST['change_password_switch'])){
      $change_password_switch = Helper::clean($_POST['change_password_switch']);
    }

    $validator = new Validator; 
    // create validation
    $validation_rules = [
        'first_name'  => 'required|min:3',
        'last_name'  => 'required|min:3',
        'email'  => 'required|email',
    ];

    if(!empty($change_password_switch)){
      $validation_rules['password'] = 'required|min:6';
      $validation_rules['confirm_password'] = 'required|same:password';
    }

    $validation = $validator->make($_POST + $_FILES, $validation_rules);
    /* $validation->setMessages([
      'name:required' => 'Please enter :attribute',
    ]); */

    // then validate
    $validation->validate();

    if ($validation->fails()) {
      // handling errors
        $errors = $validation->errors();
        Helper::response_json($errors->firstOfAll(), 500);
    } else {
        // Get all request data
        $id = Helper::clean($_POST['id']);
        $first_name = Helper::clean($_POST['first_name']);
        $last_name = Helper::clean($_POST['last_name']);
        $email = Helper::clean($_POST['email']);
        
        if(!empty($change_password_switch)){
          $password = Helper::clean($_POST['password']);
        }

        // Check if email already exists
        $admins = $this->db->query('SELECT * FROM admins WHERE email = ? AND ID<>?', $email, $id)->fetch_array();
        if(count($admins) > 0){
          Helper::response_text('Email already exists', 501);  
        }

        // Save record
        $save_data = array(
          'id' => $id,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'email' => $email,
        );

        if(!empty($change_password_switch)){
          // encrypt password here
          $salt = Helper::generate_password(); // Important: this function is generate_password() but here used to generate Salt
          $cryptpassword = md5($salt.$password);
          
          $save_data['password'] = $cryptpassword;
          $save_data['salt'] = $salt;
        }

        $this->admin_model->update($save_data);

        Helper::response_json(array('id' => $id));
    }
  }


   /**
   * Delete record
   *
   * @return void
   */
  public function delete(){
    $id = Helper::clean($_POST['id']);
    
    // Check if name already exists
    $admin = $this->db->query('SELECT * FROM admins WHERE ID = ? AND type = ?', $id, 'admin')->fetch_array();
    if(!$admin){
      Helper::response_text('Record not found', 404);  
    }

    $this->admin_model->delete($id);
    Helper::response_text('Deleted');
  }
}