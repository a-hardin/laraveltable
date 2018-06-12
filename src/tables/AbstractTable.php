<?php

namespace Hardland\LaravelTable\Tables;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Hardland\LaravelTable\Columns\TableColumn;
use Hardland\LaravelTable\Columns\LinkColumn;
use Hardland\LaravelTable\Columns\PlainColumn;

abstract class AbstractTable implements TableInterface
{

    // String
    private $request;
    // Elequent
    private $collection;
    // String
    private $modelString;
    // String
    private $modelTable;
    // String
    private $actionButton;
    // key value array
    private $currentValues;
    // String
    private $toastMessage;
    // Array
    private $tableColumnStringArray = [];
    // Array
    private $tableColumnObjectArray = [];
    // Array
    private $hiddenInputArray;
    // Array
    private $constrantArray = [];
    // Array
    private $linkColumnArray = [];
    // Boolean
    private $checkbox = false;
    // Boolean
    private $tableFilters = false;


    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct( $modelString, array $tableColumns, Request $request=null )
    {
        $this->modelString = $modelString;
        $this->modelTable = explode('"', $this->modelString::query()->toSql())[1];
        $this->tableColumnStringArray = $tableColumns;
        $this->request = $request;
        $this->collection = $this->getCollection();
    }

    private function getCollection()
    {
        $this->setTableColumnObjectArray();
        $collection = $this->modelString::query();
        foreach($this->tableColumnObjectArray as $tableColumn) {
            $collection = $tableColumn->getRequestQuery($collection);
        }

        foreach ($this->constrantArray as $key => $value) {
            $collection->where($key, '=', $value);
        }

        $collection = $collection->paginate(5);
        return $collection;
    }

    public function setTableColumnObjectArray(){
        $this->tableColumnObjectArray = [];
        foreach($this->tableColumnStringArray as $tableColumn) {
            if(array_key_exists ($tableColumn, $this->linkColumnArray)) {
                $this->tableColumnObjectArray[] = new LinkColumn($this->modelString, $tableColumn, $this->request, $this->linkColumnArray[$tableColumn]);
            }else {
                $this->tableColumnObjectArray[] = new PlainColumn($this->modelString, $tableColumn, $this->request);
            }
        }
    }

    public function setHiddenInputs(array $hiddenInputArray)
    {
        $this->hiddenInputArray = $hiddenInputArray;
    }

    public function setConstrantArray( array $constrantArray)
    {
        $this->constrantArray = $constrantArray;
        $this->collection = $this->getCollection();
    }

    public function setLinkColumnArray( array $linkColumnArray)
    {
        $this->linkColumnArray = $linkColumnArray;
        $this->collection = $this->getCollection();
    }

    // Add for Assignment Table
    /*
    public function setCheckbox( bool $checkbox)
    {
        $this->checkbox = $checkbox;
    }
    */

    public function setTableFilters( bool $tableFilters)
    {
        $this->tableFilters = $tableFilters;
    }

    public function getHiddenInputView()
    {
        return view('laraveltable::hiddenInputs', array(
            'tableColumns' => $this->tableColumnObjectArray,
            'hiddenInputs' => $this->hiddenInputArray
        ))->render();
    }

    public function getTheadView()
    {
        return view('laraveltable::thead', array(
            'request' => $this->request,
            'checkbox' => $this->checkbox,
            'tableFilters' => $this->tableFilters,
            'tableColumns' => $this->tableColumnObjectArray,
            // 'actionButtons' => $actionButtons
        ))->render();
    }

    public function getTbodyView()
    {
        return view('laraveltable::tbody', array(
            'collection' => $this->collection,
            'checkbox' => $this->checkbox,
            'tableColumns' => $this->tableColumnObjectArray,
            // 'actionButtons' => $actionButtons
        ))->render();
    }

    public function getPaginateView()
    {
        return view('laraveltable::paginate', array(
            'collection' => $this->collection,
        ))->render();
    }

    public function getToastMessage()
    {
        return null;
    }

    public function buildJson()
    {
        return response()->json([
            'title' => $this->hiddenInputArray['title'],
            'hiddenInputs' => $this->getHiddenInputView(),
            'thead' => $this->getTheadView(),
            'tbody' => $this->getTbodyView(),
            'paginate' => $this->getPaginateView(),
            'parentSelector' => $this->hiddenInputArray['parentSelector'],
            'toastMessage' => $this->getToastMessage()
        ]);
    }

}
