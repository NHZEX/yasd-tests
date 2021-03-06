<?php

use Imi\Server\Http\Middleware\RouteMiddleware;
use Imi\Server\Session\Handler\File;
use Imi\Server\Session\Middleware\HttpSessionMiddleware;
use ImiApp\ApiServer\Middleware\PoweredBy;

return [
    'configs'    =>    [
    ],
    // bean扫描目录
    'beanScan'    =>    [
        'ImiApp\ApiServer\Controller',
    ],
    'beans'    =>    [
        'SessionManager'    =>    [
            'handlerClass'    =>    File::class,
        ],
        'SessionFile'    =>    [
            'savePath'    =>    dirname(__DIR__, 2) . '/.runtime/.session/',
        ],
        'SessionConfig'    =>    [

        ],
        'SessionCookie'    =>    [
            'lifetime'    =>    86400 * 30,
        ],
        'HttpDispatcher'    =>    [
            'middlewares'    =>    [
                PoweredBy::class,
                HttpSessionMiddleware::class,
                RouteMiddleware::class,
            ],
        ],
        'HtmlView'    =>    [
            'templatePath'    =>    dirname(__DIR__) . '/template/',
            // 支持的模版文件扩展名，优先级按先后顺序
            'fileSuffixs'        =>    [
                'tpl',
                'html',
                'php'
            ],
        ]
    ],
];