<?php
/**
 * Created by PhpStorm.
 * User: hikiyo
 * Date: 19/03/17
 * Time: 15:15
 */


namespace SCFram\Lib;
use \Exception;


/**
 * Class Config
 * @package SCFram\Lib
 * Classe de configuration du Framework
 */
class Config
{
    private static $params;


    /**
     * @param $name nom de la valeur dans le fichier de configuration
     * @param null $defaultValue valeur par defaut
     * @return null valeurs recherchees
     */
    public  static function get($name, $defaultValue = null)
    {
        if (isset(self::getParams()[$name]))
        {
            $value = self::getParams()[$name];
        }
        else
        {
            $value = $defaultValue;
        }
        return $value;
    }

    /**
     * @return array tableau des valeurs du fichier de config
     * @throws Exception retourne une exception si aucun fichier trouve
     */
    private static function getParams()
    {
        if (self::$params == null)
        {
            $filePath = dirname(__DIR__) . "/lib/config/config.ini";
            if (!file_exists($filePath))
            {
                $filePath = "config/configdev.ini";
            }
            if (!file_exists($filePath))
            {
                throw new Exception("Aucun fichier de config trouve");
            }
            else
            {
                self::$params = parse_ini_file($filePath);
            }
        }
        return self::$params;
    }
}