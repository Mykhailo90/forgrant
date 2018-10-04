<?php

namespace aplication\lib;

/*
* Класс получает из массива данных список возможных адресов и возвращает в контроллер
* The class gets a list of possible URL addresses from the array and returns it to the controller
*/

Class ParentPath {
// Переменная для хранения адресов
// Variable for storing URL addresses
  public $arr = ['#^$#',];

  private function getArray(){
    return $this->arr;
  }
}
