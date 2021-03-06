<?php

namespace aplication\models;

use aplication\core\Model;
use aplication\lib\Registry;
use PDO;

class MainModel extends Model
{
  public function get_price_for_chart($id, $from, $to){
    $link = Registry::getInstance()->getProperty('DB');
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $day = [];
    $arr1 = [];
    $arr2 = [];
    for ($i = $from; $i < $to; $i++){
      $day[] = $i;
      $sql = "SELECT P.price FROM price AS P
              WHERE P.id_position = ? AND
              ? BETWEEN P.from_date AND P.to_date
              ORDER BY P.update_date DESC LIMIT 1;";
              
       $result = $link->prepare($sql);
       $result->execute(array($id, $i));
       $res = $result->fetch(PDO::FETCH_ASSOC);
       $arr1 [] = $res['price'];

       $sql = "SELECT P.price FROM price AS P
       WHERE P.id_position = ? AND
       ? BETWEEN P.from_date AND P.to_date
       ORDER BY (P.to_date - P.from_date) LIMIT 1;";
       
      $result = $link->prepare($sql);
      $result->execute(array($id, $i));
      $res = $result->fetch(PDO::FETCH_ASSOC);
      $arr2 [] = $res['price'];
    }
    $info['day'] = $day;
    $info['arg1'] = $arr1;
    $info['arg2'] = $arr2;
    return $info;
  }

  public function set_price($prod_id, $from_date, $to_date, $price){
    $now_date = date("Y-m-d H:i:s");
    $link = Registry::getInstance()->getProperty('DB');
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // debug($to_date);

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

  private function get_unique($base){
    $x = [];
    $i = 0;
    $new_res = [];
    foreach ($base as $key => $value) {
      if (!in_array($value['id'], $x))
     {
        $new_res[$i++] = $value;
        $x[] = $value['id'];
      }
    }
    return $new_res;
  }

  public function get_products($categ_id){
    $link = Registry::getInstance()->getProperty('DB');
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    $now_date = date("Y-m-d H:i:s");

    $sql = "SELECT SP.id, SP.name_position, CS.name, P.price
            FROM sales_positions AS SP,
                 condition_search AS CS,
                 price_condition AS PC,
                 price AS P
    WHERE SP.id_category = ? AND
          CS.id = 1 AND
          P.id_position = SP.id AND
          PC.id_condition_search = 1 AND
          PC.id_position = SP.id AND
          ? BETWEEN P.from_date AND P.to_date
          ORDER BY P.update_date DESC";     
          
    $result = $link->prepare($sql);
    $result->execute(array($categ_id, $now_date));
    $res = $result->fetchAll(PDO::FETCH_ASSOC);
    $part1 = $this->get_unique($res);



    $sql = "SELECT SP.id, SP.name_position, CS.name, P.price
            FROM sales_positions AS SP,
                 condition_search AS CS,
                 price_condition AS PC,
                 price AS P
    WHERE SP.id_category = ? AND
          CS.id = 2 AND
          P.id_position = SP.id AND
          PC.id_condition_search = 2 AND
          PC.id_position = SP.id AND
          ? BETWEEN P.from_date AND P.to_date
          ORDER BY (P.to_date - P.from_date)";     
          
    $result = $link->prepare($sql);
    $result->execute(array($categ_id, $now_date));
    $res = $result->fetchAll(PDO::FETCH_ASSOC);
    $part2 = $this->get_unique($res);

     
    $new_res = array_merge($part1, $part2);
   
    return $new_res;
  }
   
}





