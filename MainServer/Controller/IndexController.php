<?php
namespace MyApp\MainServer\Controller;

use Imi\Controller\HttpController;
use Imi\Db\Db;
use Imi\Server\Route\Annotation\Action;
use Imi\Server\Route\Annotation\Controller;
use Imi\Server\Route\Annotation\Route;
use Imi\Server\View\Annotation\View;

/**
 * @Controller("/")
 * @View(baseDir="index/")
 */
class IndexController extends HttpController
{
    /**
     * @Action
     * @Route("/")
     *
     * @return array
     */
    public function index()
    {
        return [
            'hello' =>  'imi1',
            'time'  =>  date('Y-m-d H:i:s', time()),
        ];
    }

    /**
     * @Action
     * @return array
     */
    public function api($time)
    {
        $status = Db::query()->execute('SHOW STATUS');
        return [
            'hello' =>  'imi2',
            'info' => $status->getArray(),
            'time'  =>  date('Y-m-d H:i:s', time()),
        ];
    }

}
