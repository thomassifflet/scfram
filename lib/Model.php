<?php
/**
 * Created by PhpStorm.
 * User: hikiyo
 * Date: 24/03/17
 * Time: 11:57
 */

namespace SCFram\Lib;
use \PDO;


/**
 * Class Model
 * Logique metier du framework
 * @package SCFram\Lib
 */
abstract class Model
{

    private $_login;
    private $_pwd;
    private $_email;
    private static $_db;

    private $_table = "user";


    /**
     * @param $q condition de la reauete
     * @param $tab valeur recherchee
     * @return array
     */
    public function findOne($q, $tab)
    {
        $sql = 'SELECT * FROM ' .$this->_table. ' WHERE ' .$q;
        $result = self::getDB()->prepare($sql);
        $result->execute($tab);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @param $login login utilisateur
     * @param $pwd mot de passe utilisateur
     * @param $email email utilisateur
     */
    public function create($login, $pwd, $email)
    {
        $sql = "INSERT INTO " .$this->_table. "(login, pwd, email, date_inscription) VALUES(:login, :pwd, :email, NOW())";
        $result = self::getDB()->prepare($sql);
        $result->bindParam(":login", $this->setLogin($login));
        $result->bindParam(":pwd", $this->setPwd($pwd));
        $result->bindParam(":email", $this->setEmail($email));
        $result->execute();
    }


    /**
     * @param $q condition requete
     * @param $tab valeur requete
     * @return array tableau des valeurs renvoyees
     */
    public function read($q, $tab)
    {
        $sql = "SELECT * FROM " .$this->_table. " WHERE " .$q;
        $result = self::getDB()->prepare($sql);
        $result->execute($tab);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $column Colonne a mettre a jour
     * @param $value Valeur a mettre a jour
     */
    public function update($column, $value)
    {
        $sql = 'UPDATE ' .$this->_table. ' SET ' .$column. ' = ' .$value;
        $result = self::getDB()->prepare($sql);
        $result->execute();
    }


    /**
     * @param $cond condition requete
     * @param $value valeur a supprimer
     */
    public function delete($cond, $value)
    {
        $sql = 'DELETE FROM ' .$this->_table. 'WHERE ' .$cond. ' = ' .$value;
        $result = self::getDB()->prepare($sql);
        $result->execute($value);
    }

    public function getLogin()
    {
        return $this->_login;
    }

    public function getPwd()
    {
        return $this->_pwd;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setLogin($_login)
    {
        $this->_login = $_login;
    }

    public function setPwd($_pwd)
    {
        $this->_pwd = $_pwd;
    }

    public function setEmail($_email)
    {
        $this->_email = $_email;
    }

    private function getDB()
    {
        if (self::$_db === null)
        {
            $login = Config::get("login");
            $dsn = Config::get("dsn");
            $pwd = Config::get("pwd");
            self::$_db = new PDO($dsn, $login, $pwd,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$_db;
    }

}