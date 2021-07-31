<?php
declare(strict_types=1);
namespace Core;

class Db {
  protected $connection;
  protected $query;
  protected $show_errors = TRUE;
  protected $query_closed = TRUE;
  public $query_count = 0;

  // Connect to db on creating an object
  public function __construct($dbhost="", $dbuser="", $dbpass="", $dbname="", $charset = 'utf8') {
    $dbhost = empty($dbhost) ? $_ENV['DB_HOST'] : $dbhost;
    $dbuser = empty($dbuser) ? $_ENV['DB_USER'] : $dbuser;
    $dbpass = empty($dbpass) ? $_ENV['DB_PASS'] : $dbpass;
    $dbname = empty($dbname) ? $_ENV['DB_NAME'] : $dbname;
    
    $this->connection = new \mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($this->connection->connect_error) {
      $this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
    }
    $this->connection->set_charset($charset);
  }

  // Run sql query
  public function query($query){
    if (!$this->query_closed) {
      $this->query->close();
    }
    if ($this->query = $this->connection->prepare($query)) {
      if (func_num_args() > 1) {
        $x = func_get_args();
        $args = array_slice($x, 1);
        $types = '';
        $args_ref = array();
        foreach ($args as $k => &$arg) {
          if (is_array($args[$k])) {
            foreach ($args[$k] as $j => &$a) {
              $types .= $this->_gettype($args[$k][$j]);
              $args_ref[] = &$a;
            }
          } else {
            $types .= $this->_gettype($args[$k]);
            $args_ref[] = &$arg;
          }
        }
        array_unshift($args_ref, $types);
        call_user_func_array(array($this->query, 'bind_param'), $args_ref);
      }
      $this->query->execute();
      if ($this->query->errno) {
        $this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);
      }
      $this->query_closed = FALSE;
      $this->query_count++;
    } else {
      $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
    }
    return $this;
  }

  // Fetch all rows
  public function fetch_all($callback = null) {
    $params = array();
    $row = array();
    $meta = $this->query->result_metadata();
    while ($field = $meta->fetch_field()) {
      $params[] = &$row[$field->name];
    }
    call_user_func_array(array($this->query, 'bind_result'), $params);
    $result = array();
    while ($this->query->fetch()) {
      $r = array();
      foreach ($row as $key => $val) {
        $r[$key] = $val;
      }
      if ($callback != null && is_callable($callback)) {
        $value = call_user_func($callback, $r);
        if ($value == 'break') break;
      } else {
        $result[] = $r;
      }
    }
    $this->query->close();
    $this->query_closed = TRUE;
    return $result;
  }

  // Fetch all rows in array format
  public function fetch_array() {
    $params = array();
    $row = array();
    $meta = $this->query->result_metadata();
    while ($field = $meta->fetch_field()) {
      $params[] = &$row[$field->name];
    }
    call_user_func_array(array($this->query, 'bind_result'), $params);
    $result = array();
    while ($this->query->fetch()) {
      foreach ($row as $key => $val) {
        $result[$key] = $val;
      }
    }
    $this->query->close();
    $this->query_closed = TRUE;
    return $result;
  }

  // Close database connection
  public function close() {
    return $this->connection->close();
  }

  // Get number of records
  public function num_rows() {
    $this->query->store_result();
    return $this->query->num_rows;
  }

  // Get affected rows
  public function affected_rows() {
    return $this->query->affected_rows;
  }

  // Get last insert id
  public function last_insert_id() {
    return $this->connection->insert_id;
  }

  // Show database error
  public function error($error) {
    if ($this->show_errors) {
      exit($error);
    }
  }

  private function _gettype($var) {
    if (is_string($var)) return 's';
    if (is_float($var)) return 'd';
    if (is_int($var)) return 'i';
    return 'b';
  }
}

/*
// Connect to Database:
$db = new \Core\Db($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);


// Fetch a record from a database:
$account = $db->query('SELECT * FROM accounts WHERE username = ? AND password = ?', 'test', 'test')->fetch_array();
// OR
$account = $db->query('SELECT * FROM accounts WHERE username = ? AND password = ?', array('test', 'test'))->fetch_array();


// Fetch multiple records from a database:
$accounts = $db->query('SELECT * FROM accounts')->fetch_all();


// Using callback:
$db->query('SELECT * FROM accounts')->fetch_all(function($account) {
  echo $account['name'];
});


// Get the number of rows:
$accounts = $db->query('SELECT * FROM accounts');
echo $accounts->num_rows();


// Get the affected number of rows:
$insert = $db->query('INSERT INTO accounts (username,password,email,name) VALUES (?,?,?,?)', 'test', 'test', 'test@gmail.com', 'Test');
echo $insert->affected_rows();


// Get the total number of queries:
echo $db->query_count;


// Get the last insert ID:
echo $db->last_insert_id();


// Close the database:
$db->close();

*/