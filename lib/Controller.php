<?php


namespace SCFram\Lib;


use \Twig_Loader_Filesystem;
use \Twig_Environment;

define ("ROOT", dirname(__DIR__));

/**
 * Class Controller
 * @package SCFram\Lib
 * Controlleur du framework redirige les requetes
 */
abstract class Controller
{

    protected $twig;
    protected $layout = "default";
    public function __construct()
    {
        $className = substr(get_class($this), 23, -10);
        $loader = new Twig_Loader_Filesystem(ROOT. '/app/views/' .strtolower($className));
        $this->twig = new Twig_Environment($loader, array(
            'cache' => false, 
        ));
    }


    /**
     * @param $filename fichier de vue a charger
     * @param array $data donnees a passer a la vue
     */
    public function render($filename, $data = [])
    {
//        extract($data);
//        $tab = [];
//        preg_match_all("/{{(.*?)}}/", $filename, $tab);
//        for ($i = 0; $i < count($tab[0]); $i++)
//        {
//            $index = trim(substr($tab[0][$i], 2, -2));
//            if (isset($data[$index]))
//            {
//                $filename = str_replace($tab[0][$i], $data[$index], $filename);
//            }
//        }
        extract($data);
        echo $this->twig->render($filename, $data);
    }

}