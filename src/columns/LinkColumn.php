<?php

namespace Hardland\LaravelTable\Columns;

use App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LinkColumn extends AbstractTableColumn
{
    public $url;

    public function __construct( $modelString, $modelColumn, Request $request, $url )
    {
        parent::__construct($modelString, $modelColumn, $request);
        $this->url = $url;
    }

    public function getTableColumn( Model $model)
    {
        $name = $this->getName();

        if(isset($this->foreignRelationshipModel)){
            $foreignRelationshipModel = $this->foreignRelationshipModel;
            return '<td><a href="' . $this->url . $model->$foreignRelationshipModel->id . '">' . $model->$foreignRelationshipModel->$name . "</a></td>";
        }

        if(isset($model->$name)){
            return '<td><a href="' . $this->url . $model->id . '">' . $model->$name . '</a></td>';
        }
        return "<td></td>";
    }
}
