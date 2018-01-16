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
 * Обеспечивает взаимодействие движка и PDO
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
     * Конструктор Database
     * 
     * @todo Получать имя БД, адрес хоста, логин и пароль СУБД из файла конфигурации
     */
    public function __construct()
    {

        $dbinfo = 'mysql:dbname=rcse;host=127.0.0.1';
        $dbuser;
        $dbpass;

        try
        {
            $this->database = new PDO($dbinfo, 'root', '',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        }
        catch(PDOException $e)
        {
            print('Error: '. $e->getMessage() . '<br>');
        }

        $this->prepare_statemets();
    }

    /**
     * Выполняет подготовку существующих запросов
     *
     * @return void
     */
    private function prepare_statemets()
    {
        $this->users_selectall = $this->database->prepare("SELECT * FROM users");
        $this->users_select = $this->database->prepare("SELECT * FROM users WHERE login=?");

        $this->news_selectall = $this->database->prepare("SELECT * FROM news");

        $this->comments_selectall = $this->database->prepare("SELECT * FROM comments");

        $this->topics_selectall = $this->database->prepare("SELECT * FROM topics");

        $this->bans_selectall = $this->database->prepare("SELECT * FROM  bans");
    }

    /**
     * Выполняет запрос, указанный в $type
     *
     * @param string $type   Тип запроса
     * @param array  $params Массив параметров для запроса
     * @return void
     */
    public function execute_statement(string $type, array $params)
    {

        switch($type)
        {
            case 'users_selall':
                $this->users_selectall->execute();
                break;
            case 'users_sel':
                $this->user_select->execute($params[0]);
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
     * @param string $table Таблица, к которй идет запрос
     * @param string $statement SQL-запрос
     * @return void
     * @todo Вывод сообщения об ошибке в браузер через модальное окно
     */
    private function prepare_statement_udef(string $table, string $statement)
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