<?php

namespace Its\Example\Dashboard\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $db = $this->getDI()->get('db');

        $sql = "";

        $result = $db->fetchOne($sql, \Phalcon\Db\Enum::FETCH_ASSOC);

        echo var_dump($result);
    }
}