<?php
declare(strict_types=1);

namespace Meteomatics\Weather\Api;

interface ConfigInterface
{
    const ACTIVE    = 'meteomatics/general/active';
    const SERVER    = 'meteomatics/webapi/server';
    const LOGIN     = 'meteomatics/webapi/login';
    const PASSWORD  = 'meteomatics/webapi/password';
    const LATITUDE  = 'meteomatics/webapi/latitude';
    const LONGITUDE = 'meteomatics/webapi/longitude';
    const FORMAT    = 'meteomatics/webapi/format';
}
