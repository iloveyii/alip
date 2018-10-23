<?php
require_once 'vendor/autoload.php';
require_once 'config/db.php';

use App\Models\Database;

$tableName = 'post';
$sql = "CREATE table $tableName(
  id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR( 150 ) NOT NULL,
  description TEXT NOT NULL);";

Database::connect()->exec($sql);
print ("Created table $tableName. " . PHP_EOL);
