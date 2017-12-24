<?php
/*
 * Класс взаимодействия с базой данных. Использует СУБД PDO.
 * Содержит - шаблоны запросов, метод формирования и отправки запроса.
 *
 */


class Database {

    // Шаблоны функций


    // Прочие переменные
    private $database;

    public function __construct()
    {

        $dbinfo = 'mysql:dbname=rcse-forum;host=127.0.0.1'; // Изменить: в dbname сделать получение из конфига

        try
        {
            $database = new PDO($dbinfo, 'root', '',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        }
        catch(PDOException $e)
        {
            print('Error: '. $e->getMessage() . '<br>');
        }
        
        self::prepare_statemets();
    }

    private function prepare_statemets()
    {

    }
}