<?php

namespace Hardland\LaravelTable\Columns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ColumnInterface
{
    public function getDoctrineColumn();

    public function getRequestQuery( Builder $collection);

    public function getName();

    public function isText();

    public function isDate();

    public function isSelect();

    public function getDataType();

    public function getLength();

    public function getPercision();

    public function getTableHeader();

    public function getTableColumn( Model $model);

    public function getTableFilter();
}
