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
			$title = 'Forgrant';
      $data['categories'] = $this->model->get_categories();

      if (isset($_POST['chart']) && $_POST['chart'] == 1){
        $id = $_POST['id'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        if ($id && $from && $to){
          $data['products'] = $this->model->get_price_for_chart($id, $from, $to);
          $json = json_encode($data['products']);
            echo $json;
          exit();
        }
        
      }

      if (isset($_POST['position_id'])){
        //Update value of type
        $prod_id = $_POST['position_id'];
        $type_id = $_POST['type_price'];
        $this->model->update_type_price($prod_id, $type_id);
        //Check price for empy and add info in DB
        if (isset($_POST['price']) && !empty($_POST['price'])){
          $price = $_POST['price'];
          $to_date = "2038-01-17";
          $from_date = date("Y-m-d");
          if (isset($_POST['to_date']) && !empty($_POST['to_date'])){
            $to_date = $_POST['to_date'];
           
          }
          if (isset($_POST['from_date']) && !empty($_POST['from_date'])){
            $from_date = $_POST['from_date'];
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
