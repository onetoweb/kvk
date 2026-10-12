<?php

namespace Onetoweb\Kvk\Config;

enum BaseUri: string
{
    case LIVE = 'https://api.kvk.nl/api/v1/';
    case TEST = 'https://api.kvk.nl/test/api/v1/';
}
