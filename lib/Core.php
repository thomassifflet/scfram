<?php
/**
 * Created by PhpStorm.
 * User: hikiyo
 * Date: 20/03/17
 * Time: 13:20
 */


namespace SCFram\Lib;

use \Exception;


/**
 * Class Core Kernel du framework
 * @package SCFram\Lib
 */
class Core
{
    public $conf = [];
    private static $params;


    /**
     * Fonction de lancement du kernel
     * Contient le routeur
     */
    public static function run()
    {
        try
        {
            Core::registerAutoload();

            $class = "SCFram\\App\\Controllers\\" . (isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'IndexController');
            $target = isset($_GET['t']) ? $_GET['t'] : "indexAction";
            $getParams = isset($_GET['params']) ? $_GET['params'] : null;
            $postParams = isset($_POST['params']) ? $_POST['params'] : null;
            $params = [
                "get"  => $getParams,
                "post" => $postParams
            ];

            if (class_exists($class, true))
            {
                $class = new $class();
                if (in_array($target, get_class_methods($class))) {
                    call_user_func_array([$class, $target], $params);
                } else {
                    call_user_func([$class, "indexAction"]);
                }
            } 
            else 
            {
                require '404.php';
            }
        }
        catch (Exception $e)
        {
            if ($e instanceof NotFoundException)
            {
                header("HTTP 1.1 : 404 Not Found");
            }
            else
            {
                header("HTTP 1.1 : 500 Internal Server Error");
            }
        }
    }

    /**
     * Autoload du Kernel
     */
    public static function registerAutoload()
    {
        require '../vendor/autoload.php';
    }
}