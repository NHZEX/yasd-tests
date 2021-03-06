<?php

namespace MyApp\Listener;

use Brick\VarExporter\VarExporter;
use Imi\Bean\Annotation\Listener;
use Imi\Db\Event\Param\DbExecuteEventParam;
use Imi\Event\EventParam;
use Imi\Event\IEventListener;
use Imi\Log\Log;

/**
 * Class DbExecuteListener
 * @package MyApp\Listener
 * @Listener("IMI.DB.EXECUTE")
 */
class DbExecuteListener implements IEventListener
{

    /**
     * @param DbExecuteEventParam|EventParam $e
     */
    public function handle(EventParam $e)
    {
        $vars = VarExporter::export($e->bindValues, VarExporter::INLINE_NUMERIC_SCALAR_ARRAY);
        $vars = preg_replace('/\s+/m', ' ', $vars);
        Log::debug(sprintf('[SQL Execute] %s (vars:%s) [%.5f]', $e->sql, $vars, $e->time));
    }
}