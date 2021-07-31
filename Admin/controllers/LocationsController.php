<?php 
declare(strict_types=1);
namespace Admin\Controllers;

use Core\Helper;
use Rakit\Validation\Validator;


class LocationsController extends \Core\Controller{
  protected $views_dir = __DIR__ ."/../views/";
  private $location_model;

  public function __construct()
  {
    parent::__construct();

    // Check user logged in before accessing this page
    \Admin\Controllers\LoginController::allow_logged_in();

    $this->location_model = new \App\Models\LocationModel;
  }

  
  /**
   * List Records
   *
   * @return void
   */
  public function list(){
    $data = array(
      'page_title' => 'Master Admin - Locations',
      'css_files' => '<!-- DataTables -->
                      <link rel="stylesheet" href="/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
                      <link rel="stylesheet" href="/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">',
      'js_files' => '<!-- DataTables  & Plugins -->
                    <script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
                    <script src="/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
                    <script src="/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
                    <script src="/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>'
    );
    $data['active_nav'] = 'locations';

    $data['all_locations'] = $this->location_model->get_all();

    $this->render($this->views_dir."locations/list.php", $data, false, $this->views_dir."master.php");
  }
  

  /**
   * Get All records for ajax request
   *
   * @return void
   */
  public function ajax_get_all(){
    // initialize query
    $sql = "SELECT * FROM locations WHERE 1=1";
    $sql_filtered = $sql;
    
    // apply search filter
    if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
      $search_string = " AND name LIKE '%".$_GET['search']['value']."%'";
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
    
    $all_locations = $this->db->query($sql)->fetch_all();
    $all_locations_filtered = $this->db->query($sql_filtered)->fetch_all();

    $data = array(
      "recordsTotal" => count($all_locations),
      "recordsFiltered" => count($all_locations_filtered),
      "data" => $all_locations,
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
      'page_title' => 'Master Admin - Locations - Create',
      'css_files' => '',
      'js_files' => ''
    );
    $data['active_nav'] = 'locations';

    $this->render($this->views_dir."locations/create.php", $data, false, $this->views_dir."master.php");
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
        'name'  => 'required|min:3',
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
        $name = Helper::clean($_POST['name']);

        // Check if name already exists
        $locations = $this->db->query('SELECT * FROM locations WHERE name = ?', $name)->fetch_array();
        if(count($locations) > 0){
          Helper::response_text('Location name already exists', 501);  
        }

        // Save record
        $inser_id = $this->location_model->create(array(
          'name' => $name
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
      'page_title' => 'Master Admin - Locations - Update',
      'css_files' => '',
      'js_files' => ''
    );

    $data['active_nav'] = 'locations';
    
    // Check if name already exists
    $location = $this->db->query('SELECT * FROM locations WHERE ID = ?', $id)->fetch_array();
    if(!$location){
      Helper::response_text('Record not found', 404);  
    }

    $data['location'] = $location;

    $this->render($this->views_dir."locations/update.php", $data, false, $this->views_dir."master.php");
  }

  

  /**
   * Save from update record form
   *
   * @return void
   */
  public function update_save(){
    $validator = new Validator; 
    // create validation
    $validation = $validator->make($_POST + $_FILES, [
        'name'  => 'required|min:3',
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
        $id = Helper::clean($_POST['id']);
        $name = Helper::clean($_POST['name']);

        // Check if name already exists
        $locations = $this->db->query('SELECT * FROM locations WHERE name = ? AND ID<>?', $name, $id)->fetch_array();
        if(count($locations) > 0){
          Helper::response_text('Location name already exists', 501);  
        }

        // Save record
        $this->location_model->update(array(
          'id' => $id,
          'name' => $name
        ));

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
    $location = $this->db->query('SELECT * FROM locations WHERE ID = ?', $id)->fetch_array();
    if(!$location){
      Helper::response_text('Record not found', 404);  
    }

    $this->location_model->delete($id);
    Helper::response_text('Deleted');
  }
}