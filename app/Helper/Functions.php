<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

function user_func(): string
{
    return 'hello';
}

if (!function_exists('getConsulServerId')) {
    /**
     * @param string $serverName
     * @return string
     */
    function getConsulServerId(string $serverName): string
    {
        $ip = env('HOST');
        return $serverName.'_'.$ip;
    }
}

