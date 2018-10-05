<?php

namespace aplication\controllers;

use aplication\core\Controller;
use aplication\core\View;

/*
* Класс обеспечивает взаимодействие между моделью и отображением главной страницы
*
* The class provides the interaction between the model and the display of the main page
*/

class MainController extends Controller{
  function __construct($parameters){
// Передаем в родительский класс параметры для инициализации модели
// Pass to the parent class the parameters for initializing the model
		parent::__construct($parameters);
		  $this->view = new View($parameters);
	 }

// Метод для получения данных необходимых для отображения главной страницы
// Method for getting the data required to display the main page
    function indexAction(){
      // echo "IN Controller";
			$title = 'Forgrant';
      $data['categories'] = $this->model->get_categories();

      if (isset($_POST['position_id'])){
        //Обновить значение типа объявления цены
        $prod_id = $_POST['position_id'];
        $type_id = $_POST['type_price'];
        $this->model->update_type_price($prod_id, $type_id);
        //Проверить наличие поля цена, если не пустое, внести
        //информацию в БД
        if (isset($_POST['price']) && !empty($_POST['price'])){
          $price = $_POST['price'];
          $to_date = "2038-01-18";
          $from_date = date("Y-m-d");
          if (isset($_POST['to_date']) && !empty($_POST['to_date'])){
            $to_date = $_POST['to_date'];
          }
          if (isset($_POST['from_date']) && !empty($_POST['from_date'])){
            $to_date = $_POST['to_date'];
          }
          $this->model->set_price($prod_id, $from_date, $to_date, $price);
        }
       
        exit();
      }

      if (isset($_POST['category_id']) &&
          !empty($_POST['category_id']) &&
          is_numeric($_POST['category_id']))
      {
        $data['products'] = $this->model->get_products($_POST['category_id']);
        $json = json_encode($data);
          echo $json;
        exit();
      }
      $this->view->render($title, $data);
    }
  }
?>
