<?php
/**
 * Файл системы пользователей
 * 
 * Файл содержит функции для обеспечения работы системы пользователей
 * @author LoneSimba <silet-stalker99@yandex.ru>
 * @version 0.1
 * @package RCSE
 */

 /**
  * Подключение database.php
  */
  require_once("./database.php");

 /**
  * Обеспечивает работу системы пользователей
  * 
  * @package RCSE
  * @subpackage Usersystem
  */
class User {
  
  public $database;

  /**
   * Конструктор класса User
   */
  public function __construct() {
    $this->database = new Database();
  }

  
  /**
   * Проверяет соответсвие введеных логина\пароля на соответсвие данным в БД
   *
   * @param string $login     имя пользователя
   * @param string $password  пароль
   * @return void
   */
  public function authorization(string $login, string $password) {
      $params = array($login);
      $this->database->execute_statement($params);

  }

}