<?php

use Imi\Db\Pool\CoroutineDbPool;
use Imi\Db\Pool\SyncDbPool;
use Imi\Redis\CoroutineRedisPool;
use Imi\Redis\SyncRedisPool;
use MyApp\Exception\ValidatorException;
use function MyApp\env;
use function MyApp\root_path;

return [
    // 项目根命名空间
    'namespace'    =>    'MyApp',
    'runtimePath'  =>    root_path('.runtime'),

    // 配置文件
    'configs'    =>    [
        'beans'        =>    __DIR__ . '/beans.php',
    ],

    // 扫描目录
    'beanScan'    =>    [
        'MyApp\Listener',
        'MyApp\Task',
        'MyApp\Service',
    ],

    // 组件命名空间
    'components'    =>  [
    ],

    // 主服务器配置
    'mainServer'    =>    [
        'namespace'    =>    'MyApp\MainServer',
        'type'        =>    Imi\Server\Type::HTTP,
        'host'        =>    '0.0.0.0',
        'port'        =>    9988,
        'configs'    =>    [
            // 'worker_num'        =>  8,
            // 'task_worker_num'   =>  16,
            'package_max_length' => 1024 * 1024 * 20,
        ],
    ],

    // 子服务器（端口监听）配置
    'subServers'        =>    [
        // 'SubServerName'   =>  [
        //     'namespace'    =>    'ImiApp\XXXServer',
        //     'type'        =>    Imi\Server\Type::HTTP,
        //     'host'        =>    '127.0.0.1',
        //     'port'        =>    13005,
        // ]
    ],

    // 连接池配置
    'pools'    =>    [
        // 主数据库
        'maindb' => [
            'pool'     => [
                // 同步池类名
                'syncClass'  => SyncDbPool::class,
                // 协程池类名
                'asyncClass' => CoroutineDbPool::class,
                // 连接池配置
                'config'     => [
                    // 池子中最多资源数
                    'maxResources' => 3,
                    // 池子中最少资源数
                    'minResources' => 0,
                    // 资源回收时间间隔，单位：秒
                    // 'gcInterval' => 60,
                    // 获取资源最大存活时间，单位：秒
                    // 'maxActiveTime' => 3600,
                    // 等待资源最大超时时间，单位：毫秒
                    // 'waitTimeout' => 3000,
                    // 心跳时间间隔，单位：秒
                    // 'heartbeatInterval' => null,
                    // 当获取资源时，是否检查状态
                    // 'checkStateWhenGetResource' => true,
                    // 每次获取资源最长使用时间，单位：秒；为 null 则不限制
                    // 'maxUsedTime' => null,
                    // 当前请求上下文资源检查状态间隔，单位：支持小数的秒；为 null 则不限制
                    // 'requestResourceCheckInterval' => 30,
                    // 负载均衡-轮流
                    // 'resourceConfigMode' => ResourceConfigMode::TURN,
                    // 负载均衡-随机
                    // 'resourceConfigMode' => ResourceConfigMode::RANDOM,
                ],
            ],
            // 连接池资源配置
            'resource' => [
                'host'     => env('MAIN_DB_HOST', '127.0.0.1'),
                'port'     => (int) env('MAIN_DB_PORT', 3306),
                'username' => env('MAIN_DB_USERNAME', 'root'),
                'password' => env('MAIN_DB_PASSWORD', 'password'),
                'database' => env('MAIN_DB_DATABASE', 'dbname'),
                'charset'  => 'utf8mb4',
            ],
        ],
        'redis' => [
            'pool'     => [
                // 同步池类名
                'syncClass'  => SyncRedisPool::class,
                // 协程池类名
                'asyncClass' => CoroutineRedisPool::class,
                // 连接池配置
                'config'     => [
                    'maxResources' => 3,
                    'minResources' => 0,
                ],
            ],
            // 连接池资源配置
            'resource' => [
                'host'      => env('REDIS_HOST', '127.0.0.1'),
                'port'      => (int) env('REDIS_PORT', 6379),
                'password'  => null,
            ],
        ],
    ],

    // 数据库配置
    'db'    =>    [
        // 数默认连接池名
        'defaultPool'    =>    'maindb',
    ],

    // redis 配置
    'redis' =>  [
        // 数默认连接池名
        'defaultPool'   =>  'redis',
    ],

    // 内存表配置
    'memoryTable'   =>  [
        // 't1'    =>  [
        //     'columns'   =>  [
        //         ['name' => 'name', 'type' => \Swoole\Table::TYPE_STRING, 'size' => 16],
        //         ['name' => 'quantity', 'type' => \Swoole\Table::TYPE_INT],
        //     ],
        //     'lockId'    =>  'atomic',
        // ],
    ],

    // 锁
    'lock'  =>[
        // 'list'  =>  [
        //     'atomic' =>  [
        //         'class' =>  'AtomicLock',
        //         'options'   =>  [
        //             'atomicName'    =>  'atomicLock',
        //         ],
        //     ],
        // ],
    ],

    // atmoic 配置
    'atomics'    =>  [
        // 'atomicLock'   =>  1,
    ],

    // 验证器
    'validation' => [
        'exception' => ValidatorException::class,
    ],
];