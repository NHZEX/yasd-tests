<?php

namespace MyApp;

use Env\Env;

/**
 * @param string|null $name
 * @param mixed $default
 * @return mixed
 */
function env(string $name = null, $default = null)
{
    return Env::get($name) ?? $default;
}

function root_path(?string $dirname = null): string
{
    return __DIR__ . DIRECTORY_SEPARATOR . ltrim($dirname, DIRECTORY_SEPARATOR);
}

function is_debug(): bool
{
    return \MyApp\env('IMI_DEBUG', false);
}