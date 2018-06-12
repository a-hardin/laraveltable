<?php

namespace Hardland\LaravelTable\Columns;

use App;

use Illuminate\Support\Facades\DB;

class TableColumn
{
    protected $doctrineColumn;
    public $relatedTable = null;
    public $relatedColumn = null;
    public $relationshipClass = null;
    public $modelColumn;
    public $modelString;
    public $modelTable;
    public $currentValue;
    public $request;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct( $modelString, $modelColumn, $request )
    {
        $this->modelString = $modelString;
        $this->modelTable = explode('"', $this->modelString::query()->toSql())[1];;
        $this->modelColumn = $modelColumn;
        $this->doctrineColumn = $this->getDoctrineColumn();
        $this->request = $request;
    }

    private function getDoctrineColumn()
    {
        $columnArray = explode('.', $this->modelColumn);
        $modelTable = $this->modelTable;
        $column = $this->modelColumn;

        // Determine if the column is a foreign column
        if(count($columnArray) > 1)
        {
            $this->foreignRelationshipModel = $columnArray[0];
            $this->relatedColumn = $columnArray[1];
            $column = $this->relatedColumn;
            $this->relatedTable = $this->modelString::with($this->relatedTable)->getRelation($this->relatedTable)->getRelated()->getTable();
            $this->relationshipClass = get_class($this->modelString::with($this->relatedTable)->getRelation($this->relatedTable));
            $modelTable = $this->relatedTable;
        }

        return DB::connection()->getDoctrineColumn($modelTable, $column);
    }

    // #TODO create a colum request class
    public function getRequestQuery($collection)
    {
        $relatedColumn = $this->relatedColumn;
        $column = $this->modelColumn;

        if(isset($this->request->$relatedColumn))
        {
            $arr = [$relatedColumn, 'like', '%'. $this->request->$relatedColumn . '%'];
            return $collection->whereHas($relatedColumn, function($query) use ($arr) {
                $query->where($arr);
            });
        }

        if(isset($this->request->$column))
        {
            return $collection->where([$column, 'like', '%' . $this->request->$column . '%']);
        }

        return $collection;

    }

    public function getName()
    {
        return $this->doctrineColumn->getName();
    }

    public function isText()
    {
        $dataType = $this->getDataType();
        if($dataType == 'boolean' || $dataType == 'date' || $dataType == 'datetime' ){
            return false;
        }
        return true;
    }

    // // data types could be string, text, integer, boolean, float, date, datetime
    public function getDataType()
    {
        return $this->doctrineColumn->getType()->getName();
    }

    public function getLength()
    {
        return $this->doctrineColumn->getLength();
    }

    public function getPercision()
    {
        return $this->doctrineColumn->getPrecision();
    }

    public function getTableHeader()
    {
        return "<th>" . ucfirst($this->getName()) . "</th>";
    }

    // @TODO create table filter class
    public function getTableFilter()
    {
        $length = $this->getLength();
        if(isset($length)){
            return '<input name="' . $this->getName() . '" type="text" maxlength="' . $this->getlength() . '" value';
        }
        return '<input name="' . $this->getName() . '" type="text" maxlength="15" value';
    }

}
