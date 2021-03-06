<?php
namespace MyApp;

use Env\Env;
use Imi\App;
use Imi\Main\AppBaseMain;

class Main extends AppBaseMain
{
    public function __init()
    {
        $this->initEnvOptions();
        $this->setDebugMode();
    }

    private function initEnvOptions()
    {
        Env::$options = Env::CONVERT_BOOL | Env::CONVERT_NULL;
    }

    private function setDebugMode()
    {
        App::setDebug(is_debug());
    }
}