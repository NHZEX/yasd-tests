<?php

namespace MyApp\Service;

use Imi\App;
use Imi\RequestContext;
use Imi\Server\Http\Error\IErrorHandler;
use Imi\Server\Http\Message\Response;
use Imi\Util\Http\Consts\MediaType;
use Imi\Util\Http\Consts\ResponseHeader;
use MyApp\Exception\ValidatorException;
use Throwable;
use function MyApp\root_path;
use const PHP_EOL;

class ExceptionHandler implements IErrorHandler
{
    /**
     * debug 为 false时也显示错误信息.
     *
     * @var bool
     */
    protected $releaseShow = false;

    /**
     * 取消继续抛出异常.
     *
     * @var bool
     */
    protected $cancelThrow = false;

    /**
     * 捕获错误
     * 返回值为 true 则取消继续抛出异常.
     *
     * @param Throwable $throwable
     *
     * @return bool
     */
    public function handle(Throwable $throwable): bool
    {
        if ($throwable instanceof ValidatorException) {
            $throwable->getResponse()->send();
            return false;
        }

        return $this->formatException($throwable);
    }

    private function formatException(Throwable $throwable): bool
    {
        if ($this->releaseShow || App::isDebug()) {
            $data = $this->formatTrace($throwable);
        } else {
            $data = [
                'success' => false,
                'message' => "{$throwable->getMessage()} [{$throwable->getCode()}]",
            ];
        }

        $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
        $body = str_replace(root_path(), '[MASK]', $body);
        $body = str_replace('MyApp', 'App', $body);

        /** @var Response $response */
        $response = RequestContext::get('response');
        $response->withHeader(ResponseHeader::CONTENT_TYPE, MediaType::APPLICATION_JSON)
            ->withStatus(500)
            ->write($body)
            ->send();

        return $this->cancelThrow;
    }

    private function formatTrace(Throwable $throwable): array
    {
        $result = [
            'message'   => $throwable->getMessage(),
            'code'      => $throwable->getCode(),
            'file'      => $throwable->getFile(),
            'line'      => $throwable->getLine(),
            'class'     => get_class($throwable),
            'traces'    => [],
        ];
        do {
            $trace = explode(PHP_EOL, $throwable->getTraceAsString());
            if (count($result['traces']) > 0) {
                $classname = get_class($throwable);
                $trace = array_merge([
                    "message: {$throwable->getMessage()}",
                    "code: {$throwable->getCode()}",
                    "file: {$throwable->getFile()}#L{$throwable->getLine()}",
                    "class: {$classname}",
                ], $trace);
            }
            $result['traces'][] = $trace;
        } while ($throwable = $throwable->getPrevious());

        return $result;
    }
}