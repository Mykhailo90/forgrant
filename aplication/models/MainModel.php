<?php

namespace aplication\models;

use aplication\core\Model;
use aplication\lib\Registry;
use PDO;

class MainModel extends Model
{
  public function set_price($prod_id, $from_date, $to_date, $now_date, $price){
    $link = Registry::getInstance()->getProperty('DB');
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO price (id_position, price, from_date, to_date, update_date)
              VALUES (?, ?, ?, ?, ?);";
      $result = $link->prepare($sql);
      $result->execute(array($prod_id, $price, $from_date, $to_date, $now_date));
  }

  public function update_type_price($prod, $type){
    $link = Registry::getInstance()->getProperty('DB');
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT count(*) FROM price_condition WHERE id_position = ?";
    $result = $link->prepare($sql);
    $result->execute(array($prod));
    $result = $result->fetchColumn();
    
    if($result){
      $sql = "UPDATE price_condition SET id_condition_search = ?
            WHERE id_position = ?";
      $result = $link->prepare($sql);
      $result->execute(array($type, $prod));
    }
    else{
      $sql = "INSERT INTO price_condition (id_position, id_condition_search)
              VALUES (?, ?);";
      $result = $link->prepare($sql);
      $result->execute(array($prod, $type));
    }
  }

  public function get_categories()
  {
      $link = Registry::getInstance()->getProperty('DB');
      $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM categories;";
      $result = $link->prepare($sql);
      $result->execute();
      $res = $result->fetchAll(PDO::FETCH_ASSOC);
      return $res;
  }

  public function get_products($categ_id){
    $link = Registry::getInstance()->getProperty('DB');
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id, name_position FROM sales_positions WHERE id_category = ?";
    $result = $link->prepare($sql);
    $result->execute(array($categ_id));
    $res = $result->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }
   
}
