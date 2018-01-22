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

    if(!isset($_SESSION)) session_start();
  }

  
  /**
   * Проверяет соответсвие введеных логина\пароля на соответсвие данным в БД
   *
   * @param string $login
   * @param string $password
   * @return void
   */
  public function auth(string $login, string $password) {
      $params = array($login);
      $query = $this->database->execute_statement('users_sellog',$params);

      if(!$query) {
        echo 'Логин не найден!';
      } else {
        $result = $this->database->users_sellog->fetch(PDO::FETCH_ASSOC);

        if(md5($password)!=$result['pass']) {
          echo 'Пароль неверен!';
        } else {
          if(!$result['activated']) {
            echo 'Аккаунт не активирован!';
          } else {
            $date = new DateTime();
            echo 'Вход успешен!';
            $_SESSION['login'] = $login;
            $_SESSION['auth'] = true;
            $this->database->execute_statement('users_update',array('loginday',$date->format('Y-m-d'),$login));
          }
        }
      }
  }

  /**
   * Заносит данные пользователя в БД, осуществляя регистрацию
   *
   * @todo Отправлять письмо на почту для активации аккаунта
   * 
   * @param string $login
   * @param string $password
   * @param string $brithday
   * @param string $email
   * @param string $gender
   * @param string $city
   * @param string $country
   * @return void
   */
  public function register(string $login, string $password, string $brithday, string $email, string $gender, string $city, string $country) {
    $regdate_raw = new DateTime();
    $regdate = $regdate_raw->format('Y-m-d');
    $pass = md5($password);

    // INSERT INTO users VALUES(login,password,email,group,gender,city,country,bd,rd,ld,rating,messages,comments,activated,code,avatar,theme)
    $params[] = array($login,$pass,$email,'user',$gender,$city,$country,$brithday,$regdate,'0000-00-00',0,0,0,false,'aaaaaaaaa','default.png','default');
    $query = $this->database->execute_statement('users_addnew',$params);

    if(!$query) {
      echo '(Сервер)Ошибка регистрации! '.$this->database->users_addnew->errorinfo();
    } else {
      echo 'Регистрация успешно завершена! Проверьте почту, мы выслали вам письмо для активации аккаунта.';
      //$this->other->send_email('acc_activation',$login);
    }
  }

  /**
   * Получает из БД данные выбранного пользователя
   *
   * @param string $login
   * @return array $data
   */
  public function get_userdata(string $login) {
    $params[] = array($login);
    $result = $this->database->execute_statement('users_selsafe',$params);
    
    if(!$query) {
      $data[] = array('Error');
    } else {
      $data[] = $this->database->users_selsafe->fetch(PDO::FETCH_ASSOC);
    }

    return $data;
  }

  /**
   * Выполняет активацию аккаунта по шифр-коду
   *
   * @param string $code
   * @return void
   */
  public function account_activation(string $code) {
    $params[] = array(true,$code);
    $result = $this->database->execute_statement('users_updact',$params);

    if(!$result) {
      echo 'Ошибка активации.';
    } else {
      echo 'Аккаунт успешно активирован! <a href="/?p=login">Войти</a>';
    }
  }

  public function reset_password(string $login, string $code) {
    
  }

}