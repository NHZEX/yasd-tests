<?php

use Imi\Server\Http\Middleware\RouteMiddleware;
use Imi\Server\Session\Handler\File;
use Imi\Server\Session\Middleware\HttpSessionMiddleware;
use MyApp\MainServer\Middleware\PoweredBy;
use MyApp\Service\ExceptionHandler;

return [
    'configs'    =>    [
    ],
    // bean扫描目录
    'beanScan'    =>    [
        'MyApp\MainServer\Controller',
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
        'HttpRoute' => [
            // url匹配缓存数量，默认1024
            'urlCacheNumber' => 1024,
            // 全局忽略 URL 路由大小写
            'ignoreCase'     => false,
            // 全局支持智能尾部斜杠，无论是否存在都匹配
            'autoEndSlash'   => false,
        ],
        'HtmlView'    =>    [
            'templatePath'    =>    dirname(__DIR__) . '/template/',
            // 支持的模版文件扩展名，优先级按先后顺序
            'fileSuffixs'        =>    [
                'tpl',
                'html',
                'php'
            ],
        ],
        'JsonView'    =>     [
            'options' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        ],
        'HttpErrorHandler' => [
            'handler' => ExceptionHandler::class,
        ],
        ExceptionHandler::class    =>    [
            // debug 为 false时也显示错误信息
            'releaseShow'    =>    false,
            // 取消继续抛出异常，也不会记录日志
            'cancelThrow'    =>    false,
        ],
    ],
];