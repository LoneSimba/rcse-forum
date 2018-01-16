<?php
/**
 * Файл с основнымы взаимодействиями с БД
 * 
 * В этом файле размещены основные функции взаимодействия с БД, работает через СУБД PDO
 * @author LoneSimba <siluet-stalker99@yandex.ru>
 * @version 0.1
 * @package RCSE
 */

/**
 * Класс взамиодействий с БД
 * 
 * @package RCSE
 * @subpackage Database
 */
class Database {

    /*
     * Запросы
     */

    public $users_selectall;
    public $users_select;
    public $users_addnew;
    public $users_update;
    public $users_remove;

    public $news_selectall;
    public $news_select;
    public $news_addnew;
    public $news_update;
    public $news_remove;

    public $comments_selectall;
    public $comments_select;
    public $comments_addnew;
    public $comments_update;
    public $comments_remove;

    public $topics_selectall;
    public $topics_select;
    public $topics_addnew;
    public $topics_update;
    public $topics_remove;

    public $bans_selectall;
    public $bans_select;
    public $bans_addnew;
    public $bans_update;
    public $bans_remove;

    public $userdef;

    /*
     * Экземпляры класса 
     */

    private $database;

    /**
     * @todo Получать имя БД, адрес хоста, логин и пароль СУБД из файла конфигурации
     */
    public function __construct()
    {

        $dbinfo = 'mysql:dbname=rcse;host=127.0.0.1';
        $dbuser;
        $dbpass;

        try
        {
            $this->database = new PDO($dbinfo, 'root', '',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); // Изменить: вместо 'root' и '' подставлять переменные $dbuser и $dbpass
        }
        catch(PDOException $e)
        {
            print('Error: '. $e->getMessage() . '<br>');
        }

        $this->prepare_statemets();
    }


    /**
     * Выполняет подготовку запросов к БД
     * 
     * @todo Добавить все указанные в списке переменных запросы
     */
    private function prepare_statemets()
    {
        $this->users_selectall = $this->database->prepare("SELECT * FROM users");

        $this->news_selectall = $this->database->prepare("SELECT * FROM news");

        $this->comments_selectall = $this->database->prepare("SELECT * FROM comments");

        $this->topics_selectall = $this->database->prepare("SELECT * FROM topics");

        $this->bans_selectall = $this->database->prepare("SELECT * FROM  bans");
    }

    /**
     * Выполняет выбранный запрос
     * 
     * @param   string        $type     Тип запроса(см. переменные в начале файла)
     * @param   array|string  $params   Параметры, используемые запросом
     * @todo Добавить все указанные в списке переменных запросы
     */
    public function execute_statement(string $type, array $params)
    {

        switch($type)
        {
            case 'users_selall':
                $this->users_selectall->execute();
                break;
            case 'news_selall':
                $this->news_selectall->execute();
                break;
            case 'topics_selall':
                $this->topics_selectall->execute();
                break;
            case 'bans_selall':
                $this->bans_selectall->execute();
                break;
            default:
                print('Не выбран тип запроса!');
                break;
        }

    }


    /**
     * Выполняет подготовку запроса, отличного от стандартных
     * 
     * @param   string  $statement  SQL запрос
     * @todo Организовать вывод сообщения об ошибке на страницу, возможно через JS (alarm)
     */
    private function prepare_statement_udef(string $statement)
    {
        switch($table)
        {
            case 'users':
            case 'bans':
            case 'topics':
            case 'comments':
            case 'news':
                print('Нельзя подготовить запрос - эти запросы уже подготовлены!');
                return;
                break;
            default:
                $this->udef_selall = $this->database->prepare($statement);
                break;
        }

    }
}