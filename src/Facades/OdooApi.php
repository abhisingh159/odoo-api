<?php

namespace Codemusk\OdooApi\Facades;

use Illuminate\Support\Facades\Facade;

class OdooApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'odooapi';
    }
}
