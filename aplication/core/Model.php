<?php
  namespace aplication\core;

  abstract class Model {
    public $params;
    public function __construct($params){
      $this->params=$params;
    }
}
?>
