<?php

namespace aplication\lib;

use PDO;
use aplication\lib\Regystry;

/*
* Класс обеспечивает коммуникацию с базой данных
*
* The class provides communication with the database
*/

class DB {

  /*
  * Функция создает указатель на соединение с базой данных
  * и сохраняет значение в соответствующую переменную
  *
  * The function creates a pointer to the connection to the database
  * and save the value in the Regystry object
  */

  static function get_DB_in_Registry(){
    $obj = Registry::getInstance();

  // Получаем параметры конфигурации доступа к базе данных
  // Get the parameters of the configuration of access to the database
    include(ROOT . '/aplication/config/database.php');

    require_once("aplication/config/setup.php");
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //Сохраняем значение в объект Regystry
  //save the value in the Regystry object
    $obj->changeProperty('DB', $db);
  }
}
