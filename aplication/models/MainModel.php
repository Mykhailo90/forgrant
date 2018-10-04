<?php

namespace aplication\models;

use aplication\core\Model;
use aplication\lib\Registry;
use PDO;

class MainModel extends Model
{
  public function get_categories()
  {
      $link = Registry::getInstance()->getProperty('DB');
      $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM categories";
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
    // public function get_data($data)
    // {
    //   $link = Registry::getInstance()->getProperty('DB');
    //   $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   if (isset($data['user_login'])){
    //     $login = $data['user_login'];
    //     $sql = "SELECT user_id FROM users_info WHERE name = ?";
    //     $result = $link->prepare($sql);
    //     $result->execute(array($login));
    //     $res = $result->fetch(PDO::FETCH_ASSOC);
    //     if ($res['user_id'] == ""){
    //       echo "Пользователя с данным логином не существует!";
    //       exit();
    //     }
    //     else {
    //       // получаем количество фотографий
    //       $sql = "SELECT COUNT(*) FROM users_images WHERE user_id = ?";
    //       $result = $link->prepare($sql);
    //       $result->execute(array($res['user_id']));
    //       $total = $result->fetchColumn();
    //
    //       if ($total == 0){
    //         echo "К сожалению данный пользователь еще не опубликовал своих фотографий!";
    //         exit();
    //       }
    //     }
    //   }
    //   else{
    //     $sql = "SELECT COUNT(*) FROM users_images";
    //     $result = $link->prepare($sql);
    //     $result->execute();
    //     $total = $result->fetchColumn();
    //   }
    //
    //   $pagination_list = new Pagination($data['current_page'], $data['per_page'], $total);
    //
    //   $link = Registry::getInstance()->getProperty('DB');
    //   $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   $start = $pagination_list->getStart();
    //   if (isset($login)){
    //     $sql = "SELECT * FROM users_images, users_info WHERE name = ? AND users_images.user_id = users_info.user_id
    //     ORDER BY img_time DESC LIMIT $pagination_list->perpage OFFSET $start";
    //     $result = $link->prepare($sql);
    //     $result->execute(array($login));
    //   }
    //   else{
    //     $sql = "SELECT * FROM users_images ORDER BY img_time DESC LIMIT $pagination_list->perpage OFFSET $start";
    //     $result = $link->prepare($sql);
    //     $result->execute();
    //   }
    //
    //
    //   $res = $result->fetchAll(PDO::FETCH_ASSOC);
    //   echo '<div class="img_list" data="'. $total .'">';
    //   // Добавить вывод значка лайков и количество для конкретной фото, добавить значок коментов и их количество для зареганых пользователей
    //   foreach ($res as $val) {
    //     echo '<div class="show" onclick="new_window('.$val['img_id'].')"><img width="120" id="'.$val['img_id'].'" data="'.$val['user_id'].'" src="'.$val['img_path'].'"></div>';
  // }
  //     echo '</div>';
  //     echo '<div class="pagin_div">';
  //     echo $pagination_list;
  //     echo "</div>";
  //   }
}
