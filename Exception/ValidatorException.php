<?php

namespace MyApp\Exception;

use Imi\Server\Http\Message\Response;
use InvalidArgumentException;

class ValidatorException extends InvalidArgumentException
{
    public function getResponse(): Response
    {
        return self::getResponse()
            ->withStatus(400)
            ->write("Validator: {$this->getMessage()}");
    }
}