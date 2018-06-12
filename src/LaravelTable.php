<?php

namespace Hardland\Services;

use Illuminate\Http\Request;

use Hardland\LaravelTable\Tables\AbstractTable;
use Hardland\LaravelTable\Tables\TableInterface;
use Hardland\LaravelTable\Tables\LinkTable;

class LaravelTable
{
    public function __construct()
    {

    }

    public function getLinkTable($modelString, array $tableColumns, Request $request){
        return new LinkTable($modelString, $tableColumns, $request);
    }
}
