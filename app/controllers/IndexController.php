<?php
/**
 * Created by PhpStorm.
 * User: hikiyo
 * Date: 20/03/17
 * Time: 13:22
 */

namespace SCFram\App\Controllers;


use SCFram\App\Models\UserTable;
use SCFram\Lib\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        $userTable = new UserTable();
        $userlist = $userTable->findOne("login=?", ["root"]);

        $this->render('index.html', ["user" => $userlist]);
    }

    public function wtf($params)
    {
        if (isset($_GET['params']))
        {
            echo "WTF {$params}";
        }
    }


}