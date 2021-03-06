<?php

namespace MyApp\Service\Log;

use Imi\Aop\Annotation\Aspect;
use Imi\Aop\Annotation\Before;
use Imi\Aop\Annotation\PointCut;
use Imi\Aop\JoinPoint;
use function MyApp\root_path;

/**
 * @Aspect
 * Class Logger
 */
class Logger
{
    /**
     * @PointCut(allow={"Imi\Log\Logger::log"})
     * @Before
     * @param JoinPoint $joinPoint
     */
    public function log(JoinPoint $joinPoint)
    {
        $args = $joinPoint->getArgs();
        $ctx = &$args[2];

        $path = root_path();
        if (isset($ctx['errorFile'])) {
            $ctx['errorFile'] = str_replace($path, '[MASK]/', $ctx['errorFile']);
        }
        if (isset($ctx['trace'])) {
            foreach ($ctx['trace'] as &$trace) {
                $trace['file'] = str_replace($path, '[MASK]/', $trace['file']);
            }
        }

        $joinPoint->setArgs($args);
    }
}