<?php 
declare(strict_types=1);
namespace App;

class Config{
  const MODE='development';
  const DB_HOST='localhost';
  const DB_USER='admin';
  const DB_PASS='admin';
  const DB_NAME='testdb';
  const BASE_URL='http://localhost/phptraining/';
}


/******* USAGE *******

use App\Config;
echo Config::DB_HOST;

*/
?>