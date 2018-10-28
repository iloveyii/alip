<?php
require_once 'vendor/autoload.php';
require_once 'config/app.php';

use App\Models\Database;

$tableName = 'post';
$dropTable = "DROP TABLE IF EXISTS {$tableName}";
Database::connect()->exec($dropTable);

$sql = "CREATE table $tableName(
  id INT( 11 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR( 150 ) NOT NULL,
  description TEXT NOT NULL);";

Database::connect()->exec($sql);
print ("Created table $tableName. " . PHP_EOL);
